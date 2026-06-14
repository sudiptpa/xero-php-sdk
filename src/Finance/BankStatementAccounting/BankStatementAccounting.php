<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\BankStatementAccounting;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class BankStatementAccounting implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: ['finance.bankstatementsplus.read']
        );
    }

    public function get(string $bankAccountId, DateTimeInterface $fromDate, DateTimeInterface $toDate, ?bool $summaryOnly = null): BankStatementAccountingResult
    {
        $query = [
            'BankAccountID' => $bankAccountId,
            'FromDate' => $fromDate->format('Y-m-d'),
            'ToDate' => $toDate->format('Y-m-d'),
        ];

        if ($summaryOnly !== null) {
            $query['SummaryOnly'] = $summaryOnly;
        }

        $payload = $this->client
            ->get('/finance.xro/1.0/BankStatementsPlus/statements')
            ->withQuery($query)
            ->send()
            ->json();

        return (new BankStatementAccountingResult())->fill($payload);
    }
}
