<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ContactTotalOther extends Model
{
    private int|float|null $totalOutstandingAged = null;

    private int|float|null $totalVoided = null;

    private int|float|null $totalCredited = null;

    private int|float|null $transactionCount = null;

    public function getTotalOutstandingAged(): int|float|null
    {
        return $this->totalOutstandingAged;
    }

    public function setTotalOutstandingAged(int|float|null $totalOutstandingAged): self
    {
        $this->totalOutstandingAged = $totalOutstandingAged;

        return $this;
    }

    public function getTotalVoided(): int|float|null
    {
        return $this->totalVoided;
    }

    public function setTotalVoided(int|float|null $totalVoided): self
    {
        $this->totalVoided = $totalVoided;

        return $this;
    }

    public function getTotalCredited(): int|float|null
    {
        return $this->totalCredited;
    }

    public function setTotalCredited(int|float|null $totalCredited): self
    {
        $this->totalCredited = $totalCredited;

        return $this;
    }

    public function getTransactionCount(): int|float|null
    {
        return $this->transactionCount;
    }

    public function setTransactionCount(int|float|null $transactionCount): self
    {
        $this->transactionCount = $transactionCount;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'totalOutstandingAged' => Field::number(),
            'totalVoided' => Field::number(),
            'totalCredited' => Field::number(),
            'transactionCount' => Field::number(),
        ];
    }
}
