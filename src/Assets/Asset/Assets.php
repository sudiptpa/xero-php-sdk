<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Asset;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class Assets implements DefinesScopes
{
    private const BASE_PATH = '/assets.xro/1.0/Assets';

    private ?string $status = null;

    private ?int $page = null;

    private ?int $pageSize = null;

    private ?string $orderBy = null;

    private ?string $sortDirection = null;

    private ?string $filterBy = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['assets'],
            granular: ['assets.read', 'assets']
        );
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->status = strtoupper($status);

        return $clone;
    }

    public function page(int $page): self
    {
        $clone = clone $this;
        $clone->page = $page;

        return $clone;
    }

    public function perPage(int $pageSize): self
    {
        $clone = clone $this;
        $clone->pageSize = $pageSize;

        return $clone;
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $clone = clone $this;
        $clone->orderBy = $field;
        $clone->sortDirection = strtoupper($direction);

        return $clone;
    }

    public function filterBy(string $value): self
    {
        $clone = clone $this;
        $clone->filterBy = $value;

        return $clone;
    }

    /**
     * @return ResourceCollection<Asset>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get(self::BASE_PATH)
            ->withQuery($this->query())
            ->send();

        $payload = $response->json();
        $items = array_map(fn (array $asset): Asset => $this->mapAsset($asset), Json::extractList($payload, 'Items'));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Asset>
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

        return new PaginatedCollection(
            $builder->get(),
            $builder->page,
            $builder->pageSize,
            ['path' => self::BASE_PATH]
        );
    }

    public function find(string $assetId): ?Asset
    {
        $response = $this->client
            ->get(self::BASE_PATH . '/' . $assetId)
            ->send();

        $payload = $response->json();
        $asset = Json::extractFirst($payload, 'Items');

        return $asset !== null ? $this->mapAsset($asset) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    /**
     * @return array<string, int|string>
     */
    private function query(): array
    {
        $query = [];

        if ($this->status !== null) {
            $query['status'] = $this->status;
        }

        if ($this->page !== null) {
            $query['page'] = $this->page;
        }

        if ($this->pageSize !== null) {
            $query['pageSize'] = $this->pageSize;
        }

        if ($this->orderBy !== null) {
            $query['orderBy'] = $this->orderBy;
        }

        if ($this->sortDirection !== null) {
            $query['sortDirection'] = $this->sortDirection;
        }

        if ($this->filterBy !== null) {
            $query['filterBy'] = $this->filterBy;
        }

        return $query;
    }

    /**
     * @param array<string, mixed> $asset
     */
    public function mapAsset(array $asset): Asset
    {
        return (new Asset())->fill($asset);
    }
}
