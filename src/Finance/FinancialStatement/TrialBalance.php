<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TrialBalance extends Model
{
    private ?string $startDate = null;

    private ?string $endDate = null;

    /**
     * @var list<TrialBalanceAccount>
     */
    private array $accounts = [];

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

    /**
     * @return list<TrialBalanceAccount>
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * @param list<TrialBalanceAccount> $accounts
     */
    public function setAccounts(array $accounts): self
    {
        $this->accounts = $accounts;

        return $this;
    }

    public function addAccount(TrialBalanceAccount $account): self
    {
        $this->accounts[] = $account;

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
            'accounts' => Field::many(TrialBalanceAccount::class),
        ];
    }
}
