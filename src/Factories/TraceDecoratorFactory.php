<?php

namespace App\Factories;

use App\Decorator\TraceDecorator;
use App\Service\Interfaces\ProfileServiceInterface;
use Psr\Log\LoggerInterface;

class TraceDecoratorFactory
{
    public function __construct(
        private ProfileServiceInterface $profileService,
        private LoggerInterface $logger,
    ) {
    }

    public function decorate(): object
    {
        return new TraceDecorator($this->profileService, $this->logger);
    }
}
