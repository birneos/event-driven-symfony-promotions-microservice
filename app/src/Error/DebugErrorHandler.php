<?php

declare(strict_types=1);

namespace App\Error;

class DebugErrorHandler implements ErrorHandlerInterface
{
    public function handle(\Throwable $exception): void
    {
        // Debug handling logic (for example, log or display the exception)
        // For now, just rethrow
        throw $exception;
    }

    public function supports(\Throwable $exception): bool
    {
        // For debugging, support all exceptions
        return true;
    }
}
