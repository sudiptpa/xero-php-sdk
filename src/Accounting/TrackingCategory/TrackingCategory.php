<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TrackingCategory;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class TrackingCategory
{
    /**
     * @param list<array<string, mixed>> $options
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $status,
        public array $options = [],
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
            $payload['TrackingCategoryID'] ?? null,
            $payload['Name'] ?? null,
            $payload['Status'] ?? null,
            $payload['Options'] ?? [],
            $payload,
            $client
        );
    }

    public function name(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self($this->id, $name, $this->status, $this->options, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a tracking category without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        return $payload->save();
    }
}
