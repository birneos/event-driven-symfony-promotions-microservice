<?php

declare(strict_types=1);

namespace App\Error;

interface ErrorHandlerInterface
{
    /**
     * Handle the error.
     *
     * @param \Throwable $exception The exception to handle.
     */
    public function handle(\Throwable $exception): void;

    /**
     * Check if the handler supports the given exception type.
     *
     * @param \Throwable $exception The exception to check.
     * @return bool True if the handler supports the exception, false otherwise.
     */
    public function supports(\Throwable $exception): bool;
}
