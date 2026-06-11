<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\LinkedTransaction;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private LinkedTransaction $linkedTransaction;

    public function __construct(
        private readonly Client $client
    ) {
        $this->linkedTransaction = new LinkedTransaction();
    }

    public function sourceTransaction(string $id): self
    {
        $clone = clone $this;
        $clone->linkedTransaction = clone $this->linkedTransaction;
        $clone->linkedTransaction->setSourceTransactionID($id);

        return $clone;
    }

    public function targetTransaction(string $id): self
    {
        $clone = clone $this;
        $clone->linkedTransaction = clone $this->linkedTransaction;
        $clone->linkedTransaction->setTargetTransactionID($id);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->linkedTransaction = clone $this->linkedTransaction;
        $clone->linkedTransaction->setContactID($contactId);

        return $clone;
    }

    public function using(LinkedTransaction $linkedTransaction): self
    {
        $clone = clone $this;
        $clone->linkedTransaction = clone $linkedTransaction;

        return $clone;
    }

    public function save(): LinkedTransaction
    {
        $response = $this->client
            ->post('/api.xro/2.0/LinkedTransactions')
            ->withJson($this->linkedTransaction->toRequest())
            ->send();

        $payload = $response->json();
        $linkedTransaction = Json::extractFirst($payload, 'LinkedTransactions') ?? Json::extractObject($payload, 'LinkedTransaction');

        return (new LinkedTransactions($this->client))->mapLinkedTransaction($linkedTransaction);
    }
}
