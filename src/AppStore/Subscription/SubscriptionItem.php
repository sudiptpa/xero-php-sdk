<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class SubscriptionItem extends Model
{
    public function __construct(
        private ?string $id = null,
        private ?string $startDate = null,
        private ?string $endDate = null,
        private ?string $status = null,
        private ?bool $testMode = null,
        private int|float|null $quantity = null,
        private ?Price $price = null,
        private ?Product $product = null,
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    public function getQuantity(): int|float|null
    {
        return $this->quantity;
    }

    public function setQuantity(int|float|null $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(?Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'id' => Field::string()->using('setId'),
            'startDate' => Field::string()->using('setStartDate'),
            'endDate' => Field::string()->using('setEndDate'),
            'status' => Field::string()->using('setStatus'),
            'testMode' => Field::boolean()->using('setTestMode'),
            'quantity' => Field::number()->using('setQuantity'),
            'price' => Field::object(Price::class)->using('setPrice'),
            'product' => Field::object(Product::class)->using('setProduct'),
        ];
    }
}
