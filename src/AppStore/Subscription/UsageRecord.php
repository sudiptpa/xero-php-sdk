<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

final class UsageRecord
{
    public function __construct(
        private ?string $usageRecordID = null,
        private ?string $subscriptionItemID = null,
        private ?float $quantity = null,
        private ?string $startDate = null,
        private ?string $endDate = null
    ) {
    }

    public function getUsageRecordID(): ?string { return $this->usageRecordID; }
    public function setUsageRecordID(?string $usageRecordID): self { $this->usageRecordID = $usageRecordID; return $this; }
    public function getSubscriptionItemID(): ?string { return $this->subscriptionItemID; }
    public function setSubscriptionItemID(?string $subscriptionItemID): self { $this->subscriptionItemID = $subscriptionItemID; return $this; }
    public function getQuantity(): ?float { return $this->quantity; }
    public function setQuantity(?float $quantity): self { $this->quantity = $quantity; return $this; }
    public function getStartDate(): ?string { return $this->startDate; }
    public function setStartDate(?string $startDate): self { $this->startDate = $startDate; return $this; }
    public function getEndDate(): ?string { return $this->endDate; }
    public function setEndDate(?string $endDate): self { $this->endDate = $endDate; return $this; }
}
