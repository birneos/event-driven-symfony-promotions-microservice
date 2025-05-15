<?php

declare(strict_types=1);

namespace App\Forwarder\Identify;

use App\DTO\Newsletter\NewsletterWebhook;
use App\Forwarder\Newsletter\ForwarderInterface as NewsletterForwarderInterface;

class SubscriptionStartForwarder implements NewsletterForwarderInterface
{
    private const SUPPORTED_EVENT = 'subscription_subscribed';

    public function supports(NewsletterWebhook $webhook): bool
    {
        return $webhook->getEvent() === self::SUPPORTED_EVENT;
    }

    public function forward(NewsletterWebhook $webhook): void
    {
        // Implement the logic to forward the webhook data.
        // This is just a placeholder implementation.
       // $payload = $webhook->getRawPayload();
        // Forward the payload to the desired endpoint or service.

        dd($webhook);

         //1.  Instantiate a class which models Identify data

        // 2.  Map the NewsletterWebhook data to the model

        // 3.  Validate the model

        // 4.  Use the CDP client to POST the data to the CDP
    }
}
