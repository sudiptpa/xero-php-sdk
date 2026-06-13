<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CashValidationResult extends Model
{
    private ?string $accountId = null;

    private ?StatementBalance $statementBalance = null;

    private ?string $statementBalanceDate = null;

    private ?BankStatement $bankStatement = null;

    private ?CashAccount $cashAccount = null;

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(?string $accountId): self
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getStatementBalance(): ?StatementBalance
    {
        return $this->statementBalance;
    }

    public function setStatementBalance(?StatementBalance $statementBalance): self
    {
        $this->statementBalance = $statementBalance;

        return $this;
    }

    public function getStatementBalanceDate(): ?string
    {
        return $this->statementBalanceDate;
    }

    public function setStatementBalanceDate(?string $statementBalanceDate): self
    {
        $this->statementBalanceDate = $statementBalanceDate;

        return $this;
    }

    public function getBankStatement(): ?BankStatement
    {
        return $this->bankStatement;
    }

    public function setBankStatement(?BankStatement $bankStatement): self
    {
        $this->bankStatement = $bankStatement;

        return $this;
    }

    public function getCashAccount(): ?CashAccount
    {
        return $this->cashAccount;
    }

    public function setCashAccount(?CashAccount $cashAccount): self
    {
        $this->cashAccount = $cashAccount;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'accountId' => Field::string(),
            'statementBalance' => Field::object(StatementBalance::class),
            'statementBalanceDate' => Field::string(),
            'bankStatement' => Field::object(BankStatement::class),
            'cashAccount' => Field::object(CashAccount::class),
        ];
    }
}
