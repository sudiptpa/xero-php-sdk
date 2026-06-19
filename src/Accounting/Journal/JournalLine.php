<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Journal;

use Sujip\Xero\Accounting\TrackingCategory\TrackingCategory;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class JournalLine extends Model
{
    private ?string $journalLineID = null;

    private ?string $accountID = null;

    private ?string $accountCode = null;

    private ?string $accountType = null;

    private ?string $accountName = null;

    private ?string $description = null;

    private int|float|null $netAmount = null;

    private int|float|null $grossAmount = null;

    private int|float|null $taxAmount = null;

    private ?string $taxType = null;

    private ?string $taxName = null;

    /**
     * @var list<TrackingCategory>
     */
    private array $trackingCategories = [];

    public function getJournalLineID(): ?string
    {
        return $this->journalLineID;
    }

    public function setJournalLineID(?string $journalLineID): self
    {
        $this->journalLineID = $journalLineID;

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

    public function getAccountCode(): ?string
    {
        return $this->accountCode;
    }

    public function setAccountCode(?string $accountCode): self
    {
        $this->accountCode = $accountCode;

        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(?string $accountType): self
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(?string $accountName): self
    {
        $this->accountName = $accountName;

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

    public function getNetAmount(): int|float|null
    {
        return $this->netAmount;
    }

    public function setNetAmount(int|float|null $netAmount): self
    {
        $this->netAmount = $netAmount;

        return $this;
    }

    public function getGrossAmount(): int|float|null
    {
        return $this->grossAmount;
    }

    public function setGrossAmount(int|float|null $grossAmount): self
    {
        $this->grossAmount = $grossAmount;

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

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setTaxType(?string $taxType): self
    {
        $this->taxType = $taxType;

        return $this;
    }

    public function getTaxName(): ?string
    {
        return $this->taxName;
    }

    public function setTaxName(?string $taxName): self
    {
        $this->taxName = $taxName;

        return $this;
    }

    /**
     * @return list<TrackingCategory>
     */
    public function getTrackingCategories(): array
    {
        return $this->trackingCategories;
    }

    public function addTrackingCategory(TrackingCategory $trackingCategory): self
    {
        $this->trackingCategories[] = $trackingCategory;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'JournalLineID' => Field::string(),
            'AccountID' => Field::string(),
            'AccountCode' => Field::string(),
            'AccountType' => Field::string(),
            'AccountName' => Field::string(),
            'Description' => Field::string(),
            'NetAmount' => Field::number(),
            'GrossAmount' => Field::number(),
            'TaxAmount' => Field::number(),
            'TaxType' => Field::string(),
            'TaxName' => Field::string(),
            'TrackingCategories' => Field::many(TrackingCategory::class),
        ];
    }
}
