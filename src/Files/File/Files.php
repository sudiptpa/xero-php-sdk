<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Files implements DefinesScopes
{
    private const BASE_PATH = '/files.xro/1.0';

    private ?int $page = null;

    private ?int $perPage = null;

    private ?string $sort = null;

    private ?string $direction = null;

    public function __construct(
        private readonly Client $client,
        private readonly ?string $folderId = null
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

    public function inFolder(string $folderId): self
    {
        return new self($this->client, $folderId);
    }

    /**
     * @return ResourceCollection<File>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get($this->collectionPath())
            ->withQuery($this->query())
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $file): File => File::fromPayload($file, $this->client),
            $payload['Items'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<File>
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
            $builder->page,
            $builder->perPage,
            ['path' => $builder->collectionPath()]
        );
    }

    public function find(string $fileId): ?File
    {
        $response = $this->client
            ->get(self::BASE_PATH . '/Files/' . $fileId)
            ->send();

        $payload = $response->json();
        $file = $payload['Items'][0] ?? null;

        return is_array($file) ? File::fromPayload($file, $this->client) : null;
    }

    public function content(string $fileId): string
    {
        return $this->client
            ->get(self::BASE_PATH . '/Files/' . $fileId . '/Content')
            ->send()
            ->body;
    }

    public function delete(string $fileId): bool
    {
        $response = $this->client
            ->delete(self::BASE_PATH . '/Files/' . $fileId)
            ->send();

        return $response->status === 204;
    }

    public function upload(string $name, string $content, ?string $filename = null): Upload
    {
        return new Upload($this->client, $name, $content, $filename, $this->folderId);
    }

    public function update(string $fileId): Payload
    {
        return (new Payload($this->client))->id($fileId);
    }

    public function associations(string $fileId): Associations
    {
        return new Associations($this->client, $fileId);
    }

    public function forObject(string $objectId): ObjectAssociations
    {
        return new ObjectAssociations($this->client, $objectId);
    }

    public function client(): Client
    {
        return $this->client;
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

    private function collectionPath(): string
    {
        if ($this->folderId !== null) {
            return self::BASE_PATH . '/Folders/' . $this->folderId . '/Files';
        }

        return self::BASE_PATH . '/Files';
    }
}
