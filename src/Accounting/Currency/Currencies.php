<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Currency;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Currencies implements DefinesScopes
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
     * @return ResourceCollection<Currency>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Currencies')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $currency): Currency => Currency::fromPayload($currency, $this->client),
            $payload['Currencies'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }
}
