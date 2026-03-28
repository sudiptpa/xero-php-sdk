<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BrandingTheme;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class BrandingThemes implements DefinesScopes
{
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

    /**
     * @return ResourceCollection<BrandingTheme>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/BrandingThemes')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $brandingTheme): BrandingTheme => $this->mapBrandingTheme($brandingTheme),
            $payload['BrandingThemes'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $brandingThemeId): ?BrandingTheme
    {
        $response = $this->client
            ->get('/api.xro/2.0/BrandingThemes/' . $brandingThemeId)
            ->send();

        $payload = $response->json();
        $brandingTheme = $payload['BrandingThemes'][0] ?? null;

        return is_array($brandingTheme) ? $this->mapBrandingTheme($brandingTheme) : null;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapBrandingTheme(array $payload): BrandingTheme
    {
        return (new BrandingTheme())
            ->setBrandingThemeID(isset($payload['BrandingThemeID']) ? (string) $payload['BrandingThemeID'] : null)
            ->setName(isset($payload['Name']) ? (string) $payload['Name'] : null)
            ->setSortOrder(isset($payload['SortOrder']) ? (string) $payload['SortOrder'] : null);
    }
}
