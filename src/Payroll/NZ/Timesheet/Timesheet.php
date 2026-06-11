<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Timesheet;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Timesheet extends Model
{
    private ?string $timesheetID = null;
    private ?string $employeeID = null;
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $status = null;

    public function __construct(
        private ?Client $client = null
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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'TimesheetID' => Field::string()->using('setTimesheetID'),
            'EmployeeID' => Field::string()->using('setEmployeeID'),
            'StartDate' => Field::string()->using('setStartDate'),
            'EndDate' => Field::string()->using('setEndDate'),
            'Status' => Field::string()->using('setStatus'),
        ];
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

    public function approve(): self
    {
        if ($this->client === null || $this->timesheetID === null) {
            throw new RuntimeException('Cannot approve a timesheet without a bound client context and timesheet id.');
        }

        return (new Timesheets($this->client))->approve($this->timesheetID);
    }

    public function revert(): self
    {
        if ($this->client === null || $this->timesheetID === null) {
            throw new RuntimeException('Cannot revert a timesheet without a bound client context and timesheet id.');
        }

        return (new Timesheets($this->client))->revert($this->timesheetID);
    }

    public function delete(): bool
    {
        if ($this->client === null || $this->timesheetID === null) {
            throw new RuntimeException('Cannot delete a timesheet without a bound client context and timesheet id.');
        }

        return (new Timesheets($this->client))->delete($this->timesheetID);
    }
}
