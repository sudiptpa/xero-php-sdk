<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Item;

use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Items implements PaginatesResults, DefinesScopes
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
            granular: ['accounting.settings.read', 'accounting.settings']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<Item>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Items')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $item): Item => $this->mapItem($item),
            $payload['Items'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Item>
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
            ['path' => '/api.xro/2.0/Items']
        );
    }

    public function find(string $itemId): ?Item
    {
        $response = $this->client
            ->get('/api.xro/2.0/Items/' . $itemId)
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $item = $payload['Items'][0] ?? null;

        return is_array($item) ? $this->mapItem($item) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $itemId): Payload
    {
        return (new Payload($this->client))->id($itemId);
    }

    public function history(string $itemId): History
    {
        return new History($this->client, '/api.xro/2.0/Items/' . $itemId . '/History');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapItem(array $payload): Item
    {
        return (new Item($this->client))
            ->setItemID(isset($payload['ItemID']) ? (string) $payload['ItemID'] : null)
            ->setCode(isset($payload['Code']) ? (string) $payload['Code'] : null)
            ->setName(isset($payload['Name']) ? (string) $payload['Name'] : null)
            ->setDescription(isset($payload['Description']) ? (string) $payload['Description'] : null);
    }
}
