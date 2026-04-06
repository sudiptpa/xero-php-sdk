<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class ObjectAssociations implements DefinesScopes
{
    private const BASE_PATH = '/files.xro/1.0/Associations';

    private ?int $page = null;

    private ?int $perPage = null;

    private ?string $sort = null;

    private ?string $direction = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $objectId
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['files'],
            granular: ['files.read', 'files']
        );
    }

    public function page(int $page): self
    {
        $clone = clone $this;
        $clone->page = $page;

        return $clone;
    }

    public function perPage(int $perPage): self
    {
        $clone = clone $this;
        $clone->perPage = $perPage;

        return $clone;
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $clone = clone $this;
        $clone->sort = $field;
        $clone->direction = strtoupper($direction);

        return $clone;
    }

    /**
     * @return ResourceCollection<File>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get(self::BASE_PATH . '/' . $this->objectId)
            ->withQuery($this->query())
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $file): File => (new Files($this->client))->mapFile($file),
            $payload['Items'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<File>
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
            $builder->perPage,
            ['path' => self::BASE_PATH . '/' . $this->objectId]
        );
    }

    /**
     * @return array<string, int|string>
     */
    private function query(): array
    {
        $query = [];

        if ($this->page !== null) {
            $query['page'] = $this->page;
        }

        if ($this->perPage !== null) {
            $query['pagesize'] = $this->perPage;
        }

        if ($this->sort !== null) {
            $query['sort'] = $this->sort;
        }

        if ($this->direction !== null) {
            $query['direction'] = $this->direction;
        }

        return $query;
    }
}
