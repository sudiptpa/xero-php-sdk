<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

final class Subscription
{
    /**
     * @param list<array<string, mixed>> $items
     */
    public function __construct(
        private ?Client $client = null,
        private ?string $subscriptionID = null,
        private ?string $planID = null,
        private ?string $status = null,
        private ?string $currentPeriodEnd = null,
        private array $items = [],
    ) {
    }

    public function getSubscriptionID(): ?string { return $this->subscriptionID; }
    public function setSubscriptionID(?string $subscriptionID): self { $this->subscriptionID = $subscriptionID; return $this; }
    public function getPlanID(): ?string { return $this->planID; }
    public function setPlanID(?string $planID): self { $this->planID = $planID; return $this; }
    public function getStatus(): ?string { return $this->status; }
    public function setStatus(?string $status): self { $this->status = $status; return $this; }
    public function getCurrentPeriodEnd(): ?string { return $this->currentPeriodEnd; }
    public function setCurrentPeriodEnd(?string $currentPeriodEnd): self { $this->currentPeriodEnd = $currentPeriodEnd; return $this; }
    /**
     * @return list<array<string, mixed>>
     */
    public function getItems(): array { return $this->items; }
    /**
     * @param list<array<string, mixed>> $items
     */
    public function setItems(array $items): self { $this->items = $items; return $this; }
    /**
     * @return ResourceCollection<UsageRecord>
     */
    public function usageRecords(): ResourceCollection
    {
        if ($this->client === null || $this->subscriptionID === null) {
            throw new RuntimeException('Cannot load usage records without a bound client context and subscription id.');
        }

        return (new Subscriptions($this->client))->usageRecords($this->subscriptionID);
    }

    public function recordUsage(): UsageRecordPayload
    {
        if ($this->client === null || $this->subscriptionID === null) {
            throw new RuntimeException('Cannot record usage without a bound client context and subscription id.');
        }

        return (new Subscriptions($this->client))->recordUsage($this->subscriptionID);
    }
}
