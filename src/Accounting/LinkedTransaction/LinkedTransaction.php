<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\LinkedTransaction;

use Sujip\Xero\Support\Contracts\BuildsFromPayload;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class LinkedTransaction implements BuildsFromPayload, SerializesForRequest
{
    private ?string $linkedTransactionID = null;

    private ?string $sourceTransactionID = null;

    private ?string $targetTransactionID = null;

    private ?string $contactID = null;

    private ?string $status = null;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?\Sujip\Xero\Client $client = null): static
    {
        return (new self())
            ->setLinkedTransactionID($payload['LinkedTransactionID'] ?? null)
            ->setSourceTransactionID($payload['SourceTransactionID'] ?? null)
            ->setTargetTransactionID($payload['TargetTransactionID'] ?? null)
            ->setContactID($payload['ContactID'] ?? null)
            ->setStatus($payload['Status'] ?? null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return self::fromPayload($payload);
    }

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
