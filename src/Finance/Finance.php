<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance;

use Sujip\Xero\Client;
use Sujip\Xero\Finance\AccountingActivity\AccountingActivities;
use Sujip\Xero\Finance\BankStatementAccounting\BankStatementAccounting;
use Sujip\Xero\Finance\CashValidation\CashValidation;
use Sujip\Xero\Finance\FinancialStatement\FinancialStatements;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class Finance implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: [
                'finance.accountingactivity.read',
                'finance.cashvalidation.read',
                'finance.statements.read',
            ]
        );
    }

    public function accountingActivities(): AccountingActivities
    {
        return new AccountingActivities($this->client);
    }

    public function cashValidation(): CashValidation
    {
        return new CashValidation($this->client);
    }

    public function bankStatementAccounting(): BankStatementAccounting
    {
        return new BankStatementAccounting($this->client);
    }

    public function statements(): FinancialStatements
    {
        return new FinancialStatements($this->client);
    }
}
