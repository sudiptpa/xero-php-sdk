<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;

final class SalaryAndWagePayload
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

    public function paymentType(string $paymentType): self
    {
        $clone = clone $this;
        $clone->payload['paymentType'] = $paymentType;

        return $clone;
    }

    public function earningsRate(string $earningsRateId): self
    {
        $clone = clone $this;
        $clone->payload['earningsRateID'] = $earningsRateId;

        return $clone;
    }

    public function numberOfUnitsPerWeek(float $numberOfUnitsPerWeek): self
    {
        $clone = clone $this;
        $clone->payload['numberOfUnitsPerWeek'] = $numberOfUnitsPerWeek;

        return $clone;
    }

    public function numberOfUnitsPerDay(float $numberOfUnitsPerDay): self
    {
        $clone = clone $this;
        $clone->payload['numberOfUnitsPerDay'] = $numberOfUnitsPerDay;

        return $clone;
    }

    public function ratePerUnit(float $ratePerUnit): self
    {
        $clone = clone $this;
        $clone->payload['ratePerUnit'] = $ratePerUnit;

        return $clone;
    }

    public function daysPerWeek(float $daysPerWeek): self
    {
        $clone = clone $this;
        $clone->payload['daysPerWeek'] = $daysPerWeek;

        return $clone;
    }

    public function effectiveFrom(string $effectiveFrom): self
    {
        $clone = clone $this;
        $clone->payload['effectiveFrom'] = $effectiveFrom;

        return $clone;
    }

    public function annualSalary(float $annualSalary): self
    {
        $clone = clone $this;
        $clone->payload['annualSalary'] = $annualSalary;

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->payload['status'] = $status;

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
            ->post('/payroll.xro/2.0/Employees/' . $this->employeeId . '/SalaryAndWages')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();
    }
}
