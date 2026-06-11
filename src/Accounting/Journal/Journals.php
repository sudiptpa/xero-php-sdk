<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Journal;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class Journals implements DefinesScopes
{
    use BuildsQueries;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: ['accounting.journals.read']
        );
    }

    public function offset(int $journalNumber): self
    {
        $clone = clone $this;
        $clone->query['offset'] = $journalNumber;

        return $clone;
    }

    public function paymentsOnly(bool $paymentsOnly = true): self
    {
        $clone = clone $this;
        $clone->query['paymentsOnly'] = $paymentsOnly ? 'true' : 'false';

        return $clone;
    }

    /**
     * @return ResourceCollection<Journal>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Journals')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $journal): Journal => $this->mapJournal($journal),
            Json::extractList($payload, 'Journals')
        );

        return new ResourceCollection($items);
    }

    public function find(string $journalId): ?Journal
    {
        $response = $this->client
            ->get('/api.xro/2.0/Journals/' . $journalId)
            ->send();

        $payload = $response->json();
        $journal = Json::extractFirst($payload, 'Journals');

        return $journal !== null ? $this->mapJournal($journal) : null;
    }

    public function number(int $journalNumber): ?Journal
    {
        $response = $this->client
            ->get('/api.xro/2.0/Journals/' . $journalNumber)
            ->send();

        $payload = $response->json();
        $journal = Json::extractFirst($payload, 'Journals');

        return $journal !== null ? $this->mapJournal($journal) : null;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapJournal(array $payload): Journal
    {
        return (new Journal())->fill($payload);
    }
}
