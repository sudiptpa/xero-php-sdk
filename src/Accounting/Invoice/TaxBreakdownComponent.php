<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TaxBreakdownComponent extends Model
{
    private ?string $taxComponentId = null;

    private ?string $type = null;

    private ?string $name = null;

    private int|float|null $taxPercentage = null;

    private int|float|null $taxAmount = null;

    private int|float|null $taxableAmount = null;

    private int|float|null $nonTaxableAmount = null;

    private int|float|null $exemptAmount = null;

    private ?string $stateAssignedNo = null;

    private ?string $jurisdictionRegion = null;

    public function getTaxComponentId(): ?string
    {
        return $this->taxComponentId;
    }

    public function setTaxComponentId(?string $taxComponentId): self
    {
        $this->taxComponentId = $taxComponentId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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

    public function getTaxPercentage(): int|float|null
    {
        return $this->taxPercentage;
    }

    public function setTaxPercentage(int|float|null $taxPercentage): self
    {
        $this->taxPercentage = $taxPercentage;

        return $this;
    }

    public function getTaxAmount(): int|float|null
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(int|float|null $taxAmount): self
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    public function getTaxableAmount(): int|float|null
    {
        return $this->taxableAmount;
    }

    public function setTaxableAmount(int|float|null $taxableAmount): self
    {
        $this->taxableAmount = $taxableAmount;

        return $this;
    }

    public function getNonTaxableAmount(): int|float|null
    {
        return $this->nonTaxableAmount;
    }

    public function setNonTaxableAmount(int|float|null $nonTaxableAmount): self
    {
        $this->nonTaxableAmount = $nonTaxableAmount;

        return $this;
    }

    public function getExemptAmount(): int|float|null
    {
        return $this->exemptAmount;
    }

    public function setExemptAmount(int|float|null $exemptAmount): self
    {
        $this->exemptAmount = $exemptAmount;

        return $this;
    }

    public function getStateAssignedNo(): ?string
    {
        return $this->stateAssignedNo;
    }

    public function setStateAssignedNo(?string $stateAssignedNo): self
    {
        $this->stateAssignedNo = $stateAssignedNo;

        return $this;
    }

    public function getJurisdictionRegion(): ?string
    {
        return $this->jurisdictionRegion;
    }

    public function setJurisdictionRegion(?string $jurisdictionRegion): self
    {
        $this->jurisdictionRegion = $jurisdictionRegion;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'TaxComponentId' => Field::string(),
            'Type' => Field::string(),
            'Name' => Field::string(),
            'TaxPercentage' => Field::number(),
            'TaxAmount' => Field::number(),
            'TaxableAmount' => Field::number(),
            'NonTaxableAmount' => Field::number(),
            'ExemptAmount' => Field::number(),
            'StateAssignedNo' => Field::string(),
            'JurisdictionRegion' => Field::string(),
        ];
    }
}
