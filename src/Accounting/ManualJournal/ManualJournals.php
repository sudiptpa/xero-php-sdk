<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class ManualJournals implements PaginatesResults, DefinesScopes
{
    use BuildsQueries;
    use HasPagination;
    use InteractsWithBindings;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['accounting.transactions'],
            granular: ['accounting.transactions.read', 'accounting.transactions']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<ManualJournal>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/ManualJournals')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $manualJournal): ManualJournal => $this->mapManualJournal($manualJournal),
            $payload['ManualJournals'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<ManualJournal>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedCollection
    {
        $builder = $this;
        if ($page !== null) {
            $builder = $builder->page($page);
        }
        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }
        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/ManualJournals']);
    }

    public function find(string $manualJournalId): ?ManualJournal
    {
        $response = $this->client
            ->get('/api.xro/2.0/ManualJournals/' . $manualJournalId)
            ->send();

        $payload = $response->json();
        $manualJournal = $payload['ManualJournals'][0] ?? null;

        return is_array($manualJournal) ? $this->mapManualJournal($manualJournal) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $manualJournalId): Payload
    {
        return (new Payload($this->client))->id($manualJournalId);
    }

    public function attachments(string $manualJournalId): Attachments
    {
        return new Attachments($this->client, $manualJournalId);
    }

    public function history(string $manualJournalId): History
    {
        return new History($this->client, '/api.xro/2.0/ManualJournals/' . $manualJournalId . '/History');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapManualJournal(array $payload): ManualJournal
    {
        return (new ManualJournal($this->client))->fill($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapJournalLine(array $payload): JournalLine
    {
        return (new JournalLine())->fill($payload);
    }
}
