<?php

declare(strict_types=1);

namespace App\Forwarder\Newsletter\Track;

use App\CDP\Analytics\Model\ModelValidator;
use App\CDP\Analytics\Model\Subscription\Track\SubscriptionMapper;
use App\CDP\Analytics\Model\Subscription\Track\TrackModel;
use App\CDP\Http\CdpClientInterface;
use App\DTO\Newsletter\NewsletterWebhook;
use App\Forwarder\Newsletter\ForwarderInterface;

class SubscriptionForwarder implements ForwarderInterface
{
    public function __construct(
        private readonly CdpClientInterface $cdpClient,
        private readonly ModelValidator $modelValidator,
    ) {
    }

    public function supports(NewsletterWebhook $webhook): bool
    {
        // kein spezifischer Wert der geprüft werden muss, wir wollen alles tracken
        return true;
    }

    public function forward(NewsletterWebhook $webhook): void
    {
         //1.  Instantiate a class which models tracking data
        $model = new TrackModel();

        // 2.  Map the NewsletterWebhook data to the model
         (new SubscriptionMapper())->map($webhook, $model);

        //  dd($model);

        // 3.  Validate the model
        $this->modelValidator->validate($model);

        // 4.  Use the CDP client to POST the data to the CDP
        $this->cdpClient->track($model);
    }
}
