<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use RuntimeException;
use Sujip\Xero\Client;

final class UsageRecordPayload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $usageRecordId = null;

    private ?string $subscriptionItemId = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $subscriptionId
    ) {
    }

    public function id(string $usageRecordId): self
    {
        $clone = clone $this;
        $clone->usageRecordId = $usageRecordId;

        return $clone;
    }

    public function item(string $subscriptionItemId): self
    {
        $clone = clone $this;
        $clone->subscriptionItemId = $subscriptionItemId;

        return $clone;
    }

    public function quantity(int|float $quantity): self
    {
        $clone = clone $this;
        $clone->payload['quantity'] = $quantity;

        return $clone;
    }

    public function timestamp(string $timestamp): self
    {
        $clone = clone $this;
        $clone->payload['timestamp'] = $timestamp;

        return $clone;
    }

    public function save(): UsageRecord
    {
        $path = $this->path();
        $request = $this->usageRecordId === null
            ? $this->client->post($path)
            : $this->client->put($path);

        $payload = $request
            ->withoutTenant()
            ->withJson($this->payload)
            ->send()
            ->json();

        return (new Subscriptions($this->client))->mapUsageRecord($payload);
    }

    private function path(): string
    {
        if ($this->subscriptionItemId === null) {
            throw new RuntimeException('A subscription item id is required when recording or updating usage.');
        }

        if ($this->usageRecordId === null) {
            return '/appstore/2.0/subscriptions/' . $this->subscriptionId . '/items/' . $this->subscriptionItemId . '/usage-records';
        }

        return '/appstore/2.0/subscriptions/' . $this->subscriptionId . '/items/' . $this->subscriptionItemId . '/usage-records/' . $this->usageRecordId;
    }
}
