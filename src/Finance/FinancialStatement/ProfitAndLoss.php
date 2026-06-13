<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ProfitAndLoss extends Model
{
    private ?string $startDate = null;

    private ?string $endDate = null;

    private int|float|null $netProfitLoss = null;

    private ?PnlAccountClass $revenue = null;

    private ?PnlAccountClass $expense = null;

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getNetProfitLoss(): int|float|null
    {
        return $this->netProfitLoss;
    }

    public function setNetProfitLoss(int|float|null $netProfitLoss): self
    {
        $this->netProfitLoss = $netProfitLoss;

        return $this;
    }

    public function getRevenue(): ?PnlAccountClass
    {
        return $this->revenue;
    }

    public function setRevenue(?PnlAccountClass $revenue): self
    {
        $this->revenue = $revenue;

        return $this;
    }

    public function getExpense(): ?PnlAccountClass
    {
        return $this->expense;
    }

    public function setExpense(?PnlAccountClass $expense): self
    {
        $this->expense = $expense;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'startDate' => Field::string(),
            'endDate' => Field::string(),
            'netProfitLoss' => Field::number(),
            'revenue' => Field::object(PnlAccountClass::class),
            'expense' => Field::object(PnlAccountClass::class),
        ];
    }
}
