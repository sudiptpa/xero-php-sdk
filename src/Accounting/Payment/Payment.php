<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Accounting\BatchPayment\BatchPayment;
use Sujip\Xero\Accounting\CreditNote\CreditNote;
use Sujip\Xero\Accounting\Overpayment\Overpayment;
use Sujip\Xero\Accounting\Prepayment\Prepayment;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Payment extends Model implements SerializesRequest
{
    private ?string $paymentID = null;

    private ?float $amount = null;

    private ?string $date = null;

    private ?string $reference = null;

    private ?string $invoiceID = null;

    private ?Account $account = null;

    private ?CreditNote $creditNote = null;

    private ?Prepayment $prepayment = null;

    private ?Overpayment $overpayment = null;

    private ?string $invoiceNumber = null;

    private ?string $creditNoteNumber = null;

    private ?BatchPayment $batchPayment = null;

    private ?string $batchPaymentID = null;

    private ?string $code = null;

    private int|float|null $currencyRate = null;

    private int|float|null $bankAmount = null;

    private ?bool $isReconciled = null;

    private ?string $status = null;

    private ?string $paymentType = null;

    private ?string $updatedDateUTC = null;

    private ?string $bankAccountNumber = null;

    private ?string $particulars = null;

    private ?string $details = null;

    private ?bool $hasAccount = null;

    private ?bool $hasValidationErrors = null;

    private ?string $statusAttributeString = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    /**
     * @var list<ValidationError>
     */
    private array $warnings = [];

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

    public function getCreditNote(): ?CreditNote
    {
        return $this->creditNote;
    }

    public function setCreditNote(?CreditNote $creditNote): self
    {
        $this->creditNote = $creditNote;

        return $this;
    }

    public function getPrepayment(): ?Prepayment
    {
        return $this->prepayment;
    }

    public function setPrepayment(?Prepayment $prepayment): self
    {
        $this->prepayment = $prepayment;

        return $this;
    }

    public function getOverpayment(): ?Overpayment
    {
        return $this->overpayment;
    }

    public function setOverpayment(?Overpayment $overpayment): self
    {
        $this->overpayment = $overpayment;

        return $this;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(?string $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    public function getCreditNoteNumber(): ?string
    {
        return $this->creditNoteNumber;
    }

    public function setCreditNoteNumber(?string $creditNoteNumber): self
    {
        $this->creditNoteNumber = $creditNoteNumber;

        return $this;
    }

    public function getBatchPayment(): ?BatchPayment
    {
        return $this->batchPayment;
    }

    public function setBatchPayment(?BatchPayment $batchPayment): self
    {
        $this->batchPayment = $batchPayment;

        return $this;
    }

    public function getBatchPaymentID(): ?string
    {
        return $this->batchPaymentID;
    }

    public function setBatchPaymentID(?string $batchPaymentID): self
    {
        $this->batchPaymentID = $batchPaymentID;

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

    public function getCurrencyRate(): int|float|null
    {
        return $this->currencyRate;
    }

    public function setCurrencyRate(int|float|null $currencyRate): self
    {
        $this->currencyRate = $currencyRate;

        return $this;
    }

    public function getBankAmount(): int|float|null
    {
        return $this->bankAmount;
    }

    public function setBankAmount(int|float|null $bankAmount): self
    {
        $this->bankAmount = $bankAmount;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function setPaymentType(?string $paymentType): self
    {
        $this->paymentType = $paymentType;

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

    public function getBankAccountNumber(): ?string
    {
        return $this->bankAccountNumber;
    }

    public function setBankAccountNumber(?string $bankAccountNumber): self
    {
        $this->bankAccountNumber = $bankAccountNumber;

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

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getHasAccount(): ?bool
    {
        return $this->hasAccount;
    }

    public function setHasAccount(?bool $hasAccount): self
    {
        $this->hasAccount = $hasAccount;

        return $this;
    }

    public function getHasValidationErrors(): ?bool
    {
        return $this->hasValidationErrors;
    }

    public function setHasValidationErrors(?bool $hasValidationErrors): self
    {
        $this->hasValidationErrors = $hasValidationErrors;

        return $this;
    }

    public function getStatusAttributeString(): ?string
    {
        return $this->statusAttributeString;
    }

    public function setStatusAttributeString(?string $statusAttributeString): self
    {
        $this->statusAttributeString = $statusAttributeString;

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
     * @return list<ValidationError>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function addWarning(ValidationError $warning): self
    {
        $this->warnings[] = $warning;

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
            'CreditNote' => Field::object(CreditNote::class),
            'Prepayment' => Field::object(Prepayment::class),
            'Overpayment' => Field::object(Overpayment::class),
            'InvoiceNumber' => Field::string(),
            'CreditNoteNumber' => Field::string(),
            'BatchPayment' => Field::object(BatchPayment::class),
            'BatchPaymentID' => Field::string(),
            'Code' => Field::string(),
            'CurrencyRate' => Field::number(),
            'BankAmount' => Field::number(),
            'IsReconciled' => Field::boolean(),
            'Status' => Field::string(),
            'PaymentType' => Field::string(),
            'UpdatedDateUTC' => Field::string(),
            'BankAccountNumber' => Field::string(),
            'Particulars' => Field::string(),
            'Details' => Field::string(),
            'HasAccount' => Field::boolean(),
            'HasValidationErrors' => Field::boolean(),
            'StatusAttributeString' => Field::string(),
            'ValidationErrors' => Field::many(ValidationError::class),
            'Warnings' => Field::many(ValidationError::class),
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

        if ($class === CreditNote::class) {
            return new CreditNote($this->client);
        }

        if ($class === BatchPayment::class) {
            return new BatchPayment($this->client);
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
            'CreditNote' => $this->getCreditNote()?->toRequest(),
            'InvoiceNumber' => $this->getInvoiceNumber(),
            'CreditNoteNumber' => $this->getCreditNoteNumber(),
            'BatchPayment' => $this->getBatchPayment()?->toRequest(),
            'Code' => $this->getCode(),
            'CurrencyRate' => $this->getCurrencyRate(),
            'BankAmount' => $this->getBankAmount(),
            'IsReconciled' => $this->getIsReconciled(),
            'Status' => $this->getStatus(),
            'BankAccountNumber' => $this->getBankAccountNumber(),
            'Particulars' => $this->getParticulars(),
            'Details' => $this->getDetails(),
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
