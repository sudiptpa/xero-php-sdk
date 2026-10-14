<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class EarningsLine extends Model
{
    private ?string $earningsLineID = null;

    private ?string $earningsRateID = null;

    private ?string $displayName = null;

    private ?float $ratePerUnit = null;

    private ?float $numberOfUnits = null;

    private ?float $fixedAmount = null;

    private ?float $amount = null;

    private ?bool $isLinkedToTimesheet = null;

    private ?bool $isAverageDailyPayRate = null;

    public function getEarningsLineID(): ?string
    {
        return $this->earningsLineID;
    }

    public function setEarningsLineID(?string $earningsLineID): self
    {
        $this->earningsLineID = $earningsLineID;

        return $this;
    }

    public function getEarningsRateID(): ?string
    {
        return $this->earningsRateID;
    }

    public function setEarningsRateID(?string $earningsRateID): self
    {
        $this->earningsRateID = $earningsRateID;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getRatePerUnit(): ?float
    {
        return $this->ratePerUnit;
    }

    public function setRatePerUnit(?float $ratePerUnit): self
    {
        $this->ratePerUnit = $ratePerUnit;

        return $this;
    }

    public function getNumberOfUnits(): ?float
    {
        return $this->numberOfUnits;
    }

    public function setNumberOfUnits(?float $numberOfUnits): self
    {
        $this->numberOfUnits = $numberOfUnits;

        return $this;
    }

    public function getFixedAmount(): ?float
    {
        return $this->fixedAmount;
    }

    public function setFixedAmount(?float $fixedAmount): self
    {
        $this->fixedAmount = $fixedAmount;

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

    public function getIsLinkedToTimesheet(): ?bool
    {
        return $this->isLinkedToTimesheet;
    }

    public function setIsLinkedToTimesheet(?bool $isLinkedToTimesheet): self
    {
        $this->isLinkedToTimesheet = $isLinkedToTimesheet;

        return $this;
    }

    public function getIsAverageDailyPayRate(): ?bool
    {
        return $this->isAverageDailyPayRate;
    }

    public function setIsAverageDailyPayRate(?bool $isAverageDailyPayRate): self
    {
        $this->isAverageDailyPayRate = $isAverageDailyPayRate;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'earningsLineID' => Field::string(),
            'earningsRateID' => Field::string(),
            'displayName' => Field::string(),
            'ratePerUnit' => Field::number(),
            'numberOfUnits' => Field::number(),
            'fixedAmount' => Field::number(),
            'amount' => Field::number(),
            'isLinkedToTimesheet' => Field::boolean(),
            'isAverageDailyPayRate' => Field::boolean(),
        ];
    }
}
