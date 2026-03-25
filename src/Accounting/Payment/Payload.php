<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $paymentId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function invoice(string $invoiceId): self
    {
        $clone = clone $this;
        $clone->payload['Invoice'] = ['InvoiceID' => $invoiceId];

        return $clone;
    }

    public function account(string $accountId): self
    {
        $clone = clone $this;
        $clone->payload['Account'] = ['AccountID' => $accountId];

        return $clone;
    }

    public function date(string $date): self
    {
        $clone = clone $this;
        $clone->payload['Date'] = $date;

        return $clone;
    }

    public function amount(int|float $amount): self
    {
        $clone = clone $this;
        $clone->payload['Amount'] = $amount;

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->payload['Reference'] = $reference;

        return $clone;
    }

    public function id(string $paymentId): self
    {
        $clone = clone $this;
        $clone->paymentId = $paymentId;

        return $clone;
    }

    public function save(): Payment
    {
        $path = '/api.xro/2.0/Payments';

        if ($this->paymentId !== null) {
            $path .= '/' . $this->paymentId;
        }

        $response = $this->client
            ->post($path)
            ->withJson([
                'Payments' => [$this->payload],
            ])
            ->send();

        $payload = $response->json();
        $payment = $payload['Payments'][0] ?? [];

        return Payment::fromArray(is_array($payment) ? $payment : [], $this->client);
    }
}
