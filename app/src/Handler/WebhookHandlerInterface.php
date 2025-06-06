<?php

declare(strict_types=1);

namespace App\Handler;

use App\DTO\Webhook;

interface WebhookHandlerInterface
{
    public function supports(Webhook $webhook): bool;

    public function handle(Webhook $webhook): void;
}
