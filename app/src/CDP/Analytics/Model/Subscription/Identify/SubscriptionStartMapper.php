<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model\Subscription\Identify;

use App\Error\WebhookException;
use Throwable;

class SubscriptionStartMapper
{
    public function map(SubscriptionSourceInterface $source, IdentifyModel $target): IdentifyModel
    {
        try {
            $target->setProduct($source->getProduct());
            $target->setEventDate($source->getEventDate());
            $target->setSubscriptionId($source->getSubscriptionId());
            $target->setEmail($source->getEmail());
            $target->setId($source->getUserId());

            return $target;
        } catch (Throwable $throwable) {
            $className = get_class($source);
            throw new WebhookException("Could not map $className to IdentifyModel target");
        }
    }
}
