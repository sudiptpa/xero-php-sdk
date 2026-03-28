<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BatchPayment;

use Sujip\Xero\Support\Contracts\BuildsFromPayload;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class PaymentEntry implements BuildsFromPayload, SerializesForRequest
{
    private ?string $invoiceID = null;

    private int|float|null $amount = null;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?\Sujip\Xero\Client $client = null): static
    {
        return (new self())
            ->setInvoiceID($payload['Invoice']['InvoiceID'] ?? null)
            ->setAmount($payload['Amount'] ?? null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?\Sujip\Xero\Client $client = null): self
    {
        return self::fromPayload($payload, $client);
    }

    public function getInvoiceID(): ?string
    {
        return $this->invoiceID;
    }

    public function setInvoiceID(?string $invoiceID): self
    {
        $this->invoiceID = $invoiceID;

        return $this;
    }

    public function getAmount(): int|float|null
    {
        return $this->amount;
    }

    public function setAmount(int|float|null $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Invoice' => $this->getInvoiceID() === null ? null : ['InvoiceID' => $this->getInvoiceID()],
            'Amount' => $this->getAmount(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
