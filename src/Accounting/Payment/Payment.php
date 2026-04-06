<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Payment extends Model implements SerializesRequest
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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'PaymentID' => Field::string(),
            'Amount' => Field::number(),
            'Date' => Field::string(),
            'Reference' => Field::string(),
            'Account' => Field::object(Account::class),
            'Invoice' => Field::object(InvoiceReference::class)->using('applyInvoiceReference'),
        ];
    }

    public function applyInvoiceReference(?InvoiceReference $reference): self
    {
        return $this->setInvoiceID($reference?->getInvoiceID());
    }

    protected function newDefinitionInstance(string $class): object
    {
        if ($class === Account::class) {
            return new Account($this->client);
        }

        return parent::newDefinitionInstance($class);
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
