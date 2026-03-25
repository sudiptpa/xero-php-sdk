<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Currency;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function code(string $code): self
    {
        $clone = clone $this;
        $clone->payload['Code'] = strtoupper($code);

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;
        $clone->payload['Description'] = $description;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Currency
    {
        $response = $this->client
            ->post('/api.xro/2.0/Currencies')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send();

        $payload = $response->json();
        $currency = $payload['Currencies'][0] ?? $payload['Currency'] ?? [];

        return Currency::fromArray(is_array($currency) ? $currency : [], $this->client);
    }
}
