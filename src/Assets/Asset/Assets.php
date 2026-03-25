<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Asset;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Assets implements DefinesScopes
{
    private const BASE_PATH = '/assets.xro/1.0/Assets';

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
     * @return ResourceCollection<Asset>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get(self::BASE_PATH)
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $asset): Asset => Asset::fromArray($asset),
            $payload['Items'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $assetId): ?Asset
    {
        $response = $this->client
            ->get(self::BASE_PATH . '/' . $assetId)
            ->send();

        $payload = $response->json();
        $asset = $payload['Items'][0] ?? null;

        return is_array($asset) ? Asset::fromArray($asset) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }
}
