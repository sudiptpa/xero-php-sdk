<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BatchPayment;

use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class BatchPayment extends Model implements SerializesRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $batchPaymentID = null;

    private ?string $reference = null;

    private ?string $status = null;

    private int|float|null $amount = null;

    private ?Account $account = null;

    /**
     * @var list<PaymentEntry>
     */
    private array $payments = [];

    public function getBatchPaymentID(): ?string
    {
        return $this->batchPaymentID;
    }

    public function setBatchPaymentID(?string $batchPaymentID): self
    {
        $this->batchPaymentID = $batchPaymentID;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return list<PaymentEntry>
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * @param list<PaymentEntry> $payments
     */
    public function setPayments(array $payments): self
    {
        $this->payments = $payments;

        return $this;
    }

    public function addPayment(PaymentEntry $payment): self
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'BatchPaymentID' => Field::string(),
            'Reference' => Field::string(),
            'Status' => Field::string(),
            'Amount' => Field::number(),
            'Account' => Field::object(Account::class),
            'Payments' => Field::many(PaymentEntry::class),
        ];
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
        return array_filter([
            'BatchPaymentID' => $this->getBatchPaymentID(),
            'Reference' => $this->getReference(),
            'Status' => $this->getStatus(),
            'Amount' => $this->getAmount(),
            'Account' => $this->getAccount()?->toRequest(),
            'Payments' => array_map(
                static fn (PaymentEntry $payment): array => $payment->toRequest(),
                $this->getPayments()
            ),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function history(): History
    {
        if ($this->client === null || $this->batchPaymentID === null) {
            throw new RuntimeException('Cannot access batch payment history without a bound client context and batch payment id.');
        }

        return (new BatchPayments($this->client))->history($this->batchPaymentID);
    }
}
