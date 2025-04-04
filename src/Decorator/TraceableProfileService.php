<?php
namespace App\Decorator;

use App\Dto\LocationDto;
use App\Dto\ProfileDto;
use App\Entity\Profile;
use App\Service\Interfaces\ProfileServiceInterface;
use App\Factories\JaegerTracerFactory;
use Psr\Log\LoggerInterface;

class TraceableProfileService implements ProfileServiceInterface
{
    private ProfileServiceInterface $decorated;
    private LoggerInterface $logger;
    private $tracerProvider;
    private $tracer;
    private string $jaegerName;

    public function __construct(ProfileServiceInterface $decorated, LoggerInterface $logger)
    {
        $this->decorated = $decorated;
        $this->logger = $logger;
        $this->tracerProvider = JaegerTracerFactory::createTracerProvider($this->logger);
        $this->jaegerName = $_ENV['JAEGER_NAME'] ?? 'my-symfony-app';
        $this->tracer = $this->tracerProvider->getTracer($this->jaegerName);
    }

    /**
     * Helper to run a callable within a traced span.
     */
    private function withTrace(string $spanName, string $methodAttribute, callable $callback)
    {
        $span = $this->tracer->spanBuilder($spanName)->startSpan();
        $span->setAttribute('method', $methodAttribute);
        try {
            $result = $callback();
        } finally {
            $span->end();
            $this->tracerProvider->forceFlush();
        }
        return $result;
    }

    public function getList(): array
    {
        return $this->withTrace(
            'handle_getList',
            '/api/profiles',
            fn() => $this->decorated->getList()
        );
    }

    public function find(int $id): ?Profile
    {
        return $this->withTrace(
            'handle_find',
            '/api/profile',
            fn() => $this->decorated->find($id)
        );
    }

    public function saveLocation(LocationDto $dto)
    {
        $this->decorated->saveLocation($dto);
    }

    public function createProfile(ProfileDto $profileDto): Profile
    {
        return $this->withTrace(
            'handle_createProfile',
            '/api/profile/create',
            fn() => $this->decorated->createProfile($profileDto)
        );
    }
}
