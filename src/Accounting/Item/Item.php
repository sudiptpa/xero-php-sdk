<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Item;

use RuntimeException;
use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Item extends Model implements SerializesRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $itemID = null;

    private ?string $code = null;

    private ?string $name = null;

    private ?string $description = null;

    private ?string $inventoryAssetAccountCode = null;

    private ?bool $isPurchased = null;

    private ?bool $isSold = null;

    private ?bool $isTrackedAsInventory = null;

    private ?string $purchaseDescription = null;

    private ?Purchase $purchaseDetails = null;

    private ?Purchase $salesDetails = null;

    private int|float|null $quantityOnHand = null;

    private int|float|null $totalCostPool = null;

    private ?string $statusAttributeString = null;

    private ?string $updatedDateUTC = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function getItemID(): ?string
    {
        return $this->itemID;
    }

    public function setItemID(?string $itemID): self
    {
        $this->itemID = $itemID;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInventoryAssetAccountCode(): ?string
    {
        return $this->inventoryAssetAccountCode;
    }

    public function setInventoryAssetAccountCode(?string $inventoryAssetAccountCode): self
    {
        $this->inventoryAssetAccountCode = $inventoryAssetAccountCode;

        return $this;
    }

    public function getIsPurchased(): ?bool
    {
        return $this->isPurchased;
    }

    public function setIsPurchased(?bool $isPurchased): self
    {
        $this->isPurchased = $isPurchased;

        return $this;
    }

    public function getIsSold(): ?bool
    {
        return $this->isSold;
    }

    public function setIsSold(?bool $isSold): self
    {
        $this->isSold = $isSold;

        return $this;
    }

    public function getIsTrackedAsInventory(): ?bool
    {
        return $this->isTrackedAsInventory;
    }

    public function setIsTrackedAsInventory(?bool $isTrackedAsInventory): self
    {
        $this->isTrackedAsInventory = $isTrackedAsInventory;

        return $this;
    }

    public function getPurchaseDescription(): ?string
    {
        return $this->purchaseDescription;
    }

    public function setPurchaseDescription(?string $purchaseDescription): self
    {
        $this->purchaseDescription = $purchaseDescription;

        return $this;
    }

    public function getPurchaseDetails(): ?Purchase
    {
        return $this->purchaseDetails;
    }

    public function setPurchaseDetails(?Purchase $purchaseDetails): self
    {
        $this->purchaseDetails = $purchaseDetails;

        return $this;
    }

    public function getSalesDetails(): ?Purchase
    {
        return $this->salesDetails;
    }

    public function setSalesDetails(?Purchase $salesDetails): self
    {
        $this->salesDetails = $salesDetails;

        return $this;
    }

    public function getQuantityOnHand(): int|float|null
    {
        return $this->quantityOnHand;
    }

    public function setQuantityOnHand(int|float|null $quantityOnHand): self
    {
        $this->quantityOnHand = $quantityOnHand;

        return $this;
    }

    public function getTotalCostPool(): int|float|null
    {
        return $this->totalCostPool;
    }

    public function setTotalCostPool(int|float|null $totalCostPool): self
    {
        $this->totalCostPool = $totalCostPool;

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

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

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
            'ItemID' => Field::string(),
            'Code' => Field::string(),
            'Name' => Field::string(),
            'Description' => Field::string(),
            'InventoryAssetAccountCode' => Field::string(),
            'IsPurchased' => Field::boolean(),
            'IsSold' => Field::boolean(),
            'IsTrackedAsInventory' => Field::boolean(),
            'PurchaseDescription' => Field::string(),
            'PurchaseDetails' => Field::object(Purchase::class),
            'SalesDetails' => Field::object(Purchase::class),
            'QuantityOnHand' => Field::number(),
            'TotalCostPool' => Field::number(),
            'StatusAttributeString' => Field::string(),
            'UpdatedDateUTC' => Field::string(),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'ItemID' => $this->getItemID(),
            'Code' => $this->getCode(),
            'Name' => $this->getName(),
            'Description' => $this->getDescription(),
            'InventoryAssetAccountCode' => $this->getInventoryAssetAccountCode(),
            'IsPurchased' => $this->getIsPurchased(),
            'IsSold' => $this->getIsSold(),
            'IsTrackedAsInventory' => $this->getIsTrackedAsInventory(),
            'PurchaseDescription' => $this->getPurchaseDescription(),
            'PurchaseDetails' => $this->getPurchaseDetails()?->toRequest(),
            'SalesDetails' => $this->getSalesDetails()?->toRequest(),
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

    public function description(string $description): self
    {
        return $this->setDescription($description);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an item without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function history(): History
    {
        if ($this->client === null || $this->itemID === null) {
            throw new RuntimeException('Cannot access item history without a bound client context and item id.');
        }

        return (new Items($this->client))->history($this->itemID);
    }
}
