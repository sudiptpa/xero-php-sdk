<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransfer;

use RuntimeException;
use Sujip\Xero\Accounting\Invoice\LineItemTracking;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class BankTransfer extends Model
{
    private ?string $bankTransferID = null;

    private ?BankAccount $fromBankAccount = null;

    private ?BankAccount $toBankAccount = null;

    private int|float|null $amount = null;

    private ?string $date = null;

    private int|float|null $currencyRate = null;

    private ?string $fromBankTransactionID = null;

    private ?string $toBankTransactionID = null;

    private ?bool $fromIsReconciled = null;

    private ?bool $toIsReconciled = null;

    private ?string $reference = null;

    private ?bool $hasAttachments = null;

    private ?string $createdDateUTC = null;

    private ?string $status = null;

    /**
     * @var list<LineItemTracking>
     */
    private array $fromTracking = [];

    /**
     * @var list<LineItemTracking>
     */
    private array $toTracking = [];

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getBankTransferID(): ?string
    {
        return $this->bankTransferID;
    }

    public function setBankTransferID(?string $bankTransferID): self
    {
        $this->bankTransferID = $bankTransferID;

        return $this;
    }

    public function getFromBankAccount(): ?BankAccount
    {
        return $this->fromBankAccount;
    }

    public function setFromBankAccount(?BankAccount $fromBankAccount): self
    {
        $this->fromBankAccount = $fromBankAccount;

        return $this;
    }

    public function getToBankAccount(): ?BankAccount
    {
        return $this->toBankAccount;
    }

    public function setToBankAccount(?BankAccount $toBankAccount): self
    {
        $this->toBankAccount = $toBankAccount;

        return $this;
    }

    public function getFromBankAccountID(): ?string
    {
        return $this->fromBankAccount?->getAccountID();
    }

    public function setFromBankAccountID(?string $fromBankAccountID): self
    {
        $this->fromBankAccount = $fromBankAccountID === null
            ? null
            : (new BankAccount())->setAccountID($fromBankAccountID);

        return $this;
    }

    public function getToBankAccountID(): ?string
    {
        return $this->toBankAccount?->getAccountID();
    }

    public function setToBankAccountID(?string $toBankAccountID): self
    {
        $this->toBankAccount = $toBankAccountID === null
            ? null
            : (new BankAccount())->setAccountID($toBankAccountID);

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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

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

    public function getFromBankTransactionID(): ?string
    {
        return $this->fromBankTransactionID;
    }

    public function setFromBankTransactionID(?string $fromBankTransactionID): self
    {
        $this->fromBankTransactionID = $fromBankTransactionID;

        return $this;
    }

    public function getToBankTransactionID(): ?string
    {
        return $this->toBankTransactionID;
    }

    public function setToBankTransactionID(?string $toBankTransactionID): self
    {
        $this->toBankTransactionID = $toBankTransactionID;

        return $this;
    }

    public function getFromIsReconciled(): ?bool
    {
        return $this->fromIsReconciled;
    }

    public function setFromIsReconciled(?bool $fromIsReconciled): self
    {
        $this->fromIsReconciled = $fromIsReconciled;

        return $this;
    }

    public function getToIsReconciled(): ?bool
    {
        return $this->toIsReconciled;
    }

    public function setToIsReconciled(?bool $toIsReconciled): self
    {
        $this->toIsReconciled = $toIsReconciled;

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

    public function getHasAttachments(): ?bool
    {
        return $this->hasAttachments;
    }

    public function setHasAttachments(?bool $hasAttachments): self
    {
        $this->hasAttachments = $hasAttachments;

        return $this;
    }

    public function getCreatedDateUTC(): ?string
    {
        return $this->createdDateUTC;
    }

    public function setCreatedDateUTC(?string $createdDateUTC): self
    {
        $this->createdDateUTC = $createdDateUTC;

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

    /**
     * @return list<LineItemTracking>
     */
    public function getFromTracking(): array
    {
        return $this->fromTracking;
    }

    public function addFromTracking(LineItemTracking $fromTracking): self
    {
        $this->fromTracking[] = $fromTracking;

        return $this;
    }

    /**
     * @return list<LineItemTracking>
     */
    public function getToTracking(): array
    {
        return $this->toTracking;
    }

    public function addToTracking(LineItemTracking $toTracking): self
    {
        $this->toTracking[] = $toTracking;

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
            'BankTransferID' => Field::string(),
            'FromBankAccount' => Field::object(BankAccount::class),
            'ToBankAccount' => Field::object(BankAccount::class),
            'Amount' => Field::number(),
            'Date' => Field::string(),
            'CurrencyRate' => Field::number(),
            'FromBankTransactionID' => Field::string(),
            'ToBankTransactionID' => Field::string(),
            'FromIsReconciled' => Field::boolean(),
            'ToIsReconciled' => Field::boolean(),
            'Reference' => Field::string(),
            'HasAttachments' => Field::boolean(),
            'CreatedDateUTC' => Field::string(),
            'Status' => Field::string(),
            'FromTracking' => Field::many(LineItemTracking::class),
            'ToTracking' => Field::many(LineItemTracking::class),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }

    public function amount(int|float $amount): self
    {
        return $this->setAmount($amount);
    }

    public function date(string $date): self
    {
        return $this->setDate($date);
    }

    public function reference(string $reference): self
    {
        return $this->setReference($reference);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a bank transfer without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->fromBankAccount?->getAccountID() !== null) {
            $payload = $payload->fromBankAccount($this->fromBankAccount->getAccountID());
        }

        if ($this->toBankAccount?->getAccountID() !== null) {
            $payload = $payload->toBankAccount($this->toBankAccount->getAccountID());
        }

        if ($this->amount !== null) {
            $payload = $payload->amount($this->amount);
        }

        if ($this->date !== null) {
            $payload = $payload->date($this->date);
        }

        if ($this->reference !== null) {
            $payload = $payload->reference($this->reference);
        }

        return $payload->save();
    }
}
