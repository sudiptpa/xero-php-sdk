<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Account;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Accounts implements PaginatesResults, DefinesScopes
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
            broad: ['accounting.settings'],
            granular: ['accounting.accounts.read', 'accounting.accounts']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<Account>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Accounts')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $account): Account => $this->mapAccount($account),
            $payload['Accounts'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Account>
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
            ['path' => '/api.xro/2.0/Accounts']
        );
    }

    public function find(string $accountId): ?Account
    {
        $response = $this->client
            ->get('/api.xro/2.0/Accounts/' . $accountId)
            ->send();

        $payload = $response->json();
        $account = $payload['Accounts'][0] ?? null;

        return is_array($account) ? $this->mapAccount($account) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $accountId): Payload
    {
        return (new Payload($this->client))->id($accountId);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapAccount(array $payload): Account
    {
        return (new Account($this->client))->fill($payload);
    }
}
