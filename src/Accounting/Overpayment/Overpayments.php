<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Overpayment;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

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
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $overpayment): Overpayment => Overpayment::fromPayload($overpayment),
            $payload['Overpayments'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Overpayment>
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
        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/Overpayments']);
    }

    public function find(string $overpaymentId): ?Overpayment
    {
        $response = $this->client
            ->get('/api.xro/2.0/Overpayments/' . $overpaymentId)
            ->send();

        $payload = $response->json();
        $overpayment = $payload['Overpayments'][0] ?? null;

        return is_array($overpayment) ? Overpayment::fromPayload($overpayment) : null;
    }
}
