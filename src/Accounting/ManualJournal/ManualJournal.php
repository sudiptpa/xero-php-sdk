<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;

final readonly class ManualJournal
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $status,
        public ?string $narration,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['ManualJournalID'] ?? null,
            $payload['Status'] ?? null,
            $payload['Narration'] ?? null,
            $payload,
            $client
        );
    }

    public function narration(string $narration): self
    {
        $payload = $this->raw;
        $payload['Narration'] = $narration;

        return new self($this->id, $this->status, $narration, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a manual journal without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->narration !== null) {
            $payload = $payload->narration($this->narration);
        }

        return $payload->save();
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access manual journal attachments without a bound client context and manual journal id.');
        }

        return (new ManualJournals($this->client))->attachments($this->id);
    }

    public function history(): History
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access manual journal history without a bound client context and manual journal id.');
        }

        return (new ManualJournals($this->client))->history($this->id);
    }
}
