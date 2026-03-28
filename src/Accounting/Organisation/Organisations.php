<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Organisations implements DefinesScopes
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
     * @return ResourceCollection<Organisation>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Organisation')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $organisation): Organisation => $this->mapOrganisation($organisation),
            $payload['Organisations'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function current(): ?Organisation
    {
        return $this->get()->first();
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapOrganisation(array $payload): Organisation
    {
        return (new Organisation())
            ->setName(isset($payload['Name']) ? (string) $payload['Name'] : null)
            ->setLegalName(isset($payload['LegalName']) ? (string) $payload['LegalName'] : null)
            ->setShortCode(isset($payload['ShortCode']) ? (string) $payload['ShortCode'] : null)
            ->setCountryCode(isset($payload['CountryCode']) ? (string) $payload['CountryCode'] : null);
    }
}
