<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Journal;

final class Journal
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

}
