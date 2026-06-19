<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TrialBalanceAccount extends Model
{
    private ?string $accountId = null;

    private ?string $accountType = null;

    private ?string $accountCode = null;

    private ?string $accountClass = null;

    private ?string $status = null;

    private ?string $reportingCode = null;

    private ?string $accountName = null;

    private ?TrialBalanceEntry $balance = null;

    private int|float|null $signedBalance = null;

    private ?TrialBalanceMovement $accountMovement = null;

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(?string $accountId): self
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(?string $accountType): self
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function getAccountCode(): ?string
    {
        return $this->accountCode;
    }

    public function setAccountCode(?string $accountCode): self
    {
        $this->accountCode = $accountCode;

        return $this;
    }

    public function getAccountClass(): ?string
    {
        return $this->accountClass;
    }

    public function setAccountClass(?string $accountClass): self
    {
        $this->accountClass = $accountClass;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getReportingCode(): ?string
    {
        return $this->reportingCode;
    }

    public function setReportingCode(?string $reportingCode): self
    {
        $this->reportingCode = $reportingCode;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(?string $accountName): self
    {
        $this->accountName = $accountName;

        return $this;
    }

    public function getBalance(): ?TrialBalanceEntry
    {
        return $this->balance;
    }

    public function setBalance(?TrialBalanceEntry $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getSignedBalance(): int|float|null
    {
        return $this->signedBalance;
    }

    public function setSignedBalance(int|float|null $signedBalance): self
    {
        $this->signedBalance = $signedBalance;

        return $this;
    }

    public function getAccountMovement(): ?TrialBalanceMovement
    {
        return $this->accountMovement;
    }

    public function setAccountMovement(?TrialBalanceMovement $accountMovement): self
    {
        $this->accountMovement = $accountMovement;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'accountId' => Field::string(),
            'accountType' => Field::string(),
            'accountCode' => Field::string(),
            'accountClass' => Field::string(),
            'status' => Field::string(),
            'reportingCode' => Field::string(),
            'accountName' => Field::string(),
            'balance' => Field::object(TrialBalanceEntry::class),
            'signedBalance' => Field::number(),
            'accountMovement' => Field::object(TrialBalanceMovement::class),
        ];
    }
}
