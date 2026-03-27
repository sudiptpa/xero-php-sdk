<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Timesheet;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $timesheetId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $timesheetId): self
    {
        $clone = clone $this;
        $clone->timesheetId = $timesheetId;

        return $clone;
    }

    public function employee(string $employeeId): self
    {
        $clone = clone $this;
        $clone->payload['EmployeeID'] = $employeeId;

        return $clone;
    }

    public function startDate(string $startDate): self
    {
        $clone = clone $this;
        $clone->payload['StartDate'] = $startDate;

        return $clone;
    }

    public function endDate(string $endDate): self
    {
        $clone = clone $this;
        $clone->payload['EndDate'] = $endDate;

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->payload['Status'] = strtoupper($status);

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
        $request = $this->timesheetId === null
            ? $this->client->post('/payroll.xro/1.0/Timesheets')
            : $this->client->post('/payroll.xro/1.0/Timesheets/' . $this->timesheetId);

        if ($this->timesheetId !== null) {
            $this->payload['TimesheetID'] = $this->timesheetId;
        }

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['Timesheets' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $timesheet = $payload['Timesheets'][0] ?? $payload['Timesheet'] ?? [];

        return Timesheet::fromArray(is_array($timesheet) ? $timesheet : [], $this->client);
    }
}
