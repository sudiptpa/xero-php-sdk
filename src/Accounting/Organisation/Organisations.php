<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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
        $items = array_map(
            fn (array $organisation): Organisation => $this->mapOrganisation($organisation),
            Json::extractList($payload, 'Organisations')
        );

        return new ResourceCollection($items);
    }

    public function current(): ?Organisation
    {
        return $this->get()->first();
    }

    /**
     * @return ResourceCollection<OrganisationAction>
     */
    public function actions(): ResourceCollection
    {
        $payload = $this->client
            ->get('/api.xro/2.0/Organisation/Actions')
            ->send()
            ->json();

        $items = array_map(
            static fn (array $action): OrganisationAction => new OrganisationAction(
                is_string($action['Name'] ?? null) ? $action['Name'] : null,
                is_string($action['Status'] ?? null) ? $action['Status'] : null
            ),
            Json::extractList($payload, 'Actions')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return ResourceCollection<CisOrgSetting>
     */
    public function cisSettings(string $organisationId): ResourceCollection
    {
        $payload = $this->client
            ->get('/api.xro/2.0/Organisation/' . $organisationId . '/CISSettings')
            ->send()
            ->json();

        $items = array_map(
            static fn (array $setting): CisOrgSetting => new CisOrgSetting(
                isset($setting['CISContractorEnabled']) ? (bool) $setting['CISContractorEnabled'] : null,
                isset($setting['CISSubContractorEnabled']) ? (bool) $setting['CISSubContractorEnabled'] : null,
                is_numeric($setting['Rate'] ?? null) ? (float) $setting['Rate'] : null,
                $setting
            ),
            Json::extractList($payload, 'CISSettings')
        );

        return new ResourceCollection($items);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapOrganisation(array $payload): Organisation
    {
        return (new Organisation())->fill($payload);
    }
}
