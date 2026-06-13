<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TotalDetail extends Model
{
    private int|float|null $totalPaid = null;

    private int|float|null $totalOutstanding = null;

    private int|float|null $totalCreditedUnApplied = null;

    public function getTotalPaid(): int|float|null
    {
        return $this->totalPaid;
    }

    public function setTotalPaid(int|float|null $totalPaid): self
    {
        $this->totalPaid = $totalPaid;

        return $this;
    }

    public function getTotalOutstanding(): int|float|null
    {
        return $this->totalOutstanding;
    }

    public function setTotalOutstanding(int|float|null $totalOutstanding): self
    {
        $this->totalOutstanding = $totalOutstanding;

        return $this;
    }

    public function getTotalCreditedUnApplied(): int|float|null
    {
        return $this->totalCreditedUnApplied;
    }

    public function setTotalCreditedUnApplied(int|float|null $totalCreditedUnApplied): self
    {
        $this->totalCreditedUnApplied = $totalCreditedUnApplied;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'totalPaid' => Field::number(),
            'totalOutstanding' => Field::number(),
            'totalCreditedUnApplied' => Field::number(),
        ];
    }
}
