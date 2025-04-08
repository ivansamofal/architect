<?php

namespace App\Factories;

use App\Service\Tracing\CustomJaegerExporter;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use Psr\Log\LoggerInterface;

class JaegerTracerFactory
{
    public static function createTracerProvider(LoggerInterface $logger): TracerProvider
    {
        if (empty($_ENV['JAEGER_COLLECTOR_URL'])) {
            throw new \Exception('JAEGER_COLLECTOR_URL is required');
        }
        $jaegerExporter = new CustomJaegerExporter($_ENV['JAEGER_COLLECTOR_URL'], $logger);
        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor($jaegerExporter)
        );

        return $tracerProvider;
    }

    public static function createTracer(LoggerInterface $logger): TracerInterface
    {
        if (empty($_ENV['JAEGER_NAME'])) {
            throw new \Exception('JAEGER_NAME is required');
        }
        $tracerProvider = self::createTracerProvider($logger);

        return $tracerProvider->getTracer($_ENV['JAEGER_NAME']);
    }
}
