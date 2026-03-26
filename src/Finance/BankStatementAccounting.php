<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
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
            granular: ['finance.cashvalidation.read']
        );
    }

    /**
     * @return ResourceCollection<BankStatementEntry>
     */
    public function get(?DateTimeInterface $balanceDate = null, ?DateTimeInterface $asAtSystemDate = null): ResourceCollection
    {
        $query = [];

        if ($balanceDate !== null) {
            $query['balanceDate'] = $balanceDate->format('Y-m-d');
        }

        if ($asAtSystemDate !== null) {
            $query['asAtSystemDate'] = $asAtSystemDate->format('Y-m-d');
        }

        $payload = $this->client
            ->get('/finance.xro/1.0/BankStatementAccounting')
            ->withQuery($query)
            ->send()
            ->json();

        $items = array_values(array_map(
            static fn (array $entry): BankStatementEntry => BankStatementEntry::fromArray($entry),
            $payload['Items'] ?? $payload['BankStatementAccounting'] ?? []
        ));

        return new ResourceCollection($items);
    }
}
