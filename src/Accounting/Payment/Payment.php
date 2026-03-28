<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\BuildsFromPayload;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Payment implements BuildsFromPayload, SerializesForRequest
{
    private ?string $paymentID = null;

    private ?float $amount = null;

    private ?string $date = null;

    private ?string $reference = null;

    private ?string $invoiceID = null;

    private ?Account $account = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?Client $client = null): static
    {
        return (new self($client))
            ->setPaymentID($payload['PaymentID'] ?? null)
            ->setAmount(isset($payload['Amount']) ? (float) $payload['Amount'] : null)
            ->setDate($payload['Date'] ?? null)
            ->setReference($payload['Reference'] ?? null)
            ->setInvoiceID($payload['Invoice']['InvoiceID'] ?? null)
            ->setAccount(
                is_array($payload['Account'] ?? null)
                    ? Account::fromPayload($payload['Account'])
                    : null
            );
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return self::fromPayload($payload, $client);
    }

    public function getPaymentID(): ?string
    {
        return $this->paymentID;
    }

    public function setPaymentID(?string $paymentID): self
    {
        $this->paymentID = $paymentID;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(int|float|null $amount): self
    {
        $this->amount = $amount === null ? null : (float) $amount;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
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

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getAccountID(): ?string
    {
        return $this->account?->getAccountID();
    }

    public function setAccountID(?string $accountID): self
    {
        $account = $this->account ?? new Account();
        $account->setAccountID($accountID);
        $this->account = $account;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        $account = $this->getAccount();

        return array_filter([
            'PaymentID' => $this->getPaymentID(),
            'Amount' => $this->getAmount(),
            'Date' => $this->getDate(),
            'Reference' => $this->getReference(),
            'Invoice' => $this->getInvoiceID() === null ? null : ['InvoiceID' => $this->getInvoiceID()],
            'Account' => $account?->toRequest(),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function amount(int|float $amount): self
    {
        return $this->setAmount($amount);
    }

    public function date(string $date): self
    {
        return $this->setDate($date);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a payment without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function history(): History
    {
        if ($this->client === null || $this->paymentID === null) {
            throw new RuntimeException('Cannot access payment history without a bound client context and payment id.');
        }

        return (new Payments($this->client))->history($this->paymentID);
    }
}
