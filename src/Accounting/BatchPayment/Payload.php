<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BatchPayment;

use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private BatchPayment $batchPayment;

    public function __construct(
        private readonly Client $client
    ) {
        $this->batchPayment = new BatchPayment($client);
    }

    public function account(string $accountId): self
    {
        $clone = clone $this;
        $clone->batchPayment = clone $this->batchPayment;
        $clone->batchPayment->setAccount(
            (new Account())
                ->setAccountID($accountId)
        );

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->batchPayment = clone $this->batchPayment;
        $clone->batchPayment->setReference($reference);

        return $clone;
    }

    public function payment(string $invoiceId, int|float $amount): self
    {
        $clone = clone $this;
        $clone->batchPayment = clone $this->batchPayment;
        $clone->batchPayment->addPayment(
            (new PaymentEntry())
                ->setInvoiceID($invoiceId)
                ->setAmount($amount)
        );

        return $clone;
    }

    public function using(BatchPayment $batchPayment): self
    {
        $clone = clone $this;
        $clone->batchPayment = clone $batchPayment;

        return $clone;
    }

    public function save(): BatchPayment
    {
        $response = $this->client
            ->post('/api.xro/2.0/BatchPayments')
            ->withJson(['BatchPayments' => [$this->batchPayment->toRequest()]])
            ->send();

        $payload = $response->json();
        $batchPayment = Json::extractFirst($payload, 'BatchPayments') ?? [];

        return (new BatchPayments($this->client))
            ->mapBatchPayment($batchPayment);
    }
}
