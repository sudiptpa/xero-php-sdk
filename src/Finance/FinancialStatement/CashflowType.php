<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CashflowType extends Model
{
    private ?string $name = null;

    private int|float|null $total = null;

    /**
     * @var list<CashflowAccount>
     */
    private array $accounts = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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
     * @return list<CashflowAccount>
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * @param list<CashflowAccount> $accounts
     */
    public function setAccounts(array $accounts): self
    {
        $this->accounts = $accounts;

        return $this;
    }

    public function addAccount(CashflowAccount $account): self
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
            'name' => Field::string(),
            'total' => Field::number(),
            'accounts' => Field::many(CashflowAccount::class),
        ];
    }
}
