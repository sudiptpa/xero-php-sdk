<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Asset;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BookDepreciationDetail extends Model
{
    private int|float|null $currentCapitalGain = null;

    private int|float|null $currentGainLoss = null;

    private ?string $depreciationStartDate = null;

    private int|float|null $costLimit = null;

    private int|float|null $residualValue = null;

    private int|float|null $priorAccumDepreciationAmount = null;

    private int|float|null $currentAccumDepreciationAmount = null;

    private int|float|null $businessUseCapitalGain = null;

    private int|float|null $businessUseCurrentGainLoss = null;

    private int|float|null $privateUseCapitalGain = null;

    private int|float|null $privateUseCurrentGainLoss = null;

    private int|float|null $initialDeductionPercentage = null;

    public function getCurrentCapitalGain(): int|float|null
    {
        return $this->currentCapitalGain;
    }

    public function setCurrentCapitalGain(int|float|null $currentCapitalGain): self
    {
        $this->currentCapitalGain = $currentCapitalGain;

        return $this;
    }

    public function getCurrentGainLoss(): int|float|null
    {
        return $this->currentGainLoss;
    }

    public function setCurrentGainLoss(int|float|null $currentGainLoss): self
    {
        $this->currentGainLoss = $currentGainLoss;

        return $this;
    }

    public function getDepreciationStartDate(): ?string
    {
        return $this->depreciationStartDate;
    }

    public function setDepreciationStartDate(?string $depreciationStartDate): self
    {
        $this->depreciationStartDate = $depreciationStartDate;

        return $this;
    }

    public function getCostLimit(): int|float|null
    {
        return $this->costLimit;
    }

    public function setCostLimit(int|float|null $costLimit): self
    {
        $this->costLimit = $costLimit;

        return $this;
    }

    public function getResidualValue(): int|float|null
    {
        return $this->residualValue;
    }

    public function setResidualValue(int|float|null $residualValue): self
    {
        $this->residualValue = $residualValue;

        return $this;
    }

    public function getPriorAccumDepreciationAmount(): int|float|null
    {
        return $this->priorAccumDepreciationAmount;
    }

    public function setPriorAccumDepreciationAmount(int|float|null $priorAccumDepreciationAmount): self
    {
        $this->priorAccumDepreciationAmount = $priorAccumDepreciationAmount;

        return $this;
    }

    public function getCurrentAccumDepreciationAmount(): int|float|null
    {
        return $this->currentAccumDepreciationAmount;
    }

    public function setCurrentAccumDepreciationAmount(int|float|null $currentAccumDepreciationAmount): self
    {
        $this->currentAccumDepreciationAmount = $currentAccumDepreciationAmount;

        return $this;
    }

    public function getBusinessUseCapitalGain(): int|float|null
    {
        return $this->businessUseCapitalGain;
    }

    public function setBusinessUseCapitalGain(int|float|null $businessUseCapitalGain): self
    {
        $this->businessUseCapitalGain = $businessUseCapitalGain;

        return $this;
    }

    public function getBusinessUseCurrentGainLoss(): int|float|null
    {
        return $this->businessUseCurrentGainLoss;
    }

    public function setBusinessUseCurrentGainLoss(int|float|null $businessUseCurrentGainLoss): self
    {
        $this->businessUseCurrentGainLoss = $businessUseCurrentGainLoss;

        return $this;
    }

    public function getPrivateUseCapitalGain(): int|float|null
    {
        return $this->privateUseCapitalGain;
    }

    public function setPrivateUseCapitalGain(int|float|null $privateUseCapitalGain): self
    {
        $this->privateUseCapitalGain = $privateUseCapitalGain;

        return $this;
    }

    public function getPrivateUseCurrentGainLoss(): int|float|null
    {
        return $this->privateUseCurrentGainLoss;
    }

    public function setPrivateUseCurrentGainLoss(int|float|null $privateUseCurrentGainLoss): self
    {
        $this->privateUseCurrentGainLoss = $privateUseCurrentGainLoss;

        return $this;
    }

    public function getInitialDeductionPercentage(): int|float|null
    {
        return $this->initialDeductionPercentage;
    }

    public function setInitialDeductionPercentage(int|float|null $initialDeductionPercentage): self
    {
        $this->initialDeductionPercentage = $initialDeductionPercentage;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'currentCapitalGain' => Field::number(),
            'currentGainLoss' => Field::number(),
            'depreciationStartDate' => Field::string(),
            'costLimit' => Field::number(),
            'residualValue' => Field::number(),
            'priorAccumDepreciationAmount' => Field::number(),
            'currentAccumDepreciationAmount' => Field::number(),
            'businessUseCapitalGain' => Field::number(),
            'businessUseCurrentGainLoss' => Field::number(),
            'privateUseCapitalGain' => Field::number(),
            'privateUseCurrentGainLoss' => Field::number(),
            'initialDeductionPercentage' => Field::number(),
        ];
    }
}
