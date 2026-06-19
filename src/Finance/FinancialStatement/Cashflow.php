<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Cashflow extends Model
{
    private ?string $startDate = null;

    private ?string $endDate = null;

    private ?CashBalance $cashBalance = null;

    /**
     * @var list<CashflowActivity>
     */
    private array $cashflowActivities = [];

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

    public function getCashBalance(): ?CashBalance
    {
        return $this->cashBalance;
    }

    public function setCashBalance(?CashBalance $cashBalance): self
    {
        $this->cashBalance = $cashBalance;

        return $this;
    }

    /**
     * @return list<CashflowActivity>
     */
    public function getCashflowActivities(): array
    {
        return $this->cashflowActivities;
    }

    /**
     * @param list<CashflowActivity> $cashflowActivities
     */
    public function setCashflowActivities(array $cashflowActivities): self
    {
        $this->cashflowActivities = $cashflowActivities;

        return $this;
    }

    public function addCashflowActivity(CashflowActivity $cashflowActivity): self
    {
        $this->cashflowActivities[] = $cashflowActivity;

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
            'cashBalance' => Field::object(CashBalance::class),
            'cashflowActivities' => Field::many(CashflowActivity::class),
        ];
    }
}
