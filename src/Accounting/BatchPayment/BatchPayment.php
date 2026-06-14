<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BatchPayment;

use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
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

    private ?string $particulars = null;

    private ?string $code = null;

    private ?string $details = null;

    private ?string $narrative = null;

    private ?string $dateString = null;

    private ?string $date = null;

    private ?string $type = null;

    private int|float|null $totalAmount = null;

    private ?string $updatedDateUTC = null;

    private ?bool $isReconciled = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

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

    public function getParticulars(): ?string
    {
        return $this->particulars;
    }

    public function setParticulars(?string $particulars): self
    {
        $this->particulars = $particulars;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getNarrative(): ?string
    {
        return $this->narrative;
    }

    public function setNarrative(?string $narrative): self
    {
        $this->narrative = $narrative;

        return $this;
    }

    public function getDateString(): ?string
    {
        return $this->dateString;
    }

    public function setDateString(?string $dateString): self
    {
        $this->dateString = $dateString;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTotalAmount(): int|float|null
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(int|float|null $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

        return $this;
    }

    public function getIsReconciled(): ?bool
    {
        return $this->isReconciled;
    }

    public function setIsReconciled(?bool $isReconciled): self
    {
        $this->isReconciled = $isReconciled;

        return $this;
    }

    /**
     * @return list<ValidationError>
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function addValidationError(ValidationError $validationError): self
    {
        $this->validationErrors[] = $validationError;

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
            'Particulars' => Field::string(),
            'Code' => Field::string(),
            'Details' => Field::string(),
            'Narrative' => Field::string(),
            'DateString' => Field::string(),
            'Date' => Field::string(),
            'Type' => Field::string(),
            'TotalAmount' => Field::number(),
            'UpdatedDateUTC' => Field::string(),
            'IsReconciled' => Field::boolean(),
            'ValidationErrors' => Field::many(ValidationError::class),
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
            'Particulars' => $this->getParticulars(),
            'Code' => $this->getCode(),
            'Details' => $this->getDetails(),
            'Narrative' => $this->getNarrative(),
            'DateString' => $this->getDateString(),
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
