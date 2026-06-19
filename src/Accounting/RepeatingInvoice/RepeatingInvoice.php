<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\RepeatingInvoice;

use RuntimeException;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Client;
use Sujip\Xero\Support\AttachmentDetail;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class RepeatingInvoice extends Model
{
    private ?string $repeatingInvoiceID = null;

    private ?string $id = null;

    private ?string $type = null;

    private ?Contact $contact = null;

    private ?Schedule $schedule = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    private ?string $lineAmountTypes = null;

    private ?string $status = null;

    private ?string $reference = null;

    private ?string $brandingThemeID = null;

    private ?string $currencyCode = null;

    private int|float|null $subTotal = null;

    private int|float|null $totalTax = null;

    private int|float|null $total = null;

    private ?bool $hasAttachments = null;

    /**
     * @var list<AttachmentDetail>
     */
    private array $attachments = [];

    private ?bool $approvedForSending = null;

    private ?bool $sendCopy = null;

    private ?bool $markAsSent = null;

    private ?bool $includePDF = null;

    public function __construct(
        private ?Client $client = null
    ) {
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

    public function getID(): ?string
    {
        return $this->id;
    }

    public function setID(?string $id): self
    {
        $this->id = $id;

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

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(?Schedule $schedule): self
    {
        $this->schedule = $schedule;

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

    public function getLineAmountTypes(): ?string
    {
        return $this->lineAmountTypes;
    }

    public function setLineAmountTypes(?string $lineAmountTypes): self
    {
        $this->lineAmountTypes = $lineAmountTypes;

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

    public function getHasAttachments(): ?bool
    {
        return $this->hasAttachments;
    }

    public function setHasAttachments(?bool $hasAttachments): self
    {
        $this->hasAttachments = $hasAttachments;

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

    public function getApprovedForSending(): ?bool
    {
        return $this->approvedForSending;
    }

    public function setApprovedForSending(?bool $approvedForSending): self
    {
        $this->approvedForSending = $approvedForSending;

        return $this;
    }

    public function getSendCopy(): ?bool
    {
        return $this->sendCopy;
    }

    public function setSendCopy(?bool $sendCopy): self
    {
        $this->sendCopy = $sendCopy;

        return $this;
    }

    public function getMarkAsSent(): ?bool
    {
        return $this->markAsSent;
    }

    public function setMarkAsSent(?bool $markAsSent): self
    {
        $this->markAsSent = $markAsSent;

        return $this;
    }

    public function getIncludePDF(): ?bool
    {
        return $this->includePDF;
    }

    public function setIncludePDF(?bool $includePDF): self
    {
        $this->includePDF = $includePDF;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'RepeatingInvoiceID' => Field::string(),
            'ID' => Field::string(),
            'Type' => Field::string(),
            'Contact' => Field::object(Contact::class),
            'Schedule' => Field::object(Schedule::class),
            'LineItems' => Field::many(LineItem::class),
            'LineAmountTypes' => Field::string(),
            'Status' => Field::string(),
            'Reference' => Field::string(),
            'BrandingThemeID' => Field::string(),
            'CurrencyCode' => Field::string(),
            'SubTotal' => Field::number(),
            'TotalTax' => Field::number(),
            'Total' => Field::number(),
            'HasAttachments' => Field::boolean(),
            'Attachments' => Field::many(AttachmentDetail::class),
            'ApprovedForSending' => Field::boolean(),
            'SendCopy' => Field::boolean(),
            'MarkAsSent' => Field::boolean(),
            'IncludePDF' => Field::boolean(),
        ];
    }

    public function reference(string $reference): self
    {
        return $this->setReference($reference);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a repeating invoice without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->repeatingInvoiceID !== null) {
            $payload = $payload->id($this->repeatingInvoiceID);
        }

        if ($this->type !== null) {
            $payload = $payload->type($this->type);
        }

        if ($this->reference !== null) {
            $payload = $payload->reference($this->reference);
        }

        return $payload->save();
    }
}
