<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Contracts\SerializesRequest;

final class Component extends Model implements SerializesRequest
{
    private ?string $name = null;

    private int|float|null $rate = null;

    private ?bool $isCompound = null;

    private ?bool $isNonRecoverable = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRate(): int|float|null
    {
        return $this->rate;
    }

    public function setRate(int|float|null $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getIsCompound(): ?bool
    {
        return $this->isCompound;
    }

    public function setIsCompound(?bool $isCompound): self
    {
        $this->isCompound = $isCompound;

        return $this;
    }

    public function getIsNonRecoverable(): ?bool
    {
        return $this->isNonRecoverable;
    }

    public function setIsNonRecoverable(?bool $isNonRecoverable): self
    {
        $this->isNonRecoverable = $isNonRecoverable;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Name' => Field::string(),
            'Rate' => Field::number(),
            'IsCompound' => Field::boolean(),
            'IsNonRecoverable' => Field::boolean(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Name' => $this->getName(),
            'Rate' => $this->getRate(),
            'IsCompound' => $this->getIsCompound(),
            'IsNonRecoverable' => $this->getIsNonRecoverable(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
