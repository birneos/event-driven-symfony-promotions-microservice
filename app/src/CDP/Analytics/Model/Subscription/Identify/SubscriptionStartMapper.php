<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model\Subscription\Identify;

class SubscriptionStartMapper
{
    public function map(SubscriptionSourceInterface $source, IdentifyModel $target): IdentifyModel
    {

        dd($source, $target);
        // $model = new IdentifyModel();
        // $model->setProduct($data['product_id']);
        // $model->setEventDate($data['timestamp']);
        // $model->setSubscriptionId($data['id']);
        // $model->setEmail($data['user']['email']);
        // $model->setId($data['user']['client_id']);

        return $model;
    }
}
