<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Asset;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Asset extends Model
{
    private ?string $assetId = null;

    private ?string $assetName = null;

    private ?string $assetTypeId = null;

    private ?string $assetNumber = null;

    private ?string $purchaseDate = null;

    private int|float|null $purchasePrice = null;

    private ?string $disposalDate = null;

    private int|float|null $disposalPrice = null;

    private ?string $assetStatus = null;

    private ?string $warrantyExpiryDate = null;

    private ?string $serialNumber = null;

    private ?BookDepreciationSetting $bookDepreciationSetting = null;

    private ?BookDepreciationDetail $bookDepreciationDetail = null;

    private ?bool $canRollback = null;

    private int|float|null $accountingBookValue = null;

    private ?bool $isDeleteEnabledForDate = null;

    public function getAssetId(): ?string
    {
        return $this->assetId;
    }

    public function setAssetId(?string $assetId): self
    {
        $this->assetId = $assetId;

        return $this;
    }

    public function getAssetName(): ?string
    {
        return $this->assetName;
    }

    public function setAssetName(?string $assetName): self
    {
        $this->assetName = $assetName;

        return $this;
    }

    public function getAssetTypeId(): ?string
    {
        return $this->assetTypeId;
    }

    public function setAssetTypeId(?string $assetTypeId): self
    {
        $this->assetTypeId = $assetTypeId;

        return $this;
    }

    public function getAssetNumber(): ?string
    {
        return $this->assetNumber;
    }

    public function setAssetNumber(?string $assetNumber): self
    {
        $this->assetNumber = $assetNumber;

        return $this;
    }

    public function getPurchaseDate(): ?string
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(?string $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getPurchasePrice(): int|float|null
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(int|float|null $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getDisposalDate(): ?string
    {
        return $this->disposalDate;
    }

    public function setDisposalDate(?string $disposalDate): self
    {
        $this->disposalDate = $disposalDate;

        return $this;
    }

    public function getDisposalPrice(): int|float|null
    {
        return $this->disposalPrice;
    }

    public function setDisposalPrice(int|float|null $disposalPrice): self
    {
        $this->disposalPrice = $disposalPrice;

        return $this;
    }

    public function getAssetStatus(): ?string
    {
        return $this->assetStatus;
    }

    public function setAssetStatus(?string $assetStatus): self
    {
        $this->assetStatus = $assetStatus;

        return $this;
    }

    public function getWarrantyExpiryDate(): ?string
    {
        return $this->warrantyExpiryDate;
    }

    public function setWarrantyExpiryDate(?string $warrantyExpiryDate): self
    {
        $this->warrantyExpiryDate = $warrantyExpiryDate;

        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(?string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getBookDepreciationSetting(): ?BookDepreciationSetting
    {
        return $this->bookDepreciationSetting;
    }

    public function setBookDepreciationSetting(?BookDepreciationSetting $bookDepreciationSetting): self
    {
        $this->bookDepreciationSetting = $bookDepreciationSetting;

        return $this;
    }

    public function getBookDepreciationDetail(): ?BookDepreciationDetail
    {
        return $this->bookDepreciationDetail;
    }

    public function setBookDepreciationDetail(?BookDepreciationDetail $bookDepreciationDetail): self
    {
        $this->bookDepreciationDetail = $bookDepreciationDetail;

        return $this;
    }

    public function getCanRollback(): ?bool
    {
        return $this->canRollback;
    }

    public function setCanRollback(?bool $canRollback): self
    {
        $this->canRollback = $canRollback;

        return $this;
    }

    public function getAccountingBookValue(): int|float|null
    {
        return $this->accountingBookValue;
    }

    public function setAccountingBookValue(int|float|null $accountingBookValue): self
    {
        $this->accountingBookValue = $accountingBookValue;

        return $this;
    }

    public function getIsDeleteEnabledForDate(): ?bool
    {
        return $this->isDeleteEnabledForDate;
    }

    public function setIsDeleteEnabledForDate(?bool $isDeleteEnabledForDate): self
    {
        $this->isDeleteEnabledForDate = $isDeleteEnabledForDate;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'assetId' => Field::string(),
            'assetName' => Field::string(),
            'assetTypeId' => Field::string(),
            'assetNumber' => Field::string(),
            'purchaseDate' => Field::string(),
            'purchasePrice' => Field::number(),
            'disposalDate' => Field::string(),
            'disposalPrice' => Field::number(),
            'assetStatus' => Field::string(),
            'warrantyExpiryDate' => Field::string(),
            'serialNumber' => Field::string(),
            'bookDepreciationSetting' => Field::object(BookDepreciationSetting::class),
            'bookDepreciationDetail' => Field::object(BookDepreciationDetail::class),
            'canRollback' => Field::boolean(),
            'accountingBookValue' => Field::number(),
            'isDeleteEnabledForDate' => Field::boolean(),
        ];
    }
}
