<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Currency;

use Sujip\Xero\Client;

final class Payload
{
    private Currency $currency;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
        $this->currency = new Currency($client);
    }

    public function code(string $code): self
    {
        $clone = clone $this;
        $clone->currency = clone $this->currency;
        $clone->currency->setCode($code);

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;
        $clone->currency = clone $this->currency;
        $clone->currency->setDescription($description);

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function using(Currency $currency): self
    {
        $clone = clone $this;
        $clone->currency = clone $currency;

        return $clone;
    }

    public function save(): Currency
    {
        $response = $this->client
            ->post('/api.xro/2.0/Currencies')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->currency->toRequest())
            ->send();

        $payload = $response->json();
        $currency = $payload['Currencies'][0] ?? $payload['Currency'] ?? [];

        return Currency::fromPayload(is_array($currency) ? $currency : [], $this->client);
    }
}
