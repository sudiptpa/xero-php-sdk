<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PayrollSettings extends Model
{
    /**
     * @param list<array<string, mixed>> $accounts
     */
    public function __construct(
        private array $accounts = [],
    ) {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * @param list<array<string, mixed>> $accounts
     */
    public function setAccounts(array $accounts): self
    {
        $this->accounts = $accounts;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'accounts' => Field::array()->using('setAccounts'),
        ];
    }
}
