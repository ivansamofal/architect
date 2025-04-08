<?php

declare(strict_types=1);

namespace App\Service\Tracing;

use Closure;
use OpenTelemetry\SDK\Common\Future\FutureInterface;

class ImmediateFuture implements FutureInterface
{
    private $result;

    /**
     * ImmediateFuture constructor.
     *
     * @param mixed $result the value (or error) that this future immediately holds
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * Immediately returns the held result.
     */
    public function await()
    {
        return $this->result;
    }

    /**
     * Applies a closure to the result and returns a new ImmediateFuture with the transformed value.
     *
     * @psalm-template U
     *
     * @psalm-param Closure(mixed): U $closure
     *
     * @psalm-return FutureInterface<U>
     */
    public function map(\Closure $closure): FutureInterface
    {
        // If the result is an exception, do not apply map and just return itself.
        if ($this->result instanceof \Throwable) {
            return $this;
        }

        $mapped = $closure($this->result);

        return new self($mapped);
    }

    /**
     * If the result is an exception, applies the given closure to it and returns a new ImmediateFuture.
     * Otherwise, returns the current future.
     *
     * @psalm-template U
     *
     * @psalm-param Closure(\Throwable): U $closure
     *
     * @psalm-return FutureInterface<mixed|U>
     */
    public function catch(\Closure $closure): FutureInterface
    {
        if ($this->result instanceof \Throwable) {
            $recovered = $closure($this->result);

            return new self($recovered);
        }

        return $this;
    }
}
