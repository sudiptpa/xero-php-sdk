<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

final readonly class Employee
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $emailAddress,
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
            $payload['EmployeeID'] ?? null,
            $payload['FirstName'] ?? null,
            $payload['LastName'] ?? null,
            $payload['EmailAddress'] ?? null,
            $payload['Status'] ?? null,
            $payload,
            $client
        );
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

        if ($this->emailAddress !== null) {
            $payload = $payload->emailAddress($this->emailAddress);
        }

        return $payload->save();
    }

    /**
     * @return ResourceCollection<\Sujip\Xero\Payroll\NZ\LeaveType\LeaveType>
     */
    public function leaveTypes(): ResourceCollection
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load leave types without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leaveTypes($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function leavePeriods(string $startDate, string $endDate): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load leave periods without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leavePeriods($this->id, $startDate, $endDate);
    }
}
