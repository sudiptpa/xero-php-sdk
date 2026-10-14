<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Client;

final class LeaveTypePayload
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

    public function scheduleOfAccrual(string $schedule): self
    {
        $clone = clone $this;
        $clone->payload['scheduleOfAccrual'] = $schedule;

        return $clone;
    }

    public function openingBalance(float $openingBalance): self
    {
        $clone = clone $this;
        $clone->payload['openingBalance'] = $openingBalance;

        return $clone;
    }

    public function hoursAccruedAnnually(float $hoursAccruedAnnually): self
    {
        $clone = clone $this;
        $clone->payload['hoursAccruedAnnually'] = $hoursAccruedAnnually;

        return $clone;
    }

    public function maximumToAccrue(float $maximumToAccrue): self
    {
        $clone = clone $this;
        $clone->payload['maximumToAccrue'] = $maximumToAccrue;

        return $clone;
    }

    public function rateAccruedHourly(float $rateAccruedHourly): self
    {
        $clone = clone $this;
        $clone->payload['rateAccruedHourly'] = $rateAccruedHourly;

        return $clone;
    }

    public function scheduleOfAccrualDate(string $scheduleOfAccrualDate): self
    {
        $clone = clone $this;
        $clone->payload['scheduleOfAccrualDate'] = $scheduleOfAccrualDate;

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
            ->post('/payroll.xro/2.0/Employees/' . $this->employeeId . '/LeaveTypes')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();
    }
}
