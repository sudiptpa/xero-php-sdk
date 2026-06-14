<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Accounting\TrackingCategory\TrackingCategory;
use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class JournalLine extends Model implements SerializesRequest
{
    private int|float|null $lineAmount = null;

    private ?string $accountCode = null;

    private ?string $accountID = null;

    private ?string $description = null;

    private ?string $taxType = null;

    private int|float|null $taxAmount = null;

    private ?bool $isBlank = null;

    /**
     * @var list<TrackingCategory>
     */
    private array $tracking = [];

    public function getLineAmount(): int|float|null
    {
        return $this->lineAmount;
    }

    public function setLineAmount(int|float|null $lineAmount): self
    {
        $this->lineAmount = $lineAmount;

        return $this;
    }

    public function getAccountCode(): ?string
    {
        return $this->accountCode;
    }

    public function setAccountCode(?string $accountCode): self
    {
        $this->accountCode = $accountCode;

        return $this;
    }

    public function getAccountID(): ?string
    {
        return $this->accountID;
    }

    public function setAccountID(?string $accountID): self
    {
        $this->accountID = $accountID;

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

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setTaxType(?string $taxType): self
    {
        $this->taxType = $taxType;

        return $this;
    }

    public function getTaxAmount(): int|float|null
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(int|float|null $taxAmount): self
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    public function getIsBlank(): ?bool
    {
        return $this->isBlank;
    }

    public function setIsBlank(?bool $isBlank): self
    {
        $this->isBlank = $isBlank;

        return $this;
    }

    /**
     * @return list<TrackingCategory>
     */
    public function getTracking(): array
    {
        return $this->tracking;
    }

    public function addTracking(TrackingCategory $tracking): self
    {
        $this->tracking[] = $tracking;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'LineAmount' => Field::number(),
            'AccountCode' => Field::string(),
            'AccountID' => Field::string(),
            'Description' => Field::string(),
            'TaxType' => Field::string(),
            'TaxAmount' => Field::number(),
            'IsBlank' => Field::boolean(),
            'Tracking' => Field::many(TrackingCategory::class),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'LineAmount' => $this->getLineAmount(),
            'AccountCode' => $this->getAccountCode(),
            'AccountID' => $this->getAccountID(),
            'Description' => $this->getDescription(),
            'TaxType' => $this->getTaxType(),
            'TaxAmount' => $this->getTaxAmount(),
            'IsBlank' => $this->getIsBlank(),
            'Tracking' => array_map(
                static fn (TrackingCategory $tracking): array => $tracking->toRequest(),
                $this->getTracking()
            ),
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }
}
