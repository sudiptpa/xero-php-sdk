<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Item;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Purchase extends Model implements SerializesRequest
{
    private int|float|null $unitPrice = null;

    private ?string $accountCode = null;

    private ?string $cOGSAccountCode = null;

    private ?string $taxType = null;

    public function getUnitPrice(): int|float|null
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int|float|null $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getAccountCode(): ?string
    {
        return $this->accountCode;
    }

    public function setAccountCode(?string $accountCode): self
    {
        $this->accountCode = $accountCode;

        return $this;
    }

    public function getCOGSAccountCode(): ?string
    {
        return $this->cOGSAccountCode;
    }

    public function setCOGSAccountCode(?string $cOGSAccountCode): self
    {
        $this->cOGSAccountCode = $cOGSAccountCode;

        return $this;
    }

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setTaxType(?string $taxType): self
    {
        $this->taxType = $taxType;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'UnitPrice' => Field::number(),
            'AccountCode' => Field::string(),
            'COGSAccountCode' => Field::string(),
            'TaxType' => Field::string(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'UnitPrice' => $this->getUnitPrice(),
            'AccountCode' => $this->getAccountCode(),
            'COGSAccountCode' => $this->getCOGSAccountCode(),
            'TaxType' => $this->getTaxType(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
