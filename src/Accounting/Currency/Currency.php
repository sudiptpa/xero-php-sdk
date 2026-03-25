<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Currency;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Currency
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $code,
        public ?string $description,
        public ?string $status,
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
            $payload['Code'] ?? null,
            $payload['Description'] ?? null,
            $payload['Status'] ?? null,
            $payload,
            $client
        );
    }

    public function description(string $description): self
    {
        $payload = $this->raw;
        $payload['Description'] = $description;

        return new self($this->code, $description, $this->status, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a currency without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->code !== null) {
            $payload = $payload->code($this->code);
        }

        if ($this->description !== null) {
            $payload = $payload->description($this->description);
        }

        return $payload->save();
    }
}
