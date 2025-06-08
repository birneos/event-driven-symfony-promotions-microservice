<?php

declare(strict_types=1);

namespace App\Tests\TestDoubles;

use App\Error\ErrorHandlerInterface;
use Throwable;

class FakeErrorHandler implements ErrorHandlerInterface
{
    private int $handleCallCount = 0;
    private Throwable $error;

    public function handle(\Throwable $error): void
    {
        // Fake implementation for testing
        $this->handleCallCount++;
        $this->error = $error;
    }

    public function supports(\Throwable $error): bool
    {
        // Fake implementation for testing
        return true;
    }


    /**
     * Get the value of handleCallCount
     */
    public function getHandleCallCount(): int
    {
        return $this->handleCallCount;
    }

    /**
     * Set the value of handleCallCount
     */
    public function setHandleCallCount(int $handleCallCount): self
    {
        $this->handleCallCount = $handleCallCount;

        return $this;
    }

    /**
     * Get the value of error
     */
    public function getError(): Throwable
    {
        return $this->error;
    }

    /**
     * Set the value of error
     */
    public function setError(Throwable $error): self
    {
        $this->error = $error;

        return $this;
    }
}
