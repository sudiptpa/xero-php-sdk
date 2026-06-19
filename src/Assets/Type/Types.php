<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Type;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class Types implements DefinesScopes
{
    private const BASE_PATH = '/assets.xro/1.0/AssetTypes';

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

    /**
     * @return ResourceCollection<Type>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get(self::BASE_PATH)
            ->send();

        $payload = $response->json();
        $items = array_map(fn (array $type): Type => $this->mapType($type), Json::extractRows($payload));

        return new ResourceCollection($items);
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    /**
     * @param array<string, mixed> $type
     */
    public function mapType(array $type): Type
    {
        return (new Type())->fill($type);
    }
}
