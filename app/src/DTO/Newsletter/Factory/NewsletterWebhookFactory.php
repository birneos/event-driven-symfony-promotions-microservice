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
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Failed to deserialize webhook payload', 0, $exception);
        }

        return $newsletterWebhook;
    }
}
