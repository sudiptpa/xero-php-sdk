<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\LinkedTransaction;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class LinkedTransaction extends Model implements SerializesRequest
{
    private ?string $linkedTransactionID = null;

    private ?string $sourceTransactionID = null;

    private ?string $sourceLineItemID = null;

    private ?string $targetTransactionID = null;

    private ?string $targetLineItemID = null;

    private ?string $contactID = null;

    private ?string $status = null;

    private ?string $type = null;

    private ?string $updatedDateUTC = null;

    private ?string $sourceTransactionTypeCode = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function getLinkedTransactionID(): ?string
    {
        return $this->linkedTransactionID;
    }

    public function setLinkedTransactionID(?string $linkedTransactionID): self
    {
        $this->linkedTransactionID = $linkedTransactionID;

        return $this;
    }

    public function getSourceTransactionID(): ?string
    {
        return $this->sourceTransactionID;
    }

    public function setSourceTransactionID(?string $sourceTransactionID): self
    {
        $this->sourceTransactionID = $sourceTransactionID;

        return $this;
    }

    public function getSourceLineItemID(): ?string
    {
        return $this->sourceLineItemID;
    }

    public function setSourceLineItemID(?string $sourceLineItemID): self
    {
        $this->sourceLineItemID = $sourceLineItemID;

        return $this;
    }

    public function getTargetTransactionID(): ?string
    {
        return $this->targetTransactionID;
    }

    public function setTargetTransactionID(?string $targetTransactionID): self
    {
        $this->targetTransactionID = $targetTransactionID;

        return $this;
    }

    public function getTargetLineItemID(): ?string
    {
        return $this->targetLineItemID;
    }

    public function setTargetLineItemID(?string $targetLineItemID): self
    {
        $this->targetLineItemID = $targetLineItemID;

        return $this;
    }

    public function getContactID(): ?string
    {
        return $this->contactID;
    }

    public function setContactID(?string $contactID): self
    {
        $this->contactID = $contactID;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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

    public function getSourceTransactionTypeCode(): ?string
    {
        return $this->sourceTransactionTypeCode;
    }

    public function setSourceTransactionTypeCode(?string $sourceTransactionTypeCode): self
    {
        $this->sourceTransactionTypeCode = $sourceTransactionTypeCode;

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
            'LinkedTransactionID' => Field::string(),
            'SourceTransactionID' => Field::string(),
            'SourceLineItemID' => Field::string(),
            'TargetTransactionID' => Field::string(),
            'TargetLineItemID' => Field::string(),
            'ContactID' => Field::string(),
            'Status' => Field::string(),
            'Type' => Field::string(),
            'UpdatedDateUTC' => Field::string(),
            'SourceTransactionTypeCode' => Field::string(),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'LinkedTransactionID' => $this->getLinkedTransactionID(),
            'SourceTransactionID' => $this->getSourceTransactionID(),
            'SourceLineItemID' => $this->getSourceLineItemID(),
            'TargetTransactionID' => $this->getTargetTransactionID(),
            'TargetLineItemID' => $this->getTargetLineItemID(),
            'ContactID' => $this->getContactID(),
            'Status' => $this->getStatus(),
            'Type' => $this->getType(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
