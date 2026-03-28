<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Timesheet;

use RuntimeException;
use Sujip\Xero\Client;

final class Timesheet
{
    /**
     */
    public function __construct(
        private ?Client $client = null,
        private ?string $timesheetID = null,
        private ?string $employeeID = null,
        private ?string $startDate = null,
        private ?string $endDate = null,
        private ?string $status = null,
    ) {
    }

    public function getTimesheetID(): ?string
    {
        return $this->timesheetID;
    }

    public function setTimesheetID(?string $timesheetID): self
    {
        $this->timesheetID = $timesheetID;

        return $this;
    }

    public function getEmployeeID(): ?string
    {
        return $this->employeeID;
    }

    public function setEmployeeID(?string $employeeID): self
    {
        $this->employeeID = $employeeID;

        return $this;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a timesheet without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->timesheetID !== null) {
            $payload = $payload->id($this->timesheetID);
        }

        if ($this->employeeID !== null) {
            $payload = $payload->employee($this->employeeID);
        }

        if ($this->startDate !== null) {
            $payload = $payload->startDate($this->startDate);
        }

        if ($this->endDate !== null) {
            $payload = $payload->endDate($this->endDate);
        }

        if ($this->status !== null) {
            $payload = $payload->status($this->status);
        }

        return $payload->save();
    }
}
