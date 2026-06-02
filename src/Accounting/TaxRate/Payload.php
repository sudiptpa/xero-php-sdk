<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private TaxRate $taxRate;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
        $this->taxRate = new TaxRate($client);
    }

    public function taxType(string $taxType): self
    {
        $clone = clone $this;
        $clone->taxRate = clone $this->taxRate;
        $clone->taxRate->setTaxType($taxType);

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->taxRate = clone $this->taxRate;
        $clone->taxRate->setName($name);

        return $clone;
    }

    public function component(string $name, int|float $rate): self
    {
        $clone = clone $this;
        $clone->taxRate = clone $this->taxRate;
        $clone->taxRate->addTaxComponent(
            (new Component())
                ->setName($name)
                ->setRate($rate)
        );

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function using(TaxRate $taxRate): self
    {
        $clone = clone $this;
        $clone->taxRate = clone $taxRate;

        return $clone;
    }

    public function save(): TaxRate
    {
        $response = $this->client
            ->post('/api.xro/2.0/TaxRates')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson([
                'TaxRates' => [$this->taxRate->toRequest()],
            ])
            ->send();

        $decoded = $response->json();
        $taxRate = Json::extractFirst($decoded, 'TaxRates') ?? [];

        return (new TaxRates($this->client))
            ->mapTaxRate($taxRate);
    }
}
