<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Budget;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Budgets implements DefinesScopes
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
            granular: ['accounting.budgets.read']
        );
    }

    public function dateFrom(string $date): self
    {
        $clone = clone $this;
        $clone->query['DateFrom'] = $date;

        return $clone;
    }

    public function dateTo(string $date): self
    {
        $clone = clone $this;
        $clone->query['DateTo'] = $date;

        return $clone;
    }

    /**
     * @return ResourceCollection<Budget>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Budgets')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $budget): Budget => $this->mapBudget($budget),
            Json::extractList($payload, 'Budgets')
        );

        return new ResourceCollection($items);
    }

    public function find(string $budgetId): ?Budget
    {
        $response = $this->client
            ->get('/api.xro/2.0/Budgets/' . $budgetId)
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $budget = Json::extractFirst($payload, 'Budgets');

        return $budget !== null ? $this->mapBudget($budget) : null;
    }

    /**
     * @param array<string, mixed> $budget
     */
    public function mapBudget(array $budget): Budget
    {
        return (new Budget())->fill($budget);
    }
}
