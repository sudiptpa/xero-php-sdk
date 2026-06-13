<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Plan extends Model
{
    /**
     * @param list<SubscriptionItem> $subscriptionItems
     */
    public function __construct(
        private ?string $id = null,
        private ?string $name = null,
        private ?string $status = null,
        private array $subscriptionItems = [],
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return list<SubscriptionItem>
     */
    public function getSubscriptionItems(): array
    {
        return $this->subscriptionItems;
    }

    /**
     * @param list<SubscriptionItem> $subscriptionItems
     */
    public function setSubscriptionItems(array $subscriptionItems): self
    {
        $this->subscriptionItems = $subscriptionItems;

        return $this;
    }

    public function addSubscriptionItem(SubscriptionItem $subscriptionItem): self
    {
        $this->subscriptionItems[] = $subscriptionItem;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'id' => Field::string()->using('setId'),
            'name' => Field::string()->using('setName'),
            'status' => Field::string()->using('setStatus'),
            'subscriptionItems' => Field::many(SubscriptionItem::class)->using('addSubscriptionItem'),
        ];
    }
}
