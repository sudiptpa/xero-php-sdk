<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Associations implements DefinesScopes
{
    private const BASE_PATH = '/files.xro/1.0/Files';

    public function __construct(
        private readonly Client $client,
        private readonly string $fileId
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['files'],
            granular: ['files.read', 'files']
        );
    }

    /**
     * @return ResourceCollection<Association>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get(self::BASE_PATH . '/' . $this->fileId . '/Associations')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $association): Association => Association::fromArray($association),
            $payload['Items'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function attach(string $objectId, string $objectType, ?string $objectGroup = null): AssociationPayload
    {
        return (new AssociationPayload($this->client, $this->fileId))
            ->objectId($objectId)
            ->objectType($objectType)
            ->objectGroup($objectGroup);
    }

    public function delete(string $objectId): bool
    {
        $response = $this->client
            ->delete(self::BASE_PATH . '/' . $this->fileId . '/Associations/' . $objectId)
            ->send();

        return $response->status === 204;
    }
}
