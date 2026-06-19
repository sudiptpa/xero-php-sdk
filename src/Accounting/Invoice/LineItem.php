<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class LineItem extends Model implements SerializesRequest
{
    private ?string $lineItemID = null;

    private ?string $description = null;

    private int|float|null $quantity = null;

    private int|float|null $unitAmount = null;

    private ?string $itemCode = null;

    private ?string $accountCode = null;

    private ?string $accountID = null;

    private ?string $taxType = null;

    private int|float|null $taxAmount = null;

    private ?LineItemItem $item = null;

    private int|float|null $lineAmount = null;

    /**
     * @var list<LineItemTracking>
     */
    private array $tracking = [];

    private int|float|null $discountRate = null;

    private int|float|null $discountAmount = null;

    private ?string $repeatingInvoiceID = null;

    private ?string $taxability = null;

    private int|float|null $salesTaxCodeId = null;

    /**
     * @var list<TaxBreakdownComponent>
     */
    private array $taxBreakdown = [];

    public function getLineItemID(): ?string
    {
        return $this->lineItemID;
    }

    public function setLineItemID(?string $lineItemID): self
    {
        $this->lineItemID = $lineItemID;

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

    public function getQuantity(): int|float|null
    {
        return $this->quantity;
    }

    public function setQuantity(int|float|null $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitAmount(): int|float|null
    {
        return $this->unitAmount;
    }

    public function setUnitAmount(int|float|null $unitAmount): self
    {
        $this->unitAmount = $unitAmount;

        return $this;
    }

    public function getItemCode(): ?string
    {
        return $this->itemCode;
    }

    public function setItemCode(?string $itemCode): self
    {
        $this->itemCode = $itemCode;

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

    public function getItem(): ?LineItemItem
    {
        return $this->item;
    }

    public function setItem(?LineItemItem $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getLineAmount(): int|float|null
    {
        return $this->lineAmount;
    }

    public function setLineAmount(int|float|null $lineAmount): self
    {
        $this->lineAmount = $lineAmount;

        return $this;
    }

    /**
     * @return list<LineItemTracking>
     */
    public function getTracking(): array
    {
        return $this->tracking;
    }

    /**
     * @param list<LineItemTracking> $tracking
     */
    public function setTracking(array $tracking): self
    {
        $this->tracking = $tracking;

        return $this;
    }

    public function addTracking(LineItemTracking $tracking): self
    {
        $this->tracking[] = $tracking;

        return $this;
    }

    public function getDiscountRate(): int|float|null
    {
        return $this->discountRate;
    }

    public function setDiscountRate(int|float|null $discountRate): self
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    public function getDiscountAmount(): int|float|null
    {
        return $this->discountAmount;
    }

    public function setDiscountAmount(int|float|null $discountAmount): self
    {
        $this->discountAmount = $discountAmount;

        return $this;
    }

    public function getRepeatingInvoiceID(): ?string
    {
        return $this->repeatingInvoiceID;
    }

    public function setRepeatingInvoiceID(?string $repeatingInvoiceID): self
    {
        $this->repeatingInvoiceID = $repeatingInvoiceID;

        return $this;
    }

    public function getTaxability(): ?string
    {
        return $this->taxability;
    }

    public function setTaxability(?string $taxability): self
    {
        $this->taxability = $taxability;

        return $this;
    }

    public function getSalesTaxCodeId(): int|float|null
    {
        return $this->salesTaxCodeId;
    }

    public function setSalesTaxCodeId(int|float|null $salesTaxCodeId): self
    {
        $this->salesTaxCodeId = $salesTaxCodeId;

        return $this;
    }

    /**
     * @return list<TaxBreakdownComponent>
     */
    public function getTaxBreakdown(): array
    {
        return $this->taxBreakdown;
    }

    public function addTaxBreakdown(TaxBreakdownComponent $taxBreakdownComponent): self
    {
        $this->taxBreakdown[] = $taxBreakdownComponent;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'LineItemID' => Field::string(),
            'Description' => Field::string(),
            'Quantity' => Field::number(),
            'UnitAmount' => Field::number(),
            'ItemCode' => Field::string(),
            'AccountCode' => Field::string(),
            'AccountID' => Field::string(),
            'TaxType' => Field::string(),
            'TaxAmount' => Field::number(),
            'Item' => Field::object(LineItemItem::class),
            'LineAmount' => Field::number(),
            'Tracking' => Field::many(LineItemTracking::class),
            'DiscountRate' => Field::number(),
            'DiscountAmount' => Field::number(),
            'RepeatingInvoiceID' => Field::string(),
            'Taxability' => Field::string(),
            'SalesTaxCodeId' => Field::number(),
            'TaxBreakdown' => Field::many(TaxBreakdownComponent::class),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'LineItemID' => $this->getLineItemID(),
            'Description' => $this->getDescription(),
            'Quantity' => $this->getQuantity(),
            'UnitAmount' => $this->getUnitAmount(),
            'ItemCode' => $this->getItemCode(),
            'AccountCode' => $this->getAccountCode(),
            'AccountID' => $this->getAccountID(),
            'TaxType' => $this->getTaxType(),
            'TaxAmount' => $this->getTaxAmount(),
            'LineAmount' => $this->getLineAmount(),
            'Tracking' => array_map(
                static fn (LineItemTracking $tracking): array => $tracking->toRequest(),
                $this->getTracking()
            ),
            'DiscountRate' => $this->getDiscountRate(),
            'DiscountAmount' => $this->getDiscountAmount(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
