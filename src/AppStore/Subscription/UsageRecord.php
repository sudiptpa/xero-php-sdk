<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class UsageRecord extends Model
{
    public function __construct(
        private ?string $usageRecordId = null,
        private ?string $subscriptionId = null,
        private ?string $subscriptionItemId = null,
        private ?string $productId = null,
        private int|float|null $pricePerUnit = null,
        private int|float|null $quantity = null,
        private ?bool $testMode = null,
        private ?string $recordedAt = null,
    ) {
    }

    public function getUsageRecordId(): ?string
    {
        return $this->usageRecordId;
    }

    public function setUsageRecordId(?string $usageRecordId): self
    {
        $this->usageRecordId = $usageRecordId;

        return $this;
    }

    public function getSubscriptionId(): ?string
    {
        return $this->subscriptionId;
    }

    public function setSubscriptionId(?string $subscriptionId): self
    {
        $this->subscriptionId = $subscriptionId;

        return $this;
    }

    public function getSubscriptionItemId(): ?string
    {
        return $this->subscriptionItemId;
    }

    public function setSubscriptionItemId(?string $subscriptionItemId): self
    {
        $this->subscriptionItemId = $subscriptionItemId;

        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getPricePerUnit(): int|float|null
    {
        return $this->pricePerUnit;
    }

    public function setPricePerUnit(int|float|null $pricePerUnit): self
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }

    public function getQuantity(): int|float|null
    {
        return $this->quantity;
    }

    public function setQuantity(int|float|null $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTestMode(): ?bool
    {
        return $this->testMode;
    }

    public function setTestMode(?bool $testMode): self
    {
        $this->testMode = $testMode;

        return $this;
    }

    public function getRecordedAt(): ?string
    {
        return $this->recordedAt;
    }

    public function setRecordedAt(?string $recordedAt): self
    {
        $this->recordedAt = $recordedAt;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'usageRecordId' => Field::string()->using('setUsageRecordId'),
            'subscriptionId' => Field::string()->using('setSubscriptionId'),
            'subscriptionItemId' => Field::string()->using('setSubscriptionItemId'),
            'productId' => Field::string()->using('setProductId'),
            'pricePerUnit' => Field::number()->using('setPricePerUnit'),
            'quantity' => Field::number()->using('setQuantity'),
            'testMode' => Field::boolean()->using('setTestMode'),
            'recordedAt' => Field::string()->using('setRecordedAt'),
        ];
    }
}
