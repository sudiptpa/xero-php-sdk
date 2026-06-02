<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransaction;

use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private BankTransaction $transaction;

    public function __construct(
        private readonly Client $client
    ) {
        $this->transaction = new BankTransaction($client);
    }

    public function id(string $bankTransactionId): self
    {
        $clone = clone $this;
        $clone->transaction = clone $this->transaction;
        $clone->transaction->setBankTransactionID($bankTransactionId);

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->transaction = clone $this->transaction;
        $clone->transaction->setType($type);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->transaction = clone $this->transaction;
        $clone->transaction->setContact(
            (new Contact())
                ->setContactID($contactId)
        );

        return $clone;
    }

    public function bankAccount(string $accountId): self
    {
        $clone = clone $this;
        $clone->transaction = clone $this->transaction;
        $clone->transaction->setBankAccount(
            (new BankAccount())
                ->setAccountID($accountId)
        );

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->transaction = clone $this->transaction;
        $clone->transaction->setReference($reference);

        return $clone;
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        $clone = clone $this;
        $clone->transaction = clone $this->transaction;
        $clone->transaction->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );

        return $clone;
    }

    public function using(BankTransaction $transaction): self
    {
        $clone = clone $this;
        $clone->transaction = clone $transaction;

        return $clone;
    }

    public function save(): BankTransaction
    {
        $response = $this->client
            ->post('/api.xro/2.0/BankTransactions')
            ->withJson(['BankTransactions' => [$this->transaction->toRequest()]])
            ->send();

        $payload = $response->json();
        $bankTransaction = Json::extractFirst($payload, 'BankTransactions') ?? [];

        return (new BankTransactions($this->client))
            ->mapBankTransaction($bankTransaction);
    }
}
