<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Account;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Account
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $code,
        public ?string $name,
        public ?string $type,
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
            $payload['AccountID'] ?? null,
            $payload['Code'] ?? null,
            $payload['Name'] ?? null,
            $payload['Type'] ?? null,
            $payload['Status'] ?? null,
            $payload,
            $client
        );
    }

    public function code(string $code): self
    {
        $payload = $this->raw;
        $payload['Code'] = $code;

        return new self($this->id, $code, $this->name, $this->type, $this->status, $payload, $this->client);
    }

    public function name(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self($this->id, $this->code, $name, $this->type, $this->status, $payload, $this->client);
    }

    public function type(string $type): self
    {
        $type = strtoupper($type);
        $payload = $this->raw;
        $payload['Type'] = $type;

        return new self($this->id, $this->code, $this->name, $type, $this->status, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an account without a bound client context.');
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

        if ($this->type !== null) {
            $payload = $payload->type($this->type);
        }

        if (isset($this->raw['Description']) && is_string($this->raw['Description'])) {
            $payload = $payload->description($this->raw['Description']);
        }

        return $payload->save();
    }
}
