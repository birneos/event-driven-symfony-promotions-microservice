<?php

// src/DTO/Newsletter/NewsletterWebhook.php

declare(strict_types=1);

namespace App\DTO\Newsletter;

use App\CDP\Analytics\Model\Subscription\Identify\SubscriptionSourceInterface;
use App\DTO\User\User;
use DateInterval;
use DateTimeImmutable;

class NewsletterWebhook implements SubscriptionSourceInterface
{
    private string $event;
    private string $id;
    private string $origin;
    private DateTimeImmutable $timestamp;
    private User $user;
    private Newsletter $newsletter;

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): void
    {
        $this->origin = $origin;
    }

    public function getTimestamp(): DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(DateTimeImmutable $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getNewsletter(): Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(Newsletter $newsletter): void
    {
        $this->newsletter = $newsletter;
    }

    public function getProduct(): string
    {
        // newsletter.product_id
        return $this->newsletter->getProductId();
    }

    public function getEventDate(): string
    {
        // timestamp
        return $this->timestamp->format('Y-m-d');
    }

    public function getSubscriptionId(): string
    {
        // id
        return $this->id;
    }

    public function getEmail(): string
    {
        // user.email
        return $this->user->getEmail();
    }

    public function getUserId(): string
    {
        // user.client_id
        return $this->user->getClientId();
    }

    public function requiresConsent(): bool
    {
        return in_array($this->user->getRegion(), self::CONSENT_REGIONS);
    }

    public function getPlatform(): string
    {
        return 'web';
    }

    public function getProductName(): string
    {
        return $this->newsletter->getNewsletterId();
    }

    public function getRenewalDate(): string
    {
        $date = $this->timestamp;

        $interval = new DateInterval('P1Y');

        return $date->add($interval)->format('Y-m-d');
    }

    public function getStartDate(): string
    {
        return $this->timestamp->format('Y-m-d');
    }

    public function getType(): string
    {
        return 'newsletter';
    }

    public function getStatus(): string
    {
        $status = 'subscribed';

        if ($this->event === 'newsletter_unsubscribed') {
            $status = 'unsubscribed';
        }

        return $status;
    }
}
