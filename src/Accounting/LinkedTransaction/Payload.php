<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\LinkedTransaction;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function sourceTransaction(string $id): self
    {
        $clone = clone $this;
        $clone->payload['SourceTransactionID'] = $id;

        return $clone;
    }

    public function targetTransaction(string $id): self
    {
        $clone = clone $this;
        $clone->payload['TargetTransactionID'] = $id;

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->payload['ContactID'] = $contactId;

        return $clone;
    }

    public function save(): LinkedTransaction
    {
        $response = $this->client
            ->post('/api.xro/2.0/LinkedTransactions')
            ->withJson($this->payload)
            ->send();

        $payload = $response->json();
        $linkedTransaction = $payload['LinkedTransactions'][0] ?? $payload['LinkedTransaction'] ?? [];

        return LinkedTransaction::fromArray(is_array($linkedTransaction) ? $linkedTransaction : []);
    }
}
