<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

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
        $items = array_values(array_map(
            fn (array $taxRate): TaxRate => $this->mapTaxRate($taxRate),
            $payload['TaxRates'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $taxType): ?TaxRate
    {
        $response = $this->client
            ->get('/api.xro/2.0/TaxRates/' . $taxType)
            ->send();

        $payload = $response->json();
        $taxRate = $payload['TaxRates'][0] ?? null;

        return is_array($taxRate) ? $this->mapTaxRate($taxRate) : null;
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
        $taxRate = (new TaxRate($this->client))
            ->setName(isset($payload['Name']) ? (string) $payload['Name'] : null)
            ->setTaxType(isset($payload['TaxType']) ? (string) $payload['TaxType'] : null)
            ->setStatus(isset($payload['Status']) ? (string) $payload['Status'] : null);

        foreach ($payload['TaxComponents'] ?? [] as $component) {
            if (is_array($component)) {
                $taxRate->addTaxComponent($this->mapComponent($component));
            }
        }

        return $taxRate;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapComponent(array $payload): Component
    {
        return (new Component())
            ->setName(isset($payload['Name']) ? (string) $payload['Name'] : null)
            ->setRate(isset($payload['Rate']) && is_numeric($payload['Rate']) ? $payload['Rate'] + 0 : null);
    }
}
