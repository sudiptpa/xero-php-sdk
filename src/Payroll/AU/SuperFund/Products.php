<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Products implements DefinesScopes
{
    /**
     * @var array<string, string>
     */
    private array $query = [];

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['payroll.settings'],
            granular: ['payroll.settings.read', 'payroll.settings']
        );
    }

    public function abn(string $abn): self
    {
        $clone = clone $this;
        $clone->query['ABN'] = $abn;

        return $clone;
    }

    public function usi(string $usi): self
    {
        $clone = clone $this;
        $clone->query['USI'] = $usi;

        return $clone;
    }

    /**
     * @return ResourceCollection<Product>
     */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/1.0/SuperFundProducts')
            ->withQuery($this->query)
            ->send()
            ->json();

        $items = array_values(array_map(
            static fn (array $product): Product => Product::fromArray($product),
            $payload['SuperFundProducts'] ?? []
        ));

        return new ResourceCollection($items);
    }
}
