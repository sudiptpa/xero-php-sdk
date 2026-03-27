<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Payroll\AU\LeaveApplication\Payload as LeaveApplicationPayload;

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
     * @return array<string, mixed>
     */
    public function leaveBalances(): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load leave balances without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leaveBalances($this->id);
    }

    public function createLeaveApplication(): LeaveApplicationPayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot create a leave application without a bound client context and employee id.');
        }

        return (new LeaveApplicationPayload($this->client))->employee($this->id);
    }
}
