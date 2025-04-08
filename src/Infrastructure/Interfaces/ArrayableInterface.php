<?php

namespace App\Infrastructure\Interfaces;

interface ArrayableInterface
{
    /** @return array<mixed> */
    public function toArray(): array;
}
