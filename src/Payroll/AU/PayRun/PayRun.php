<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

use RuntimeException;
use Sujip\Xero\Client;

final class PayRun
{
    /**
     */
    public function __construct(
        private ?Client $client = null,
        private ?string $payRunID = null,
        private ?string $payrollCalendarID = null,
        private ?string $payRunStatus = null,
        private ?string $paymentDate = null,
    ) {
    }

    public function getPayRunID(): ?string
    {
        return $this->payRunID;
    }

    public function setPayRunID(?string $payRunID): self
    {
        $this->payRunID = $payRunID;

        return $this;
    }

    public function getPayrollCalendarID(): ?string
    {
        return $this->payrollCalendarID;
    }

    public function setPayrollCalendarID(?string $payrollCalendarID): self
    {
        $this->payrollCalendarID = $payrollCalendarID;

        return $this;
    }

    public function getPayRunStatus(): ?string
    {
        return $this->payRunStatus;
    }

    public function setPayRunStatus(?string $payRunStatus): self
    {
        $this->payRunStatus = $payRunStatus;

        return $this;
    }

    public function getPaymentDate(): ?string
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?string $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * @return \Sujip\Xero\Support\ResourceCollection<Payslip>
     */
    public function payslips(): \Sujip\Xero\Support\ResourceCollection
    {
        if ($this->client === null || $this->payRunID === null) {
            throw new RuntimeException('Cannot load payslips without a bound client context and pay run id.');
        }

        return (new PayRuns($this->client))->payslips($this->payRunID)->get();
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a pay run without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->payRunID !== null) {
            $payload = $payload->id($this->payRunID);
        }

        if ($this->payrollCalendarID !== null) {
            $payload = $payload->payrollCalendar($this->payrollCalendarID);
        }

        return $payload->save();
    }
}
