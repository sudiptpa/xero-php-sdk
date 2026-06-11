<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class UsageRecord extends Model
{
    public function __construct(
        private ?string $usageRecordID = null,
        private ?string $subscriptionItemID = null,
        private ?float $quantity = null,
        private ?string $startDate = null,
        private ?string $endDate = null
    ) {
    }

    public function getUsageRecordID(): ?string
    {
        return $this->usageRecordID;
    }
    public function setUsageRecordID(?string $usageRecordID): self
    {
        $this->usageRecordID = $usageRecordID;
        return $this;
    }
    public function getSubscriptionItemID(): ?string
    {
        return $this->subscriptionItemID;
    }
    public function setSubscriptionItemID(?string $subscriptionItemID): self
    {
        $this->subscriptionItemID = $subscriptionItemID;
        return $this;
    }
    public function getQuantity(): ?float
    {
        return $this->quantity;
    }
    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }
    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }
    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'UsageRecordID' => Field::string(),
            'SubscriptionItemID' => Field::string(),
            'Quantity' => Field::number(),
            'StartDate' => Field::string(),
            'EndDate' => Field::string(),
            'id' => Field::string()->using('setUsageRecordID'),
            'subscriptionItemId' => Field::string()->using('setSubscriptionItemID'),
            'quantity' => Field::number()->using('setQuantity'),
            'startDate' => Field::string()->using('setStartDate'),
            'endDate' => Field::string()->using('setEndDate'),
        ];
    }
}
