<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ExpenseClaim;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class ExpenseClaims implements DefinesScopes
{
    use BuildsQueries;
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
     * @return ResourceCollection<ExpenseClaim>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/ExpenseClaims')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $expenseClaim): ExpenseClaim => $this->mapExpenseClaim($expenseClaim),
            Json::extractList($payload, 'ExpenseClaims')
        );

        return new ResourceCollection($items);
    }

    public function find(string $expenseClaimId): ?ExpenseClaim
    {
        $response = $this->client
            ->get('/api.xro/2.0/ExpenseClaims/' . $expenseClaimId)
            ->send();

        $payload = $response->json();
        $expenseClaim = Json::extractFirst($payload, 'ExpenseClaims');

        return $expenseClaim !== null ? $this->mapExpenseClaim($expenseClaim) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $expenseClaimId): Payload
    {
        return (new Payload($this->client))->id($expenseClaimId);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapExpenseClaim(array $payload): ExpenseClaim
    {
        return (new ExpenseClaim($this->client))->fill($payload);
    }
}
