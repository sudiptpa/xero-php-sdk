<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Prepayment;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Prepayments implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<Prepayment>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Prepayments')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $prepayment): Prepayment => Prepayment::fromPayload($prepayment),
            $payload['Prepayments'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Prepayment>
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
        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/Prepayments']);
    }

    public function find(string $prepaymentId): ?Prepayment
    {
        $response = $this->client
            ->get('/api.xro/2.0/Prepayments/' . $prepaymentId)
            ->send();

        $payload = $response->json();
        $prepayment = $payload['Prepayments'][0] ?? null;

        return is_array($prepayment) ? Prepayment::fromPayload($prepayment) : null;
    }
}
