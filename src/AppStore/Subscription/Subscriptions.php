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

        return $this->mapSubscription($payload);
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
            fn (array $usageRecord): UsageRecord => $this->mapUsageRecord($usageRecord),
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

    /**
     * @param array<string, mixed> $payload
     */
    public function mapSubscription(array $payload): Subscription
    {
        return (new Subscription($this->client))->fill($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapUsageRecord(array $payload): UsageRecord
    {
        return (new UsageRecord())->fill($payload);
    }
}
