<?php

declare(strict_types=1);

namespace App\DTO;

class Webhook
{
    private string $event;

    /**
     * @var array<string, mixed>
     */
    private array $rawPayload;

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    /** @return array <string, mixed> */
    public function getRawPayload(): array
    {
        return $this->rawPayload;
    }

      /**
     * @param array<string, mixed> $rawPayload
     */
    public function setRawPayload(array $rawPayload): void
    {
        $this->rawPayload = $rawPayload;
    }
}
