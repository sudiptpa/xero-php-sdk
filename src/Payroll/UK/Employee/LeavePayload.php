<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Client;

final class LeavePayload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $employeeId
    ) {
    }

    public function leaveType(string $leaveTypeId): self
    {
        $clone = clone $this;
        $clone->payload['LeaveTypeID'] = $leaveTypeId;

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

    public function title(string $title): self
    {
        $clone = clone $this;
        $clone->payload['Title'] = $title;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    /**
     * @return array<string, mixed>
     */
    public function save(): array
    {
        return $this->client
            ->post('/payroll.xro/2.0/Employees/' . $this->employeeId . '/Leave')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['EmployeeLeave' => $this->payload])
            ->send()
            ->json();
    }
}
