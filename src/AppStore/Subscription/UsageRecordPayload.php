<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

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

    public function quantity(float $quantity): self
    {
        $clone = clone $this;
        $clone->payload['quantity'] = $quantity;

        return $clone;
    }

    public function startDate(string $startDate): self
    {
        $clone = clone $this;
        $clone->payload['startDate'] = $startDate;

        return $clone;
    }

    public function endDate(string $endDate): self
    {
        $clone = clone $this;
        $clone->payload['endDate'] = $endDate;

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
        $itemId = $this->subscriptionItemId ?? ($this->payload['subscriptionItemId'] ?? null);

        if (! is_string($itemId) || $itemId === '') {
            throw new \RuntimeException('A subscription item id is required when recording or updating usage.');
        }

        if ($this->usageRecordId === null) {
            return '/subscriptions/' . $this->subscriptionId . '/items/' . $itemId . '/usage-records';
        }

        return '/subscriptions/' . $this->subscriptionId . '/items/' . $itemId . '/usage-records/' . $this->usageRecordId;
    }
}
