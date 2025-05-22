<?php

declare(strict_types=1);

namespace App\Forwarder\Newsletter\Track;

use App\DTO\Newsletter\NewsletterWebhook;
use App\Forwarder\Newsletter\ForwarderInterface;

class SubscriptionForwarder implements ForwarderInterface
{
    public function supports(NewsletterWebhook $webhook):bool
    {
        // kein spezifischer Wert der geprüft werden muss, wir wollen alles tracken
        return true;
    }

    public function forward(NewsletterWebhook $webhook): void
    {
         //1.  Instantiate a class which models tracking data

        // 2.  Map the NewsletterWebhook data to the model

        // 3.  Validate the model

        // 4.  Use the CDP client to POST the data to the CDP
       
    }
}

