<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Timesheet;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Timesheet
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $employeeId,
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
            $payload['TimesheetID'] ?? null,
            $payload['EmployeeID'] ?? null,
            $payload['StartDate'] ?? null,
            $payload['EndDate'] ?? null,
            $payload['Status'] ?? null,
            $payload,
            $client
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a timesheet without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->employeeId !== null) {
            $payload = $payload->employee($this->employeeId);
        }

        if ($this->startDate !== null) {
            $payload = $payload->startDate($this->startDate);
        }

        if ($this->endDate !== null) {
            $payload = $payload->endDate($this->endDate);
        }

        if ($this->status !== null) {
            $payload = $payload->status($this->status);
        }

        return $payload->save();
    }

    public function approve(): self
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot approve a timesheet without a bound client context and timesheet id.');
        }

        return (new Timesheets($this->client))->approve($this->id);
    }

    public function revert(): self
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot revert a timesheet without a bound client context and timesheet id.');
        }

        return (new Timesheets($this->client))->revert($this->id);
    }

    public function delete(): bool
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot delete a timesheet without a bound client context and timesheet id.');
        }

        return (new Timesheets($this->client))->delete($this->id);
    }
}
