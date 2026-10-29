<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Timesheet;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    /** @var array<string, mixed> */
    private array $payload = [];

    private ?string $idempotencyKey = null;

    public function __construct(private readonly Client $client)
    {
    }

    public function payrollCalendar(string $payrollCalendarId): self
    {
        $clone = clone $this;
        $clone->payload['payrollCalendarID'] = $payrollCalendarId;

        return $clone;
    }

    public function employee(string $employeeId): self
    {
        $clone = clone $this;
        $clone->payload['employeeID'] = $employeeId;

        return $clone;
    }

    public function startDate(string $startDate): self
    {
        $clone = clone $this;
        $clone->payload['startDate'] = $startDate;

        return $clone;
    }

    public function endDate(string $endDate): self
    {
        $clone = clone $this;
        $clone->payload['endDate'] = $endDate;

        return $clone;
    }

    /** @param list<TimesheetLine> $lines */
    public function timesheetLines(array $lines): self
    {
        $clone = clone $this;
        $clone->payload['timesheetLines'] = array_map(
            static fn (TimesheetLine $line): array => $line->toRequest(),
            $lines
        );

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Timesheet
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/Timesheets')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();

        $timesheet = Json::extractFirstOrObject($payload, 'timesheets', 'timesheet');

        return $timesheet !== null
            ? (new Timesheets($this->client))->mapTimesheet($timesheet)
            : new Timesheet($this->client);
    }
}
