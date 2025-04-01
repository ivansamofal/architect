<?php

declare(strict_types=1);

namespace App\Service\Tracing;

use OpenTelemetry\SDK\Trace\SpanExporterInterface;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Common\Future\FutureInterface;
use OpenTelemetry\SDK\Common\Future\CancellationInterface;
use Psr\Log\LoggerInterface;

class CustomJaegerExporter implements SpanExporterInterface
{
    private string $endpoint;

    /**
     *
     * @param string $endpoint
     */
    public function __construct(string $endpoint, private readonly LoggerInterface $logger)
    {
        $this->endpoint = $endpoint;
    }

    /**
     *
     * @param iterable<SpanDataInterface> $batch
     * @param CancellationInterface|null $cancellation
     * @return FutureInterface<bool>
     */
    public function export(iterable $batch, ?CancellationInterface $cancellation = null): FutureInterface
    {
        $payload = $this->mapPayload($batch);
        try {
            $success = $this->sendRequest($payload);
            return new ImmediateFuture($success);
        } catch (\Throwable $e) {
            $this->logger->error("Error during sending request to jaeger. cause: {$e->getMessage()}");
            return new ImmediateFuture(ExporterResultCode::FAILED_NOT_RETRYABLE);
        }
    }

    public function shutdown(?CancellationInterface $cancellation = null): bool
    {
        return true;
    }

    public function forceFlush(?CancellationInterface $cancellation = null): bool
    {
        return true;
    }

    private function sendRequest(array $payload): int
    {
        $jsonPayload = json_encode($payload);
        if ($jsonPayload === false) {
            throw new \Exception('Invalid JSON in Jaeger sendRequest');
        }

        $ch = curl_init($this->endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonPayload)
        ]);

        $result = curl_exec($ch);
        if ($result === false) {
            $error = curl_error($ch);
            $this->logger->error("cURL error jaeger: " . $error);
            error_log("cURL error: " . $error);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpCode >= 200 && $httpCode < 300)
            ? ExporterResultCode::SUCCESS
            : ExporterResultCode::FAILED_NOT_RETRYABLE;
    }

    private function mapPayload(iterable $batch): array
    {
        $payload = [];

        foreach ($batch as $span) {
            $spanContext = $span->getContext();
            $parentContext = $span->getParentContext();
            $timestamp = (int) ($span->getStartEpochNanos() / 1000);
            $duration  = (int) (($span->getEndEpochNanos() - $span->getStartEpochNanos()) / 1000);

            $payload[] = [
                'traceId' => $spanContext->getTraceId(),
                'id' => $spanContext->getSpanId(),
                'name' => $span->getName(),
                'timestamp' => $timestamp,
                'duration' => $duration,
                'localEndpoint' => [
                    'serviceName' => $_ENV['JAEGER_NAME'] ?? 'my-symfony-app',
                ],
                'tags' => $span->getAttributes()->toArray(),
            ];
        }

        return $payload;
    }
}
