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
            fn (array $association): Association => $this->mapAssociation($association),
            $payload['Items'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return ResourceCollection<AssociationCount>
     */
    public function countFor(string ...$objectIds): ResourceCollection
    {
        $payload = $this->client
            ->get('/files.xro/1.0/Associations/Count')
            ->withQuery([
                'ObjectIds' => implode(',', $objectIds),
            ])
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $count): AssociationCount => $this->mapAssociationCount($count),
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

    /**
     * @param array<string, mixed> $payload
     */
    public function mapAssociation(array $payload): Association
    {
        return (new Association())
            ->setObjectId(isset($payload['ObjectId']) ? (string) $payload['ObjectId'] : null)
            ->setObjectType(isset($payload['ObjectType']) ? (string) $payload['ObjectType'] : null)
            ->setObjectGroup(isset($payload['ObjectGroup']) ? (string) $payload['ObjectGroup'] : null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapAssociationCount(array $payload): AssociationCount
    {
        return (new AssociationCount())
            ->setObjectId(isset($payload['ObjectId']) ? (string) $payload['ObjectId'] : null)
            ->setCount(isset($payload['Count']) ? (int) $payload['Count'] : null);
    }
}
