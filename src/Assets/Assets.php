<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets;

use Sujip\Xero\Assets\Asset\Asset;
use Sujip\Xero\Assets\Asset\Assets as AssetsResource;
use Sujip\Xero\Assets\Asset\Payload as AssetPayload;
use Sujip\Xero\Assets\Settings\Settings;
use Sujip\Xero\Assets\Type\Payload as AssetTypePayload;
use Sujip\Xero\Assets\Type\Type;
use Sujip\Xero\Assets\Type\Types;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Assets implements DefinesScopes
{
    private AssetsResource $assets;

    public function __construct(
        private readonly Client $client
    ) {
        $this->assets = new AssetsResource($client);
    }

    public function scopes(): ScopeRequirements
    {
        return $this->assets->scopes();
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->assets = $this->assets->status($status);

        return $clone;
    }

    public function page(int $page): self
    {
        $clone = clone $this;
        $clone->assets = $this->assets->page($page);

        return $clone;
    }

    public function perPage(int $perPage): self
    {
        $clone = clone $this;
        $clone->assets = $this->assets->perPage($perPage);

        return $clone;
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $clone = clone $this;
        $clone->assets = $this->assets->orderBy($field, $direction);

        return $clone;
    }

    public function filterBy(string $value): self
    {
        $clone = clone $this;
        $clone->assets = $this->assets->filterBy($value);

        return $clone;
    }

    /**
     * @return ResourceCollection<Asset>
     */
    public function get(): ResourceCollection
    {
        return $this->assets->get();
    }

    /**
     * @return PaginatedCollection<Asset>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedCollection
    {
        return $this->assets->paginate($page, $perPage);
    }

    public function find(string $assetId): Asset
    {
        return $this->assets->find($assetId);
    }

    public function create(): AssetPayload
    {
        return $this->assets->create();
    }

    public function assetTypes(): Types
    {
        return new Types($this->client);
    }

    /**
     * @return ResourceCollection<Type>
     */
    public function getAssetTypes(): ResourceCollection
    {
        return $this->assetTypes()->get();
    }

    public function createAssetType(): AssetTypePayload
    {
        return $this->assetTypes()->create();
    }

    public function settings(): Settings
    {
        return Settings::fetch($this->client);
    }

    public function client(): Client
    {
        return $this->client;
    }
}
