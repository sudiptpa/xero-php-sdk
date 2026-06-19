<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

use Sujip\Xero\Accounting\Allocations;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class CreditNotes implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<CreditNote>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/CreditNotes')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $creditNote): CreditNote => $this->mapCreditNote($creditNote),
            Json::extractList($payload, 'CreditNotes')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<CreditNote>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/CreditNotes']);
    }

    public function find(string $creditNoteId): ?CreditNote
    {
        $response = $this->client
            ->get('/api.xro/2.0/CreditNotes/' . $creditNoteId)
            ->send();

        $payload = $response->json();
        $creditNote = Json::extractFirst($payload, 'CreditNotes');

        return $creditNote !== null ? $this->mapCreditNote($creditNote) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $creditNoteId): Payload
    {
        return (new Payload($this->client))->id($creditNoteId);
    }

    public function attachments(string $creditNoteId): Attachments
    {
        return new Attachments($this->client, $creditNoteId);
    }

    public function history(string $creditNoteId): History
    {
        return new History($this->client, $creditNoteId);
    }

    public function allocations(string $creditNoteId): Allocations
    {
        return new Allocations($this->client, '/api.xro/2.0/CreditNotes/' . $creditNoteId . '/Allocations');
    }

    public function pdf(string $creditNoteId): string
    {
        $response = $this->client
            ->get('/api.xro/2.0/CreditNotes/' . $creditNoteId . '/pdf')
            ->withHeaders(['Accept' => 'application/pdf'])
            ->send();

        return $response->body;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapCreditNote(array $payload): CreditNote
    {
        return (new CreditNote($this->client))->fill($payload);
    }
}
