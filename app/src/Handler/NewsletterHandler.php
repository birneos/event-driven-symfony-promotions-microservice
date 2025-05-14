<?php

declare(strict_types=1);

namespace App\Handler;

use App\DTO\Webhook;

class NewsletterHandler implements WebhookHandlerInterface
{
    private const SUPPORTED_EVENTS = [
        'newsletter_oppened',
        'newsletter_subscribed',
        'newsletter_unsubscribed',
    ];
    public function supports(Webhook $webhook): bool
    {
        return in_array($webhook->getEvent(), self::SUPPORTED_EVENTS);
    }


    public function handle(Webhook $webhook): void
    {
        dd($webhook);
    }
}
