<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Journal;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Journal extends Model
{
    private ?string $journalID = null;

    private ?int $journalNumber = null;

    private ?string $sourceType = null;

    private ?string $sourceID = null;

    public function getJournalID(): ?string
    {
        return $this->journalID;
    }

    public function setJournalID(?string $journalID): self
    {
        $this->journalID = $journalID;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'JournalID' => Field::string(),
            'JournalNumber' => Field::number(),
            'SourceType' => Field::string(),
            'SourceID' => Field::string(),
        ];
    }
}
