<?php

declare(strict_types=1);

namespace App\DTO;

class Webhook
{
    private string $event;
    private array $rawPayload;

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    public function getRawPayload(): array
    {
        return $this->rawPayload;
    }

    public function setRawPayload(array $rawPayload): void
    {
        $this->rawPayload = $rawPayload;
    }
}
