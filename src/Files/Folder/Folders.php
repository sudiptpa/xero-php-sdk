<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\Folder;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Folders implements DefinesScopes
{
    private const BASE_PATH = '/files.xro/1.0/Folders';

    private ?string $sort = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['files'],
            granular: ['files.read', 'files']
        );
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $clone = clone $this;
        $clone->sort = $field . ' ' . strtoupper($direction);

        return $clone;
    }

    /**
     * @return ResourceCollection<Folder>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get(self::BASE_PATH)
            ->withQuery($this->sort === null ? [] : ['sort' => $this->sort])
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $folder): Folder => Folder::fromArray($folder, $this->client),
            $payload['Items'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $folderId): ?Folder
    {
        $response = $this->client
            ->get(self::BASE_PATH . '/' . $folderId)
            ->send();

        $payload = $response->json();
        $folder = $payload['Items'][0] ?? null;

        return is_array($folder) ? Folder::fromArray($folder, $this->client) : null;
    }

    public function inbox(): ?Folder
    {
        $response = $this->client
            ->get('/files.xro/1.0/Inbox')
            ->send();

        $payload = $response->json();
        $folder = $payload['Items'][0] ?? null;

        return is_array($folder) ? Folder::fromArray($folder, $this->client) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $folderId): Payload
    {
        return (new Payload($this->client))->id($folderId);
    }

    public function delete(string $folderId): bool
    {
        $response = $this->client
            ->delete(self::BASE_PATH . '/' . $folderId)
            ->send();

        return $response->status === 204;
    }
}
