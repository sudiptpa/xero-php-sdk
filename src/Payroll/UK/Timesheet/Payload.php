<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Timesheet;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

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
            ? $this->client->post('/payroll.xro/2.0/Timesheets')
            : $this->client->post('/payroll.xro/2.0/Timesheets/' . $this->timesheetId);

        if ($this->timesheetId !== null) {
            $this->payload['TimesheetID'] = $this->timesheetId;
        }

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['Timesheet' => $this->payload])
            ->send();

        $payload = $response->json();
        $timesheet = Json::extractFirst($payload, 'Timesheets') ?? Json::extractObject($payload, 'Timesheet');

        if ($timesheet === []) {
            return new Timesheet($this->client);
        }

        return (new Timesheets($this->client))->mapTimesheet($timesheet);
    }
}
