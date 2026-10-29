<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Timesheet;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Timesheet extends Model
{
    private ?string $timesheetID = null;
    private ?string $payrollCalendarID = null;
    private ?string $employeeID = null;
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $status = null;
    private ?float $totalHours = null;
    private ?string $updatedDateUTC = null;

    /** @var list<TimesheetLine> */
    private array $timesheetLines = [];

    public function __construct(private ?Client $client = null)
    {
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

    public function getPayrollCalendarID(): ?string
    {
        return $this->payrollCalendarID;
    }

    public function setPayrollCalendarID(?string $payrollCalendarID): self
    {
        $this->payrollCalendarID = $payrollCalendarID;

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

    public function getTotalHours(): ?float
    {
        return $this->totalHours;
    }

    public function setTotalHours(?float $totalHours): self
    {
        $this->totalHours = $totalHours;

        return $this;
    }

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

        return $this;
    }

    /** @return list<TimesheetLine> */
    public function getTimesheetLines(): array
    {
        return $this->timesheetLines;
    }

    public function addTimesheetLine(TimesheetLine $line): self
    {
        $this->timesheetLines[] = $line;

        return $this;
    }

    /** @return array<string, Field> */
    protected static function getDefinitions(): array
    {
        return [
            'timesheetID' => Field::string()->using('setTimesheetID'),
            'payrollCalendarID' => Field::string()->using('setPayrollCalendarID'),
            'employeeID' => Field::string()->using('setEmployeeID'),
            'startDate' => Field::string()->using('setStartDate'),
            'endDate' => Field::string()->using('setEndDate'),
            'status' => Field::string()->using('setStatus'),
            'totalHours' => Field::number()->using('setTotalHours'),
            'updatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'timesheetLines' => Field::many(TimesheetLine::class),
        ];
    }

    public function approve(?string $idempotencyKey = null): self
    {
        return $this->resource()->approve($this->requireId(), $idempotencyKey);
    }

    public function revert(?string $idempotencyKey = null): self
    {
        return $this->resource()->revert($this->requireId(), $idempotencyKey);
    }

    public function delete(): bool
    {
        return $this->resource()->delete($this->requireId());
    }

    private function resource(): Timesheets
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot change a timesheet without a bound client context.');
        }

        return new Timesheets($this->client);
    }

    private function requireId(): string
    {
        if ($this->timesheetID === null) {
            throw new RuntimeException('Cannot change a timesheet without a timesheet id.');
        }

        return $this->timesheetID;
    }
}
