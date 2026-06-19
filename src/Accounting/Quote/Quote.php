<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Quote;

use RuntimeException;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\ValidationError;

final class Quote extends Model implements SerializesRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $quoteID = null;

    private ?string $quoteNumber = null;

    private ?string $status = null;

    private ?string $title = null;

    private ?Contact $contact = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    private ?string $reference = null;

    private ?string $terms = null;

    private ?string $date = null;

    private ?string $dateString = null;

    private ?string $expiryDate = null;

    private ?string $expiryDateString = null;

    private ?string $currencyCode = null;

    private int|float|null $currencyRate = null;

    private int|float|null $subTotal = null;

    private int|float|null $totalTax = null;

    private int|float|null $total = null;

    private int|float|null $totalDiscount = null;

    private ?string $summary = null;

    private ?string $brandingThemeID = null;

    private ?string $updatedDateUTC = null;

    private ?string $lineAmountTypes = null;

    private ?string $statusAttributeString = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function getQuoteID(): ?string
    {
        return $this->quoteID;
    }

    public function setQuoteID(?string $quoteID): self
    {
        $this->quoteID = $quoteID;

        return $this;
    }

    public function getQuoteNumber(): ?string
    {
        return $this->quoteNumber;
    }

    public function setQuoteNumber(?string $quoteNumber): self
    {
        $this->quoteNumber = $quoteNumber;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTerms(): ?string
    {
        return $this->terms;
    }

    public function setTerms(?string $terms): self
    {
        $this->terms = $terms;

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

    public function getDateString(): ?string
    {
        return $this->dateString;
    }

    public function setDateString(?string $dateString): self
    {
        $this->dateString = $dateString;

        return $this;
    }

    public function getExpiryDate(): ?string
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(?string $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getExpiryDateString(): ?string
    {
        return $this->expiryDateString;
    }

    public function setExpiryDateString(?string $expiryDateString): self
    {
        $this->expiryDateString = $expiryDateString;

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

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

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

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'QuoteID' => Field::string(),
            'QuoteNumber' => Field::string(),
            'Reference' => Field::string(),
            'Terms' => Field::string(),
            'Contact' => Field::object(Contact::class),
            'LineItems' => Field::many(LineItem::class),
            'Date' => Field::string(),
            'DateString' => Field::string(),
            'ExpiryDate' => Field::string(),
            'ExpiryDateString' => Field::string(),
            'Status' => Field::string(),
            'CurrencyCode' => Field::string(),
            'CurrencyRate' => Field::number(),
            'SubTotal' => Field::number(),
            'TotalTax' => Field::number(),
            'Total' => Field::number(),
            'TotalDiscount' => Field::number(),
            'Title' => Field::string(),
            'Summary' => Field::string(),
            'BrandingThemeID' => Field::string(),
            'UpdatedDateUTC' => Field::string(),
            'LineAmountTypes' => Field::string(),
            'StatusAttributeString' => Field::string(),
            'ValidationErrors' => Field::many(ValidationError::class),
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
            'QuoteID' => $this->getQuoteID(),
            'QuoteNumber' => $this->getQuoteNumber(),
            'Reference' => $this->getReference(),
            'Terms' => $this->getTerms(),
            'Status' => $this->getStatus(),
            'Title' => $this->getTitle(),
            'Summary' => $this->getSummary(),
            'Contact' => $this->getContact()?->toRequest(),
            'LineItems' => array_map(
                static fn (LineItem $lineItem): array => $lineItem->toRequest(),
                $this->getLineItems()
            ),
            'Date' => $this->getDate(),
            'DateString' => $this->getDateString(),
            'ExpiryDate' => $this->getExpiryDate(),
            'ExpiryDateString' => $this->getExpiryDateString(),
            'CurrencyCode' => $this->getCurrencyCode(),
            'CurrencyRate' => $this->getCurrencyRate(),
            'BrandingThemeID' => $this->getBrandingThemeID(),
            'LineAmountTypes' => $this->getLineAmountTypes(),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function title(string $title): self
    {
        return $this->setTitle($title);
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
            throw new RuntimeException('Cannot save a quote without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function pdf(): string
    {
        if ($this->client === null || $this->quoteID === null) {
            throw new RuntimeException('Cannot access quote PDF without a bound client context and quote id.');
        }

        return (new Quotes($this->client))->pdf($this->quoteID);
    }
}
