<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Invoices implements PaginatesResults, DefinesScopes
{
    use BuildsQueries;
    use HasPagination;
    use InteractsWithBindings;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function create(): Draft
    {
        return new Draft($this->client);
    }

    public function update(string $invoiceId): Draft
    {
        return (new Draft($this->client))->id($invoiceId);
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['accounting.transactions'],
            granular: ['accounting.invoices.read', 'accounting.invoices']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<Invoice>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Invoices')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $invoice): Invoice => Invoice::fromArray($invoice, $this->client),
            $payload['Invoices'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Invoice>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedResult
    {
        $builder = $this;

        if ($page !== null) {
            $builder = $builder->page($page);
        }

        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }

        return new PaginatedResult(
            $builder->get(),
            $builder->currentPage(),
            $builder->currentPerPage(),
            [
                'path' => '/api.xro/2.0/Invoices',
            ]
        );
    }

    public function find(string $invoiceId): ?Invoice
    {
        $response = $this->client
            ->get('/api.xro/2.0/Invoices/' . $invoiceId)
            ->send();

        $payload = $response->json();
        $invoice = $payload['Invoices'][0] ?? null;

        return is_array($invoice) ? Invoice::fromArray($invoice, $this->client) : null;
    }

    public function attachments(string $invoiceId): Attachments
    {
        return new Attachments($this->client, $invoiceId);
    }

    public function history(string $invoiceId): History
    {
        return new History($this->client, $invoiceId);
    }

    public function pdf(string $invoiceId): string
    {
        $response = $this->client
            ->get('/api.xro/2.0/Invoices/' . $invoiceId . '/pdf')
            ->withHeaders(['Accept' => 'application/pdf'])
            ->send();

        return $response->body;
    }
}
