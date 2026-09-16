<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Overpayment;

use Sujip\Xero\Accounting\Allocations;
use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Concerns\BuildsQueries;
use Sujip\Xero\Concerns\HasPagination;
use Sujip\Xero\Concerns\InteractsWithBindings;
use Sujip\Xero\Contracts\DefinesScopes;
use Sujip\Xero\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class Overpayments implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<Overpayment>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Overpayments')
            ->withHeaders($this->queryHeaders())
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $overpayment): Overpayment => $this->mapOverpayment($overpayment),
            Json::extractList($payload, 'Overpayments')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Overpayment>
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
        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/Overpayments']);
    }

    public function find(string $overpaymentId): ?Overpayment
    {
        $response = $this->client
            ->get('/api.xro/2.0/Overpayments/' . $overpaymentId)
            ->send();

        $payload = $response->json();
        $overpayment = Json::extractFirst($payload, 'Overpayments');

        return $overpayment !== null ? $this->mapOverpayment($overpayment) : null;
    }

    public function allocations(string $overpaymentId): Allocations
    {
        return new Allocations($this->client, '/api.xro/2.0/Overpayments/' . $overpaymentId . '/Allocations');
    }

    public function history(string $overpaymentId): History
    {
        return new History($this->client, '/api.xro/2.0/Overpayments/' . $overpaymentId . '/History');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapOverpayment(array $payload): Overpayment
    {
        return (new Overpayment())->fill($payload);
    }
}
