<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

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
        $clone->payload['leaveTypeID'] = $leaveTypeId;

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

    public function description(string $description): self
    {
        $clone = clone $this;
        $clone->payload['description'] = $description;

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
            ->withJson($this->payload)
            ->send()
            ->json();
    }
}
