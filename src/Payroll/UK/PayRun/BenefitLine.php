<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BenefitLine extends Model
{
    private ?string $benefitTypeID = null;

    private ?string $displayName = null;

    private ?float $amount = null;

    private ?float $fixedAmount = null;

    private ?float $percentage = null;

    public function getBenefitTypeID(): ?string
    {
        return $this->benefitTypeID;
    }

    public function setBenefitTypeID(?string $benefitTypeID): self
    {
        $this->benefitTypeID = $benefitTypeID;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

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

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(?float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'benefitTypeID' => Field::string(),
            'displayName' => Field::string(),
            'amount' => Field::number(),
            'fixedAmount' => Field::number(),
            'percentage' => Field::number(),
        ];
    }
}
