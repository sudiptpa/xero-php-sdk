<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TrackingCategory;

use Sujip\Xero\Client;

final class Payload
{
    private TrackingCategory $trackingCategory;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
        $this->trackingCategory = new TrackingCategory($client);
    }

    public function id(string $trackingCategoryId): self
    {
        $clone = clone $this;
        $clone->trackingCategory = clone $this->trackingCategory;
        $clone->trackingCategory->setTrackingCategoryID($trackingCategoryId);

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->trackingCategory = clone $this->trackingCategory;
        $clone->trackingCategory->setName($name);

        return $clone;
    }

    public function option(string $name): self
    {
        $clone = clone $this;
        $clone->trackingCategory = clone $this->trackingCategory;
        $clone->trackingCategory->addOption(
            (new Option())->setName($name)
        );

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function using(TrackingCategory $trackingCategory): self
    {
        $clone = clone $this;
        $clone->trackingCategory = clone $trackingCategory;

        return $clone;
    }

    public function save(): TrackingCategory
    {
        $path = '/api.xro/2.0/TrackingCategories';

        if ($this->trackingCategory->getTrackingCategoryID() !== null) {
            $path .= '/' . $this->trackingCategory->getTrackingCategoryID();
        }

        $response = $this->client
            ->post($path)
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->trackingCategory->toRequest())
            ->send();

        $payload = $response->json();
        $trackingCategory = $payload['TrackingCategories'][0] ?? $payload['TrackingCategory'] ?? [];

        return TrackingCategory::fromArray(is_array($trackingCategory) ? $trackingCategory : [], $this->client);
    }
}
