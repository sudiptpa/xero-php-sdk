<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class SuperFunds implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['payroll.settings'],
            granular: ['payroll.settings.read', 'payroll.settings']
        );
    }

    /**
     * @return ResourceCollection<SuperFund>
     */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/1.0/SuperFunds')
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $fund): SuperFund => $this->mapSuperFund($fund),
            $payload['SuperFunds'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $superFundId): ?SuperFund
    {
        $payload = $this->client
            ->get('/payroll.xro/1.0/SuperFunds/' . $superFundId)
            ->send()
            ->json();

        $fund = $payload['SuperFunds'][0] ?? $payload['SuperFund'] ?? null;

        return is_array($fund) ? $this->mapSuperFund($fund) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    /**
     * @param array<string, mixed> $fund
     */
    public function mapSuperFund(array $fund): SuperFund
    {
        return (new SuperFund())
            ->setSuperFundID($fund['SuperFundID'] ?? null)
            ->setName($fund['Name'] ?? null)
            ->setType($fund['Type'] ?? null)
            ;
    }
}
