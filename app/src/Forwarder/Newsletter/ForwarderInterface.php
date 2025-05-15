<?php

declare(strict_types=1);

namespace App\Handler;

use App\DTO\Newsletter\NewsletterWebhook;

interface ForwarderInterface
{
    public function supports(NewsletterWebhook $webhook): bool;

    public function forward(NewsletterWebhook $webhook): void;
}
