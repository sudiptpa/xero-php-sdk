<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BalanceSheetAccountType extends Model
{
    private ?string $accountType = null;

    /**
     * @var list<BalanceSheetAccountDetail>
     */
    private array $accounts = [];

    private int|float|null $total = null;

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(?string $accountType): self
    {
        $this->accountType = $accountType;

        return $this;
    }

    /**
     * @return list<BalanceSheetAccountDetail>
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * @param list<BalanceSheetAccountDetail> $accounts
     */
    public function setAccounts(array $accounts): self
    {
        $this->accounts = $accounts;

        return $this;
    }

    public function addAccount(BalanceSheetAccountDetail $account): self
    {
        $this->accounts[] = $account;

        return $this;
    }

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'accountType' => Field::string(),
            'accounts' => Field::many(BalanceSheetAccountDetail::class),
            'total' => Field::number(),
        ];
    }
}
