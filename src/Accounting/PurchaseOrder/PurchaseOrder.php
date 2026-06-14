<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Accounting\History;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\AttachmentDetail;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class PurchaseOrder extends Model implements SerializesRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $purchaseOrderID = null;

    private ?string $purchaseOrderNumber = null;

    private ?string $status = null;

    private ?string $reference = null;

    private ?Contact $contact = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    private ?string $date = null;

    private ?string $deliveryDate = null;

    private ?string $lineAmountTypes = null;

    private ?string $brandingThemeID = null;

    private ?string $currencyCode = null;

    private int|float|null $currencyRate = null;

    private ?bool $sentToContact = null;

    private ?string $deliveryAddress = null;

    private ?string $attentionTo = null;

    private ?string $telephone = null;

    private ?string $deliveryInstructions = null;

    private ?string $expectedArrivalDate = null;

    private int|float|null $subTotal = null;

    private int|float|null $totalTax = null;

    private int|float|null $total = null;

    private int|float|null $totalDiscount = null;

    private ?bool $hasAttachments = null;

    private ?string $updatedDateUTC = null;

    private ?string $statusAttributeString = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    /**
     * @var list<ValidationError>
     */
    private array $warnings = [];

    /**
     * @var list<AttachmentDetail>
     */
    private array $attachments = [];

    public function getPurchaseOrderID(): ?string
    {
        return $this->purchaseOrderID;
    }

    public function setPurchaseOrderID(?string $purchaseOrderID): self
    {
        $this->purchaseOrderID = $purchaseOrderID;

        return $this;
    }

    public function getPurchaseOrderNumber(): ?string
    {
        return $this->purchaseOrderNumber;
    }

    public function setPurchaseOrderNumber(?string $purchaseOrderNumber): self
    {
        $this->purchaseOrderNumber = $purchaseOrderNumber;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return list<LineItem>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    /**
     * @param list<LineItem> $lineItems
     */
    public function setLineItems(array $lineItems): self
    {
        $this->lineItems = $lineItems;

        return $this;
    }

    public function addLineItem(LineItem $lineItem): self
    {
        $this->lineItems[] = $lineItem;

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

    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?string $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getLineAmountTypes(): ?string
    {
        return $this->lineAmountTypes;
    }

    public function setLineAmountTypes(?string $lineAmountTypes): self
    {
        $this->lineAmountTypes = $lineAmountTypes;

        return $this;
    }

    public function getBrandingThemeID(): ?string
    {
        return $this->brandingThemeID;
    }

    public function setBrandingThemeID(?string $brandingThemeID): self
    {
        $this->brandingThemeID = $brandingThemeID;

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

    public function getCurrencyRate(): int|float|null
    {
        return $this->currencyRate;
    }

    public function setCurrencyRate(int|float|null $currencyRate): self
    {
        $this->currencyRate = $currencyRate;

        return $this;
    }

    public function getSentToContact(): ?bool
    {
        return $this->sentToContact;
    }

    public function setSentToContact(?bool $sentToContact): self
    {
        $this->sentToContact = $sentToContact;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?string $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getAttentionTo(): ?string
    {
        return $this->attentionTo;
    }

    public function setAttentionTo(?string $attentionTo): self
    {
        $this->attentionTo = $attentionTo;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDeliveryInstructions(): ?string
    {
        return $this->deliveryInstructions;
    }

    public function setDeliveryInstructions(?string $deliveryInstructions): self
    {
        $this->deliveryInstructions = $deliveryInstructions;

        return $this;
    }

    public function getExpectedArrivalDate(): ?string
    {
        return $this->expectedArrivalDate;
    }

    public function setExpectedArrivalDate(?string $expectedArrivalDate): self
    {
        $this->expectedArrivalDate = $expectedArrivalDate;

        return $this;
    }

    public function getSubTotal(): int|float|null
    {
        return $this->subTotal;
    }

    public function setSubTotal(int|float|null $subTotal): self
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    public function getTotalTax(): int|float|null
    {
        return $this->totalTax;
    }

    public function setTotalTax(int|float|null $totalTax): self
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotalDiscount(): int|float|null
    {
        return $this->totalDiscount;
    }

    public function setTotalDiscount(int|float|null $totalDiscount): self
    {
        $this->totalDiscount = $totalDiscount;

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

    public function getStatusAttributeString(): ?string
    {
        return $this->statusAttributeString;
    }

    public function setStatusAttributeString(?string $statusAttributeString): self
    {
        $this->statusAttributeString = $statusAttributeString;

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
     * @return list<ValidationError>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function addWarning(ValidationError $warning): self
    {
        $this->warnings[] = $warning;

        return $this;
    }

    /**
     * @return list<AttachmentDetail>
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function addAttachment(AttachmentDetail $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'PurchaseOrderID' => Field::string(),
            'PurchaseOrderNumber' => Field::string(),
            'Status' => Field::string(),
            'Reference' => Field::string(),
            'Contact' => Field::object(Contact::class),
            'LineItems' => Field::many(LineItem::class),
            'Date' => Field::string(),
            'DeliveryDate' => Field::string(),
            'LineAmountTypes' => Field::string(),
            'BrandingThemeID' => Field::string(),
            'CurrencyCode' => Field::string(),
            'CurrencyRate' => Field::number(),
            'SentToContact' => Field::boolean(),
            'DeliveryAddress' => Field::string(),
            'AttentionTo' => Field::string(),
            'Telephone' => Field::string(),
            'DeliveryInstructions' => Field::string(),
            'ExpectedArrivalDate' => Field::string(),
            'SubTotal' => Field::number(),
            'TotalTax' => Field::number(),
            'Total' => Field::number(),
            'TotalDiscount' => Field::number(),
            'HasAttachments' => Field::boolean(),
            'UpdatedDateUTC' => Field::string(),
            'StatusAttributeString' => Field::string(),
            'ValidationErrors' => Field::many(ValidationError::class),
            'Warnings' => Field::many(ValidationError::class),
            'Attachments' => Field::many(AttachmentDetail::class),
        ];
    }

    protected function newDefinitionInstance(string $class): object
    {
        if ($class === Contact::class) {
            return new Contact($this->client);
        }

        return parent::newDefinitionInstance($class);
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'PurchaseOrderID' => $this->getPurchaseOrderID(),
            'PurchaseOrderNumber' => $this->getPurchaseOrderNumber(),
            'Status' => $this->getStatus(),
            'Reference' => $this->getReference(),
            'Contact' => $this->getContact()?->toRequest(),
            'LineItems' => array_map(
                static fn (LineItem $lineItem): array => $lineItem->toRequest(),
                $this->getLineItems()
            ),
            'Date' => $this->getDate(),
            'DeliveryDate' => $this->getDeliveryDate(),
            'LineAmountTypes' => $this->getLineAmountTypes(),
            'BrandingThemeID' => $this->getBrandingThemeID(),
            'CurrencyCode' => $this->getCurrencyCode(),
            'CurrencyRate' => $this->getCurrencyRate(),
            'SentToContact' => $this->getSentToContact(),
            'DeliveryAddress' => $this->getDeliveryAddress(),
            'AttentionTo' => $this->getAttentionTo(),
            'Telephone' => $this->getTelephone(),
            'DeliveryInstructions' => $this->getDeliveryInstructions(),
            'ExpectedArrivalDate' => $this->getExpectedArrivalDate(),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function reference(string $reference): self
    {
        return $this->setReference($reference);
    }

    public function contact(string $contactId): self
    {
        return $this->setContact(
            (new Contact())
                ->setContactID($contactId)
        );
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        return $this->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a purchase order without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->purchaseOrderID === null) {
            throw new RuntimeException('Cannot access purchase order attachments without a bound client context and purchase order id.');
        }

        return new Attachments($this->client, $this->purchaseOrderID);
    }

    public function history(): History
    {
        if ($this->client === null || $this->purchaseOrderID === null) {
            throw new RuntimeException('Cannot access purchase order history without a bound client context and purchase order id.');
        }

        return (new PurchaseOrders($this->client))->history($this->purchaseOrderID);
    }

    public function pdf(): string
    {
        if ($this->client === null || $this->purchaseOrderID === null) {
            throw new RuntimeException('Cannot access a purchase order PDF without a bound client context and purchase order id.');
        }

        return (new PurchaseOrders($this->client))->pdf($this->purchaseOrderID);
    }
}
