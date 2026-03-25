<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

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
}
