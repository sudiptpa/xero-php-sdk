<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Account;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Account extends Model implements SerializesRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $accountID = null;

    private ?string $code = null;

    private ?string $name = null;

    private ?string $type = null;

    private ?string $status = null;

    private ?string $description = null;

    private ?string $bankAccountNumber = null;

    private ?string $bankAccountType = null;

    private ?string $currencyCode = null;

    private ?string $taxType = null;

    private ?bool $enablePaymentsToAccount = null;

    private ?bool $showInExpenseClaims = null;

    private ?string $class = null;

    private ?string $systemAccount = null;

    private ?string $reportingCode = null;

    private ?string $reportingCodeName = null;

    private ?bool $hasAttachments = null;

    private ?string $updatedDateUTC = null;

    private ?bool $addToWatchlist = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function getAccountID(): ?string
    {
        return $this->accountID;
    }

    public function setAccountID(?string $accountID): self
    {
        $this->accountID = $accountID;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type === null ? null : strtoupper($type);

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getBankAccountType(): ?string
    {
        return $this->bankAccountType;
    }

    public function setBankAccountType(?string $bankAccountType): self
    {
        $this->bankAccountType = $bankAccountType;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(?string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setTaxType(?string $taxType): self
    {
        $this->taxType = $taxType;

        return $this;
    }

    public function getEnablePaymentsToAccount(): ?bool
    {
        return $this->enablePaymentsToAccount;
    }

    public function setEnablePaymentsToAccount(?bool $enablePaymentsToAccount): self
    {
        $this->enablePaymentsToAccount = $enablePaymentsToAccount;

        return $this;
    }

    public function getShowInExpenseClaims(): ?bool
    {
        return $this->showInExpenseClaims;
    }

    public function setShowInExpenseClaims(?bool $showInExpenseClaims): self
    {
        $this->showInExpenseClaims = $showInExpenseClaims;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getSystemAccount(): ?string
    {
        return $this->systemAccount;
    }

    public function setSystemAccount(?string $systemAccount): self
    {
        $this->systemAccount = $systemAccount;

        return $this;
    }

    public function getReportingCode(): ?string
    {
        return $this->reportingCode;
    }

    public function setReportingCode(?string $reportingCode): self
    {
        $this->reportingCode = $reportingCode;

        return $this;
    }

    public function getReportingCodeName(): ?string
    {
        return $this->reportingCodeName;
    }

    public function setReportingCodeName(?string $reportingCodeName): self
    {
        $this->reportingCodeName = $reportingCodeName;

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

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

        return $this;
    }

    public function getAddToWatchlist(): ?bool
    {
        return $this->addToWatchlist;
    }

    public function setAddToWatchlist(?bool $addToWatchlist): self
    {
        $this->addToWatchlist = $addToWatchlist;

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
            'AccountID' => Field::string(),
            'Code' => Field::string(),
            'Name' => Field::string(),
            'Type' => Field::string(),
            'Status' => Field::string(),
            'Description' => Field::string(),
            'BankAccountNumber' => Field::string(),
            'BankAccountType' => Field::string(),
            'CurrencyCode' => Field::string(),
            'TaxType' => Field::string(),
            'EnablePaymentsToAccount' => Field::boolean(),
            'ShowInExpenseClaims' => Field::boolean(),
            'Class' => Field::string(),
            'SystemAccount' => Field::string(),
            'ReportingCode' => Field::string(),
            'ReportingCodeName' => Field::string(),
            'HasAttachments' => Field::boolean(),
            'UpdatedDateUTC' => Field::string(),
            'AddToWatchlist' => Field::boolean(),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'AccountID' => $this->getAccountID(),
            'Code' => $this->getCode(),
            'Name' => $this->getName(),
            'Type' => $this->getType(),
            'Status' => $this->getStatus(),
            'Description' => $this->getDescription(),
            'BankAccountNumber' => $this->getBankAccountNumber(),
            'BankAccountType' => $this->getBankAccountType(),
            'CurrencyCode' => $this->getCurrencyCode(),
            'TaxType' => $this->getTaxType(),
            'EnablePaymentsToAccount' => $this->getEnablePaymentsToAccount(),
            'ShowInExpenseClaims' => $this->getShowInExpenseClaims(),
            'ReportingCode' => $this->getReportingCode(),
            'AddToWatchlist' => $this->getAddToWatchlist(),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function code(string $code): self
    {
        return $this->setCode($code);
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function type(string $type): self
    {
        return $this->setType($type);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an account without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }
}
