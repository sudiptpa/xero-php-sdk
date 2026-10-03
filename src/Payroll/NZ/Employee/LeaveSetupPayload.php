<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;

final class LeaveSetupPayload
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

    public function includeHolidayPay(bool $includeHolidayPay): self
    {
        $clone = clone $this;
        $clone->payload['includeHolidayPay'] = $includeHolidayPay;

        return $clone;
    }

    public function holidayPayOpeningBalance(float $holidayPayOpeningBalance): self
    {
        $clone = clone $this;
        $clone->payload['holidayPayOpeningBalance'] = $holidayPayOpeningBalance;

        return $clone;
    }

    public function annualLeaveOpeningBalance(float $annualLeaveOpeningBalance): self
    {
        $clone = clone $this;
        $clone->payload['annualLeaveOpeningBalance'] = $annualLeaveOpeningBalance;

        return $clone;
    }

    public function negativeAnnualLeaveBalancePaidAmount(float $negativeAnnualLeaveBalancePaidAmount): self
    {
        $clone = clone $this;
        $clone->payload['negativeAnnualLeaveBalancePaidAmount'] = $negativeAnnualLeaveBalancePaidAmount;

        return $clone;
    }

    public function sickLeaveToAccrueAnnually(float $sickLeaveToAccrueAnnually): self
    {
        $clone = clone $this;
        $clone->payload['sickLeaveToAccrueAnnually'] = $sickLeaveToAccrueAnnually;

        return $clone;
    }

    public function sickLeaveMaximumToAccrue(float $sickLeaveMaximumToAccrue): self
    {
        $clone = clone $this;
        $clone->payload['sickLeaveMaximumToAccrue'] = $sickLeaveMaximumToAccrue;

        return $clone;
    }

    public function sickLeaveOpeningBalance(float $sickLeaveOpeningBalance): self
    {
        $clone = clone $this;
        $clone->payload['sickLeaveOpeningBalance'] = $sickLeaveOpeningBalance;

        return $clone;
    }

    public function sickLeaveScheduleOfAccrual(string $sickLeaveScheduleOfAccrual): self
    {
        $clone = clone $this;
        $clone->payload['sickLeaveScheduleOfAccrual'] = $sickLeaveScheduleOfAccrual;

        return $clone;
    }

    public function sickLeaveAnniversaryDate(string $sickLeaveAnniversaryDate): self
    {
        $clone = clone $this;
        $clone->payload['sickLeaveAnniversaryDate'] = $sickLeaveAnniversaryDate;

        return $clone;
    }

    public function annualLeaveAnniversaryDate(string $annualLeaveAnniversaryDate): self
    {
        $clone = clone $this;
        $clone->payload['annualLeaveAnniversaryDate'] = $annualLeaveAnniversaryDate;

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
            ->post('/payroll.xro/2.0/Employees/' . $this->employeeId . '/LeaveSetup')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();
    }
}
