<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Balances extends Model
{
    private ?AccountBalance $accountsReceivable = null;

    private ?AccountBalance $accountsPayable = null;

    public function getAccountsReceivable(): ?AccountBalance
    {
        return $this->accountsReceivable;
    }

    public function setAccountsReceivable(?AccountBalance $accountsReceivable): self
    {
        $this->accountsReceivable = $accountsReceivable;

        return $this;
    }

    public function getAccountsPayable(): ?AccountBalance
    {
        return $this->accountsPayable;
    }

    public function setAccountsPayable(?AccountBalance $accountsPayable): self
    {
        $this->accountsPayable = $accountsPayable;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'AccountsReceivable' => Field::object(AccountBalance::class),
            'AccountsPayable' => Field::object(AccountBalance::class),
        ];
    }
}
