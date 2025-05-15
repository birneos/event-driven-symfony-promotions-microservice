<?php

declare(strict_types=1);

namespace App\DTO\Newsletter\Factory;

use App\DTO\Newsletter\NewsletterWebhook;
use App\DTO\Webhook;
use Symfony\Component\Serializer\SerializerInterface;

class NewsletterWebhookFactory
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }
    public function create(Webhook $webhook): NewsletterWebhook
    {
        try {
            $newsletterWebhook = $this->serializer->deserialize(
                json_encode($webhook->getRawPayload()),
                NewsletterWebhook::class,
                'json'
            );
        } catch (\Throwable $throwable) {
            throw new \App\Error\WebhookException('Unable to create NewsletterWebhook, failed to deserialize webhook payload #message ' . $throwable->getMessage(), 0, $throwable);
        }

        return $newsletterWebhook;
    }
}
