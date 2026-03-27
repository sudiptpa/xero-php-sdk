<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\LeaveApplication;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class LeaveApplication
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $employeeId,
        public ?string $leaveTypeId,
        public ?string $title,
        public ?string $startDate,
        public ?string $endDate,
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
            $payload['LeaveApplicationID'] ?? null,
            $payload['EmployeeID'] ?? null,
            $payload['LeaveTypeID'] ?? null,
            $payload['Title'] ?? null,
            $payload['StartDate'] ?? null,
            $payload['EndDate'] ?? null,
            $payload['Status'] ?? null,
            $payload,
            $client
        );
    }

    public function status(string $status): self
    {
        $payload = $this->raw;
        $payload['Status'] = strtoupper($status);

        return new self(
            $this->id,
            $this->employeeId,
            $this->leaveTypeId,
            $this->title,
            $this->startDate,
            $this->endDate,
            strtoupper($status),
            $payload,
            $this->client
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a leave application without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->employeeId !== null) {
            $payload = $payload->employee($this->employeeId);
        }

        if ($this->leaveTypeId !== null) {
            $payload = $payload->leaveType($this->leaveTypeId);
        }

        if ($this->title !== null) {
            $payload = $payload->title($this->title);
        }

        if ($this->startDate !== null) {
            $payload = $payload->startDate($this->startDate);
        }

        if ($this->endDate !== null) {
            $payload = $payload->endDate($this->endDate);
        }

        return $payload->save();
    }

    public function approve(): self
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot approve a leave application without a bound client context and leave application id.');
        }

        return (new LeaveApplications($this->client))->approve($this->id);
    }

    public function reject(): self
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot reject a leave application without a bound client context and leave application id.');
        }

        return (new LeaveApplications($this->client))->reject($this->id);
    }
}
