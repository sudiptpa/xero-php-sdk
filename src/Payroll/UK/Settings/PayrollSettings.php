<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PayrollSettings extends Model
{
    /**
     * @param list<Account> $accounts
     */
    public function __construct(
        private array $accounts = [],
    ) {
    }

    /**
     * @return list<Account>
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * @param list<Account> $accounts
     */
    public function setAccounts(array $accounts): self
    {
        $this->accounts = $accounts;

        return $this;
    }

    public function addAccount(Account $account): self
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
            'accounts' => Field::many(Account::class),
        ];
    }
}
