<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\AttachmentDetail;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class ManualJournal extends Model implements SerializesRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $manualJournalID = null;

    private ?string $status = null;

    private ?string $narration = null;

    /**
     * @var list<JournalLine>
     */
    private array $journalLines = [];

    private ?string $date = null;

    private ?string $lineAmountTypes = null;

    private ?string $url = null;

    private ?bool $showOnCashBasisReports = null;

    private ?bool $hasAttachments = null;

    private ?string $updatedDateUTC = null;

    private ?string $statusAttributeString = null;

    /**
     * @var list<ValidationError>
     */
    private array $warnings = [];

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    /**
     * @var list<AttachmentDetail>
     */
    private array $attachments = [];

    public function getManualJournalID(): ?string
    {
        return $this->manualJournalID;
    }

    public function setManualJournalID(?string $manualJournalID): self
    {
        $this->manualJournalID = $manualJournalID;

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

    public function getNarration(): ?string
    {
        return $this->narration;
    }

    public function setNarration(?string $narration): self
    {
        $this->narration = $narration;

        return $this;
    }

    /**
     * @return list<JournalLine>
     */
    public function getJournalLines(): array
    {
        return $this->journalLines;
    }

    /**
     * @param list<JournalLine> $journalLines
     */
    public function setJournalLines(array $journalLines): self
    {
        $this->journalLines = $journalLines;

        return $this;
    }

    public function addJournalLine(JournalLine $journalLine): self
    {
        $this->journalLines[] = $journalLine;

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

    public function getLineAmountTypes(): ?string
    {
        return $this->lineAmountTypes;
    }

    public function setLineAmountTypes(?string $lineAmountTypes): self
    {
        $this->lineAmountTypes = $lineAmountTypes;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getShowOnCashBasisReports(): ?bool
    {
        return $this->showOnCashBasisReports;
    }

    public function setShowOnCashBasisReports(?bool $showOnCashBasisReports): self
    {
        $this->showOnCashBasisReports = $showOnCashBasisReports;

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
            'ManualJournalID' => Field::string(),
            'Status' => Field::string(),
            'Narration' => Field::string(),
            'JournalLines' => Field::many(JournalLine::class),
            'Date' => Field::string(),
            'LineAmountTypes' => Field::string(),
            'Url' => Field::string(),
            'ShowOnCashBasisReports' => Field::boolean(),
            'HasAttachments' => Field::boolean(),
            'UpdatedDateUTC' => Field::string(),
            'StatusAttributeString' => Field::string(),
            'Warnings' => Field::many(ValidationError::class),
            'ValidationErrors' => Field::many(ValidationError::class),
            'Attachments' => Field::many(AttachmentDetail::class),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'ManualJournalID' => $this->getManualJournalID(),
            'Status' => $this->getStatus(),
            'Narration' => $this->getNarration(),
            'JournalLines' => array_map(
                static fn (JournalLine $journalLine): array => $journalLine->toRequest(),
                $this->getJournalLines()
            ),
            'Date' => $this->getDate(),
            'LineAmountTypes' => $this->getLineAmountTypes(),
            'Url' => $this->getUrl(),
            'ShowOnCashBasisReports' => $this->getShowOnCashBasisReports(),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function narration(string $narration): self
    {
        return $this->setNarration($narration);
    }

    public function line(int|float $lineAmount, string $accountCode, bool $isDebit = true): self
    {
        return $this->addJournalLine(
            (new JournalLine())
                ->setLineAmount($isDebit ? abs($lineAmount) : -abs($lineAmount))
                ->setAccountCode($accountCode)
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a manual journal without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->manualJournalID === null) {
            throw new RuntimeException('Cannot access manual journal attachments without a bound client context and manual journal id.');
        }

        return (new ManualJournals($this->client))->attachments($this->manualJournalID);
    }

    public function history(): History
    {
        if ($this->client === null || $this->manualJournalID === null) {
            throw new RuntimeException('Cannot access manual journal history without a bound client context and manual journal id.');
        }

        return (new ManualJournals($this->client))->history($this->manualJournalID);
    }
}
