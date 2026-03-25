<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Employee;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Employee
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $status,
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
            $payload['EmployeeID'] ?? null,
            $payload['FirstName'] ?? null,
            $payload['LastName'] ?? null,
            $payload['Status'] ?? null,
            $payload['EmailAddress'] ?? null,
            $payload,
            $client
        );
    }

    public function firstName(string $firstName): self
    {
        $payload = $this->raw;
        $payload['FirstName'] = $firstName;

        return new self($this->id, $firstName, $this->lastName, $this->status, $this->emailAddress, $payload, $this->client);
    }

    public function lastName(string $lastName): self
    {
        $payload = $this->raw;
        $payload['LastName'] = $lastName;

        return new self($this->id, $this->firstName, $lastName, $this->status, $this->emailAddress, $payload, $this->client);
    }

    public function email(string $emailAddress): self
    {
        $payload = $this->raw;
        $payload['EmailAddress'] = $emailAddress;

        return new self($this->id, $this->firstName, $this->lastName, $this->status, $emailAddress, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an employee without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->firstName !== null) {
            $payload = $payload->firstName($this->firstName);
        }

        if ($this->lastName !== null) {
            $payload = $payload->lastName($this->lastName);
        }

        if ($this->status !== null) {
            $payload = $payload->status($this->status);
        }

        if ($this->emailAddress !== null) {
            $payload = $payload->email($this->emailAddress);
        }

        return $payload->save();
    }
}
