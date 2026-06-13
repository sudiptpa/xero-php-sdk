<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Price extends Model
{
    public function __construct(
        private ?string $id = null,
        private int|float|null $amount = null,
        private ?string $currency = null,
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

    public function getAmount(): int|float|null
    {
        return $this->amount;
    }

    public function setAmount(int|float|null $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'id' => Field::string()->using('setId'),
            'amount' => Field::number()->using('setAmount'),
            'currency' => Field::string()->using('setCurrency'),
        ];
    }
}
