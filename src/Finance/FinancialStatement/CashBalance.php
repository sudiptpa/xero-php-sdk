<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CashBalance extends Model
{
    private int|float|null $openingCashBalance = null;

    private int|float|null $closingCashBalance = null;

    private int|float|null $netCashMovement = null;

    public function getOpeningCashBalance(): int|float|null
    {
        return $this->openingCashBalance;
    }

    public function setOpeningCashBalance(int|float|null $openingCashBalance): self
    {
        $this->openingCashBalance = $openingCashBalance;

        return $this;
    }

    public function getClosingCashBalance(): int|float|null
    {
        return $this->closingCashBalance;
    }

    public function setClosingCashBalance(int|float|null $closingCashBalance): self
    {
        $this->closingCashBalance = $closingCashBalance;

        return $this;
    }

    public function getNetCashMovement(): int|float|null
    {
        return $this->netCashMovement;
    }

    public function setNetCashMovement(int|float|null $netCashMovement): self
    {
        $this->netCashMovement = $netCashMovement;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'openingCashBalance' => Field::number(),
            'closingCashBalance' => Field::number(),
            'netCashMovement' => Field::number(),
        ];
    }
}
