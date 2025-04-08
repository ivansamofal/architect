<?php

namespace App\Decorator;

use App\Factories\JaegerTracerFactory;
use OpenTelemetry\API\Trace\TracerInterface;
use Psr\Log\LoggerInterface;

class TraceDecorator
{
    private $traceProvider;
    private $tracer;

    public function __construct(
        private object $service,
        //        private TracerInterface $tracer,
        private LoggerInterface $logger,
    ) {
        $this->traceProvider = JaegerTracerFactory::createTracerProvider($this->logger);
        $jaegerName = $_ENV['JAEGER_NAME'] ?? 'my-symfony-app';
        $this->tracer = $this->traceProvider->getTracer($jaegerName);
    }

    public function __call(string $method, array $args): mixed
    {
        echo 44;
        //        $traceProvider = JaegerTracerFactory::createTracerProvider($this->logger);

        $span = $this->tracer->spanBuilder($method)->startSpan();
        try {
            return $this->service->$method(...$args);
        } finally {
            $span->end();
            $this->traceProvider->forceFlush();
            echo 66;
        }
    }
}
