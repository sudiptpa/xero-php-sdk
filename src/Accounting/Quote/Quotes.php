<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Quote;

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
use Sujip\Xero\Support\Json;

final class Quotes implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<Quote>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Quotes')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $quote): Quote => $this->mapQuote($quote),
            Json::extractList($payload, 'Quotes')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Quote>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/Quotes']);
    }

    public function find(string $quoteId): ?Quote
    {
        $response = $this->client
            ->get('/api.xro/2.0/Quotes/' . $quoteId)
            ->send();

        $payload = $response->json();
        $quote = Json::extractFirst($payload, 'Quotes');

        return $quote !== null ? $this->mapQuote($quote) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $quoteId): Payload
    {
        return (new Payload($this->client))->id($quoteId);
    }

    public function history(string $quoteId): History
    {
        return new History($this->client, '/api.xro/2.0/Quotes/' . $quoteId . '/History');
    }

    public function pdf(string $quoteId): string
    {
        $response = $this->client
            ->get('/api.xro/2.0/Quotes/' . $quoteId . '/pdf')
            ->withHeaders(['Accept' => 'application/pdf'])
            ->send();

        return $response->body;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapQuote(array $payload): Quote
    {
        return (new Quote($this->client))->fill($payload);
    }
}
