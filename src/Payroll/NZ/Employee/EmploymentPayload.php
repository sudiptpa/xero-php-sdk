<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;

final class EmploymentPayload
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

    public function startDate(string $startDate): self
    {
        $clone = clone $this;
        $clone->payload['startDate'] = $startDate;

        return $clone;
    }

    public function payrollCalendar(string $payrollCalendarId): self
    {
        $clone = clone $this;
        $clone->payload['payrollCalendarID'] = $payrollCalendarId;

        return $clone;
    }

    public function engagementType(string $engagementType): self
    {
        $clone = clone $this;
        $clone->payload['engagementType'] = $engagementType;

        return $clone;
    }

    public function fixedTermEndDate(string $fixedTermEndDate): self
    {
        $clone = clone $this;
        $clone->payload['fixedTermEndDate'] = $fixedTermEndDate;

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
            ->post('/payroll.xro/2.0/Employees/' . $this->employeeId . '/Employment')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();
    }
}
