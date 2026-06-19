<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Journal;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Journal extends Model
{
    private ?string $journalID = null;

    private ?string $journalDate = null;

    private ?int $journalNumber = null;

    private ?string $createdDateUTC = null;

    private ?string $reference = null;

    private ?string $sourceType = null;

    private ?string $sourceID = null;

    /**
     * @var list<JournalLine>
     */
    private array $journalLines = [];

    public function getJournalID(): ?string
    {
        return $this->journalID;
    }

    public function setJournalID(?string $journalID): self
    {
        $this->journalID = $journalID;

        return $this;
    }

    public function getJournalDate(): ?string
    {
        return $this->journalDate;
    }

    public function setJournalDate(?string $journalDate): self
    {
        $this->journalDate = $journalDate;

        return $this;
    }

    public function getJournalNumber(): ?int
    {
        return $this->journalNumber;
    }

    public function setJournalNumber(?int $journalNumber): self
    {
        $this->journalNumber = $journalNumber;

        return $this;
    }

    public function getCreatedDateUTC(): ?string
    {
        return $this->createdDateUTC;
    }

    public function setCreatedDateUTC(?string $createdDateUTC): self
    {
        $this->createdDateUTC = $createdDateUTC;

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

    public function getSourceType(): ?string
    {
        return $this->sourceType;
    }

    public function setSourceType(?string $sourceType): self
    {
        $this->sourceType = $sourceType;

        return $this;
    }

    public function getSourceID(): ?string
    {
        return $this->sourceID;
    }

    public function setSourceID(?string $sourceID): self
    {
        $this->sourceID = $sourceID;

        return $this;
    }

    /**
     * @return list<JournalLine>
     */
    public function getJournalLines(): array
    {
        return $this->journalLines;
    }

    public function addJournalLine(JournalLine $journalLine): self
    {
        $this->journalLines[] = $journalLine;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'JournalID' => Field::string(),
            'JournalDate' => Field::string(),
            'JournalNumber' => Field::number(),
            'CreatedDateUTC' => Field::string(),
            'Reference' => Field::string(),
            'SourceType' => Field::string(),
            'SourceID' => Field::string(),
            'JournalLines' => Field::many(JournalLine::class),
        ];
    }
}
