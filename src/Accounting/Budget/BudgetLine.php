<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Budget;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BudgetLine extends Model
{
    private ?string $accountID = null;
    private ?string $accountCode = null;

    /**
     * @var list<BudgetBalance>
     */
    private array $budgetBalances = [];

    public function getAccountID(): ?string
    {
        return $this->accountID;
    }

    public function setAccountID(?string $accountID): self
    {
        $this->accountID = $accountID;

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

    /**
     * @return list<BudgetBalance>
     */
    public function getBudgetBalances(): array
    {
        return $this->budgetBalances;
    }

    /**
     * @param list<BudgetBalance> $budgetBalances
     */
    public function setBudgetBalances(array $budgetBalances): self
    {
        $this->budgetBalances = $budgetBalances;

        return $this;
    }

    public function addBudgetBalance(BudgetBalance $budgetBalance): self
    {
        $this->budgetBalances[] = $budgetBalance;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'AccountID' => Field::string()->using('setAccountID'),
            'AccountCode' => Field::string()->using('setAccountCode'),
            'BudgetBalances' => Field::many(BudgetBalance::class)->using('addBudgetBalance'),
        ];
    }
}
