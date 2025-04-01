<?php

declare(strict_types=1);

namespace App\Service\Tracing;

final class ExporterResultCode
{
    public const SUCCESS = 0;
    public const FAILED_NOT_RETRYABLE = 1;
}
