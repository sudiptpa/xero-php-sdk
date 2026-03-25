<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Quote;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Quote
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $quoteNumber,
        public ?string $status,
        public ?string $title,
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
            $payload['QuoteID'] ?? null,
            $payload['QuoteNumber'] ?? null,
            $payload['Status'] ?? null,
            $payload['Title'] ?? null,
            $payload,
            $client
        );
    }

    public function title(string $title): self
    {
        $payload = $this->raw;
        $payload['Title'] = $title;

        return new self($this->id, $this->quoteNumber, $this->status, $title, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a quote without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->title !== null) {
            $payload = $payload->title($this->title);
        }

        return $payload->save();
    }

    public function pdf(): string
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access quote PDF without a bound client context and quote id.');
        }

        return (new Quotes($this->client))->pdf($this->id);
    }
}
