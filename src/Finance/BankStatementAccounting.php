<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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

    /**
     * @return ResourceCollection<BankStatementEntry>
     */
    public function get(string $bankAccountId, DateTimeInterface $fromDate, DateTimeInterface $toDate, ?bool $summaryOnly = null): ResourceCollection
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

        $items = array_map(
            fn (array $entry): BankStatementEntry => $this->mapBankStatementEntry($entry),
            Json::extractList($payload, 'statements') ?: Json::extractList($payload, 'Statements')
        );

        return new ResourceCollection($items);
    }

    /**
     * @param array<string, mixed> $entry
     */
    public function mapBankStatementEntry(array $entry): BankStatementEntry
    {
        return (new BankStatementEntry())->fill($entry);
    }
}
