<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TrackingCategory;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $trackingCategoryId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $trackingCategoryId): self
    {
        $clone = clone $this;
        $clone->trackingCategoryId = $trackingCategoryId;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['Name'] = $name;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): TrackingCategory
    {
        $path = '/api.xro/2.0/TrackingCategories';

        if ($this->trackingCategoryId !== null) {
            $path .= '/' . $this->trackingCategoryId;
        }

        $response = $this->client
            ->post($path)
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send();

        $payload = $response->json();
        $trackingCategory = $payload['TrackingCategories'][0] ?? $payload['TrackingCategory'] ?? [];

        return TrackingCategory::fromArray(is_array($trackingCategory) ? $trackingCategory : [], $this->client);
    }
}
