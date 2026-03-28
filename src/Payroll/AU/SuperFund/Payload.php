<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $attributes = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->attributes['Type'] = $type;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->attributes['Name'] = $name;

        return $clone;
    }

    public function uSI(string $usi): self
    {
        $clone = clone $this;
        $clone->attributes['USI'] = $usi;

        return $clone;
    }

    public function abn(string $abn): self
    {
        $clone = clone $this;
        $clone->attributes['ABN'] = $abn;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): SuperFund
    {
        $payload = $this->client
            ->post('/payroll.xro/1.0/SuperFunds')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->attributes)
            ->send()
            ->json();

        /** @var array<string, mixed>|null $fund */
        $fund = $payload['SuperFunds'][0] ?? $payload['SuperFund'] ?? null;

        if (! is_array($fund)) {
            return new SuperFund();
        }

        return (new SuperFunds($this->client))->mapSuperFund($fund);
    }
}
