<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

final readonly class Subscription
{
    /**
     * @param array<string, mixed> $raw
     * @param list<array<string, mixed>> $items
     */
    public function __construct(
        public ?string $id,
        public ?string $planId,
        public ?string $status,
        public ?string $currentPeriodEnd,
        public array $items = [],
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            isset($payload['id']) ? (string) $payload['id'] : (isset($payload['SubscriptionID']) ? (string) $payload['SubscriptionID'] : null),
            isset($payload['planId']) ? (string) $payload['planId'] : (isset($payload['PlanID']) ? (string) $payload['PlanID'] : null),
            isset($payload['status']) ? (string) $payload['status'] : (isset($payload['Status']) ? (string) $payload['Status'] : null),
            isset($payload['currentPeriodEnd']) ? (string) $payload['currentPeriodEnd'] : null,
            array_values(array_filter($payload['items'] ?? $payload['Items'] ?? [], 'is_array')),
            $payload,
            $client
        );
    }

    /**
     * @return ResourceCollection<UsageRecord>
     */
    public function usageRecords(): ResourceCollection
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load usage records without a bound client context and subscription id.');
        }

        return (new Subscriptions($this->client))->usageRecords($this->id);
    }

    public function recordUsage(): UsageRecordPayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot record usage without a bound client context and subscription id.');
        }

        return (new Subscriptions($this->client))->recordUsage($this->id);
    }
}
