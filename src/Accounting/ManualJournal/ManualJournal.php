<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\BuildsFromPayload;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class ManualJournal implements BuildsFromPayload, SerializesForRequest
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

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?Client $client = null): static
    {
        $manualJournal = (new self($client))
            ->setManualJournalID($payload['ManualJournalID'] ?? null)
            ->setStatus($payload['Status'] ?? null)
            ->setNarration($payload['Narration'] ?? null);

        foreach ($payload['JournalLines'] ?? [] as $journalLine) {
            if (is_array($journalLine)) {
                $manualJournal->addJournalLine(JournalLine::fromPayload($journalLine));
            }
        }

        return $manualJournal;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return self::fromPayload($payload, $client);
    }

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
                ->setLineAmount($lineAmount)
                ->setAccountCode($accountCode)
                ->setIsDebit($isDebit)
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
