<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class TaxRates implements DefinesScopes
{
    use BuildsQueries;
    use InteractsWithBindings;

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

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<TaxRate>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/TaxRates')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $taxRate): TaxRate => $this->mapTaxRate($taxRate),
            Json::extractList($payload, 'TaxRates')
        );

        return new ResourceCollection($items);
    }

    public function find(string $taxType): ?TaxRate
    {
        $response = $this->client
            ->get('/api.xro/2.0/TaxRates/' . $taxType)
            ->send();

        $payload = $response->json();
        $taxRate = Json::extractFirst($payload, 'TaxRates');

        return $taxRate !== null ? $this->mapTaxRate($taxRate) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $taxType): Payload
    {
        return (new Payload($this->client))->taxType($taxType);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapTaxRate(array $payload): TaxRate
    {
        return (new TaxRate($this->client))->fill($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapComponent(array $payload): Component
    {
        return (new Component())->fill($payload);
    }
}
