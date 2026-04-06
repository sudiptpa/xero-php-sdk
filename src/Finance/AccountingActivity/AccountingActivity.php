<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class AccountingActivity extends Model
{
    public function __construct(
        private ?string $month = null,
        private ?float $totalIncome = null,
        private ?float $totalExpense = null
    ) {
    }

    public function getMonth(): ?string { return $this->month; }
    public function setMonth(?string $month): self { $this->month = $month; return $this; }
    public function getTotalIncome(): ?float { return $this->totalIncome; }
    public function setTotalIncome(?float $totalIncome): self { $this->totalIncome = $totalIncome; return $this; }
    public function getTotalExpense(): ?float { return $this->totalExpense; }
    public function setTotalExpense(?float $totalExpense): self { $this->totalExpense = $totalExpense; return $this; }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Month' => Field::string()->using('setMonth'),
            'TotalIncome' => Field::number()->using('setTotalIncome'),
            'TotalExpense' => Field::number()->using('setTotalExpense'),
        ];
    }
}
