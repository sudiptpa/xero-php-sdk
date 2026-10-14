<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class DeductionLine extends Model
{
    private ?string $deductionTypeID = null;

    private ?float $amount = null;

    private ?bool $subjectToTax = null;

    private ?float $percentage = null;

    public function getDeductionTypeID(): ?string
    {
        return $this->deductionTypeID;
    }

    public function setDeductionTypeID(?string $deductionTypeID): self
    {
        $this->deductionTypeID = $deductionTypeID;

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

    public function getSubjectToTax(): ?bool
    {
        return $this->subjectToTax;
    }

    public function setSubjectToTax(?bool $subjectToTax): self
    {
        $this->subjectToTax = $subjectToTax;

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
            'deductionTypeID' => Field::string(),
            'amount' => Field::number(),
            'subjectToTax' => Field::boolean(),
            'percentage' => Field::number(),
        ];
    }
}
