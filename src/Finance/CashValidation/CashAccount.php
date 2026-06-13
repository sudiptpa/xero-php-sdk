<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CashAccount extends Model
{
    private int|float|null $unreconciledAmountPos = null;

    private int|float|null $unreconciledAmountNeg = null;

    private int|float|null $startingBalance = null;

    private int|float|null $accountBalance = null;

    private ?string $balanceCurrency = null;

    public function getUnreconciledAmountPos(): int|float|null
    {
        return $this->unreconciledAmountPos;
    }

    public function setUnreconciledAmountPos(int|float|null $unreconciledAmountPos): self
    {
        $this->unreconciledAmountPos = $unreconciledAmountPos;

        return $this;
    }

    public function getUnreconciledAmountNeg(): int|float|null
    {
        return $this->unreconciledAmountNeg;
    }

    public function setUnreconciledAmountNeg(int|float|null $unreconciledAmountNeg): self
    {
        $this->unreconciledAmountNeg = $unreconciledAmountNeg;

        return $this;
    }

    public function getStartingBalance(): int|float|null
    {
        return $this->startingBalance;
    }

    public function setStartingBalance(int|float|null $startingBalance): self
    {
        $this->startingBalance = $startingBalance;

        return $this;
    }

    public function getAccountBalance(): int|float|null
    {
        return $this->accountBalance;
    }

    public function setAccountBalance(int|float|null $accountBalance): self
    {
        $this->accountBalance = $accountBalance;

        return $this;
    }

    public function getBalanceCurrency(): ?string
    {
        return $this->balanceCurrency;
    }

    public function setBalanceCurrency(?string $balanceCurrency): self
    {
        $this->balanceCurrency = $balanceCurrency;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'unreconciledAmountPos' => Field::number(),
            'unreconciledAmountNeg' => Field::number(),
            'startingBalance' => Field::number(),
            'accountBalance' => Field::number(),
            'balanceCurrency' => Field::string(),
        ];
    }
}
