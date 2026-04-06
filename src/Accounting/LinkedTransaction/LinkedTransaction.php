<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\LinkedTransaction;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class LinkedTransaction extends Model implements SerializesRequest
{
    private ?string $linkedTransactionID = null;

    private ?string $sourceTransactionID = null;

    private ?string $targetTransactionID = null;

    private ?string $contactID = null;

    private ?string $status = null;

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

    public function getTargetTransactionID(): ?string
    {
        return $this->targetTransactionID;
    }

    public function setTargetTransactionID(?string $targetTransactionID): self
    {
        $this->targetTransactionID = $targetTransactionID;

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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'LinkedTransactionID' => Field::string(),
            'SourceTransactionID' => Field::string(),
            'TargetTransactionID' => Field::string(),
            'ContactID' => Field::string(),
            'Status' => Field::string(),
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
            'TargetTransactionID' => $this->getTargetTransactionID(),
            'ContactID' => $this->getContactID(),
            'Status' => $this->getStatus(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
