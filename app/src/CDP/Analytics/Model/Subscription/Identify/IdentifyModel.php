<?php

declare(strict_types=1);

namespace App\CDP\Analytics\Model\Subscription\Identify;

use App\CDP\Analytics\Model\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

class IdentifyModel implements ModelInterface
{
    #[Assert\NotBlank(message: 'Product cannot be blank')]
    private string $product;

    #[Assert\NotBlank(message: 'Event date cannot be blank')]
    #[Assert\Regex(
        pattern: '/^\d{4}-\d{2}-\d{2}$/',
        message: 'Event date must be in the format YYYY-MM-DD'
    )]

    private string $eventDate;

    #[Assert\NotBlank(message: 'Event date cannot be blank')]

    private string $subscriptionId;

    #[Assert\NotBlank(message: 'Email cannot be blank')]
    #[Assert\Email(message: 'Email is not valid')]

    private string $email;

    #[Assert\NotBlank(message: 'ID cannot be blank')]

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
