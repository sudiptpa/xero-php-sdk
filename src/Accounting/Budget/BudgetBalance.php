<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Budget;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BudgetBalance extends Model
{
    private ?string $period = null;
    private ?float $amount = null;
    private ?float $unitAmount = null;
    private ?string $notes = null;

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(?string $period): self
    {
        $this->period = $period;

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

    public function getUnitAmount(): ?float
    {
        return $this->unitAmount;
    }

    public function setUnitAmount(?float $unitAmount): self
    {
        $this->unitAmount = $unitAmount;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Period' => Field::string()->using('setPeriod'),
            'Amount' => Field::number()->using('setAmount'),
            'UnitAmount' => Field::number()->using('setUnitAmount'),
            'Notes' => Field::string()->using('setNotes'),
        ];
    }
}
