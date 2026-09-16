<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Client;
use Sujip\Xero\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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

        $items = array_map(
            fn (array $fund): SuperFund => $this->mapSuperFund($fund),
            Json::extractList($payload, 'SuperFunds')
        );

        return new ResourceCollection($items);
    }

    public function find(string $superFundId): ?SuperFund
    {
        $payload = $this->client
            ->get('/payroll.xro/1.0/SuperFunds/' . $superFundId)
            ->send()
            ->json();

        $fund = Json::extractFirst($payload, 'SuperFunds') ?? Json::extractObject($payload, 'SuperFund') ?: null;

        return $fund !== null ? $this->mapSuperFund($fund) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $superFundId): Payload
    {
        return (new Payload($this->client))->id($superFundId);
    }

    /**
     * @param array<string, mixed> $fund
     */
    public function mapSuperFund(array $fund): SuperFund
    {
        return (new SuperFund())->fill($fund);
    }
}
