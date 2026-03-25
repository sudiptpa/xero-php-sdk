<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BatchPayment;

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

    public function account(string $accountId): self
    {
        $clone = clone $this;
        $clone->payload['Account'] = ['AccountID' => $accountId];

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->payload['Reference'] = $reference;

        return $clone;
    }

    public function payment(string $invoiceId, int|float $amount): self
    {
        $clone = clone $this;
        $clone->payload['Payments'] ??= [];
        $clone->payload['Payments'][] = [
            'Invoice' => ['InvoiceID' => $invoiceId],
            'Amount' => $amount,
        ];

        return $clone;
    }

    public function save(): BatchPayment
    {
        $response = $this->client
            ->post('/api.xro/2.0/BatchPayments')
            ->withJson(['BatchPayments' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $batchPayment = $payload['BatchPayments'][0] ?? [];

        return BatchPayment::fromArray(is_array($batchPayment) ? $batchPayment : []);
    }
}
