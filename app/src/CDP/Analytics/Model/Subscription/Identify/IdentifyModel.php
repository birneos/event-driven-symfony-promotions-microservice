<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model\Subscription\Identify;

use App\CDP\Analytics\Model\ModelInterface;

class IdentifyModel implements ModelInterface
{
    private string $product;

    private string $eventDate;

    private string $subscriptionId;

    private string $email;

    private string $id;

    public function toArray(): array
    {
        return [
        'type' => self::IDENTIFY_TYPE,
        'context' => [
            'product' => $this->product, // newsletter.product_id
            'event_date' => $this->eventDate // timestamp
        ],
        'traits' => [
            'subscription_id' => $this->subscriptionId, // id
            'email' => $this->email // user.email
        ],
        'id' => $this->id // user.client_id
        ];
    }



    /**
     * Get the value of product
     */
    public function getProduct(): string
    {
        return $this->product;
    }

    /**
     * Set the value of product
     */
    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get the value of eventDate
     */
    public function getEventDate(): string
    {
        return $this->eventDate;
    }

    /**
     * Set the value of eventDate
     */
    public function setEventDate(string $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get the value of subscriptionId
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    /**
     * Set the value of subscriptionId
     */
    public function setSubscriptionId(string $subscriptionId): self
    {
        $this->subscriptionId = $subscriptionId;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
