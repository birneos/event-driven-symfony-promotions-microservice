<?php

declare(strict_types=1);

namespace App\Forwarder\Identify;

use App\CDP\Analytics\Model\ModelValidator;
use App\CDP\Analytics\Model\Subscription\Identify\IdentifyModel;
use App\CDP\Analytics\Model\Subscription\Identify\SubscriptionStartMapper;
use App\CDP\Http\CdpClientInterface;
use App\DTO\Newsletter\NewsletterWebhook;
use App\Forwarder\Newsletter\ForwarderInterface as NewsletterForwarderInterface;

class SubscriptionStartForwarder implements NewsletterForwarderInterface
{
    private const SUPPORTED_EVENT = 'newsletter_subscribed';

    public function __construct(
        private readonly CdpClientInterface $cdpClient,
        private readonly ModelValidator $modelValidator,
    ) {
    }

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



         //1.  Instantiate a class which models Identify data

         $identifyModel = new IdentifyModel();

        // 2.  Map the NewsletterWebhook data to the model

        (new SubscriptionStartMapper())->map($webhook, $identifyModel);

        // dd($identifyModel);

        // 3.  Validate the model
        $this->modelValidator->validate($identifyModel);

        // 4.  Use the CDP client to POST the data to the CDP
        $this->cdpClient->identify($identifyModel);
    }
}
