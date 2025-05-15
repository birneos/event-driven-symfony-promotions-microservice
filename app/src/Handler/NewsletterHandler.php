<?php

declare(strict_types=1);

namespace App\Handler;

use App\DTO\Newsletter\Factory\NewsletterWebhookFactory;
use App\DTO\Webhook;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class NewsletterHandler implements WebhookHandlerInterface
{
    /**
     *  @param iterable<ForwarderInterface> $forwarders
     * */
    public function __construct(
        private readonly NewsletterWebhookFactory $newsletterWebhookFactory,
        #[AutowireIterator(tag: 'forwarder.newsletter')] private readonly iterable $forwarders
    ) {
    }
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
        $newsletterWebhook = $this->newsletterWebhookFactory->create($webhook);

        // Loop through all the forwarders and check if they support the webhook
        foreach ($this->forwarders as $forwarder) {
            // Check if the forwarder supports the webhook
            if ($forwarder->supports($newsletterWebhook)) {
                // Forward the data
                $forwarder->forward($newsletterWebhook);
            }
        }
    }
}
