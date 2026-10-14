<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TaxLine extends Model
{
    private ?string $taxLineID = null;

    private ?string $description = null;

    private ?bool $isEmployerTax = null;

    private ?float $amount = null;

    private ?string $globalTaxTypeID = null;

    private ?bool $manualAdjustment = null;

    public function getTaxLineID(): ?string
    {
        return $this->taxLineID;
    }

    public function setTaxLineID(?string $taxLineID): self
    {
        $this->taxLineID = $taxLineID;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsEmployerTax(): ?bool
    {
        return $this->isEmployerTax;
    }

    public function setIsEmployerTax(?bool $isEmployerTax): self
    {
        $this->isEmployerTax = $isEmployerTax;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getGlobalTaxTypeID(): ?string
    {
        return $this->globalTaxTypeID;
    }

    public function setGlobalTaxTypeID(?string $globalTaxTypeID): self
    {
        $this->globalTaxTypeID = $globalTaxTypeID;

        return $this;
    }

    public function getManualAdjustment(): ?bool
    {
        return $this->manualAdjustment;
    }

    public function setManualAdjustment(?bool $manualAdjustment): self
    {
        $this->manualAdjustment = $manualAdjustment;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'taxLineID' => Field::string(),
            'description' => Field::string(),
            'isEmployerTax' => Field::boolean(),
            'amount' => Field::number(),
            'globalTaxTypeID' => Field::string(),
            'manualAdjustment' => Field::boolean(),
        ];
    }
}
