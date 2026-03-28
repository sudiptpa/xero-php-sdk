<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

use Sujip\Xero\Client;

final class Payload
{
    private Payment $payment;

    public function __construct(
        private readonly Client $client
    ) {
        $this->payment = new Payment($client);
    }

    public function invoice(string $invoiceId): self
    {
        $clone = clone $this;
        $clone->payment = clone $this->payment;
        $clone->payment->setInvoiceID($invoiceId);

        return $clone;
    }

    public function account(string $accountId): self
    {
        $clone = clone $this;
        $clone->payment = clone $this->payment;
        $clone->payment->setAccountID($accountId);

        return $clone;
    }

    public function date(string $date): self
    {
        $clone = clone $this;
        $clone->payment = clone $this->payment;
        $clone->payment->setDate($date);

        return $clone;
    }

    public function amount(int|float $amount): self
    {
        $clone = clone $this;
        $clone->payment = clone $this->payment;
        $clone->payment->setAmount($amount);

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->payment = clone $this->payment;
        $clone->payment->setReference($reference);

        return $clone;
    }

    public function id(string $paymentId): self
    {
        $clone = clone $this;
        $clone->payment = clone $this->payment;
        $clone->payment->setPaymentID($paymentId);

        return $clone;
    }

    public function setPaymentID(?string $paymentId): self
    {
        return $this->id((string) $paymentId);
    }

    public function using(Payment $payment): self
    {
        $clone = clone $this;
        $clone->payment = clone $payment;

        return $clone;
    }

    public function save(): Payment
    {
        $path = '/api.xro/2.0/Payments';

        if ($this->payment->getPaymentID() !== null) {
            $path .= '/' . $this->payment->getPaymentID();
        }

        $response = $this->client
            ->post($path)
            ->withJson([
                'Payments' => [$this->payment->toRequest()],
            ])
            ->send();

        $payload = $response->json();
        $payment = $payload['Payments'][0] ?? [];

        return (new Payments($this->client))
            ->mapPayment(is_array($payment) ? $payment : []);
    }
}
