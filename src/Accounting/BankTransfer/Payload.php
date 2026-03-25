<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransfer;

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

    public function fromBankAccount(string $accountId): self
    {
        $clone = clone $this;
        $clone->payload['FromBankAccount'] = ['AccountID' => $accountId];

        return $clone;
    }

    public function toBankAccount(string $accountId): self
    {
        $clone = clone $this;
        $clone->payload['ToBankAccount'] = ['AccountID' => $accountId];

        return $clone;
    }

    public function amount(int|float $amount): self
    {
        $clone = clone $this;
        $clone->payload['Amount'] = $amount;

        return $clone;
    }

    public function date(string $date): self
    {
        $clone = clone $this;
        $clone->payload['Date'] = $date;

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->payload['Reference'] = $reference;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): BankTransfer
    {
        $response = $this->client
            ->post('/api.xro/2.0/BankTransfers')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['BankTransfers' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $bankTransfer = $payload['BankTransfers'][0] ?? [];

        return BankTransfer::fromArray(is_array($bankTransfer) ? $bankTransfer : [], $this->client);
    }
}
