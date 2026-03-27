<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Item;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;

final readonly class Item
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $code,
        public ?string $name,
        public ?string $description,
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
            $payload['ItemID'] ?? null,
            $payload['Code'] ?? null,
            $payload['Name'] ?? null,
            $payload['Description'] ?? null,
            $payload,
            $client
        );
    }

    public function code(string $code): self
    {
        $payload = $this->raw;
        $payload['Code'] = $code;

        return new self($this->id, $code, $this->name, $this->description, $payload, $this->client);
    }

    public function name(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self($this->id, $this->code, $name, $this->description, $payload, $this->client);
    }

    public function description(string $description): self
    {
        $payload = $this->raw;
        $payload['Description'] = $description;

        return new self($this->id, $this->code, $this->name, $description, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an item without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->code !== null) {
            $payload = $payload->code($this->code);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        if ($this->description !== null) {
            $payload = $payload->description($this->description);
        }

        return $payload->save();
    }

    public function history(): History
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access item history without a bound client context and item id.');
        }

        return (new Items($this->client))->history($this->id);
    }
}
