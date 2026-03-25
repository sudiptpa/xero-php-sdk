<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Contact
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $emailAddress,
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
            $payload['ContactID'] ?? null,
            $payload['Name'] ?? null,
            $payload['EmailAddress'] ?? null,
            $payload,
            $client
        );
    }

    public function name(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self($this->id, $name, $this->emailAddress, $payload, $this->client);
    }

    public function email(string $emailAddress): self
    {
        $payload = $this->raw;
        $payload['EmailAddress'] = $emailAddress;

        return new self($this->id, $this->name, $emailAddress, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a contact without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        if ($this->emailAddress !== null) {
            $payload = $payload->email($this->emailAddress);
        }

        return $payload->save();
    }
}
