<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransaction;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $bankTransactionId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $bankTransactionId): self
    {
        $clone = clone $this;
        $clone->bankTransactionId = $bankTransactionId;

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->payload['Type'] = strtoupper($type);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->payload['Contact'] = ['ContactID' => $contactId];

        return $clone;
    }

    public function bankAccount(string $accountId): self
    {
        $clone = clone $this;
        $clone->payload['BankAccount'] = ['AccountID' => $accountId];

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->payload['Reference'] = $reference;

        return $clone;
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        $clone = clone $this;
        $clone->payload['LineItems'] ??= [];
        $clone->payload['LineItems'][] = [
            'Description' => $description,
            'Quantity' => $quantity,
            'UnitAmount' => $unitAmount,
        ];

        return $clone;
    }

    public function save(): BankTransaction
    {
        if ($this->bankTransactionId !== null) {
            $this->payload['BankTransactionID'] = $this->bankTransactionId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/BankTransactions')
            ->withJson(['BankTransactions' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $bankTransaction = $payload['BankTransactions'][0] ?? [];

        return BankTransaction::fromArray(is_array($bankTransaction) ? $bankTransaction : [], $this->client);
    }
}
