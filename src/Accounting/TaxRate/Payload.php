<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    /**
     * @var list<array<string, mixed>>
     */
    private array $components = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function taxType(string $taxType): self
    {
        $clone = clone $this;
        $clone->payload['TaxType'] = $taxType;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['Name'] = $name;

        return $clone;
    }

    public function component(string $name, int|float $rate): self
    {
        $clone = clone $this;
        $clone->components[] = ['Name' => $name, 'Rate' => $rate];

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): TaxRate
    {
        $payload = $this->payload;

        if ($this->components !== []) {
            $payload['TaxComponents'] = $this->components;
        }

        $response = $this->client
            ->post('/api.xro/2.0/TaxRates')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson([
                'TaxRates' => [$payload],
            ])
            ->send();

        $decoded = $response->json();
        $taxRate = $decoded['TaxRates'][0] ?? [];

        return TaxRate::fromArray(is_array($taxRate) ? $taxRate : [], $this->client);
    }
}
