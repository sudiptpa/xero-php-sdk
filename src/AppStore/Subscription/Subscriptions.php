<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class Subscriptions implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: ['marketplace.billing']
        );
    }

    public function find(string $subscriptionId): Subscription
    {
        $payload = $this->client
            ->get('/subscriptions/' . $subscriptionId)
            ->withoutTenant()
            ->send()
            ->json();

        return Subscription::fromArray($payload, $this->client);
    }

    /**
     * @return ResourceCollection<UsageRecord>
     */
    public function usageRecords(string $subscriptionId): ResourceCollection
    {
        $payload = $this->client
            ->get('/subscriptions/' . $subscriptionId . '/usage-records')
            ->withoutTenant()
            ->send()
            ->json();

        $items = array_values(array_map(
            static fn (array $usageRecord): UsageRecord => UsageRecord::fromArray($usageRecord),
            $payload['items'] ?? $payload['usageRecords'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function recordUsage(string $subscriptionId): UsageRecordPayload
    {
        return new UsageRecordPayload($this->client, $subscriptionId);
    }

    public function updateUsage(string $subscriptionId, string $usageRecordId): UsageRecordPayload
    {
        return (new UsageRecordPayload($this->client, $subscriptionId))->id($usageRecordId);
    }
}
