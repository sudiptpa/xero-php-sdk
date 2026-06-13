<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PnlAccountType extends Model
{
    private int|float|null $total = null;

    private ?string $title = null;

    /**
     * @var list<PnlAccount>
     */
    private array $accounts = [];

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return list<PnlAccount>
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * @param list<PnlAccount> $accounts
     */
    public function setAccounts(array $accounts): self
    {
        $this->accounts = $accounts;

        return $this;
    }

    public function addAccount(PnlAccount $account): self
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
            'total' => Field::number(),
            'title' => Field::string(),
            'accounts' => Field::many(PnlAccount::class),
        ];
    }
}
