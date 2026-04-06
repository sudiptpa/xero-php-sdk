<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\LeaveApplication;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class LeaveApplication extends Model
{
    private ?string $leaveApplicationID = null;
    private ?string $employeeID = null;
    private ?string $leaveTypeID = null;
    private ?string $title = null;
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $status = null;

    public function __construct(
        private ?Client $client = null
    ) {}

    public function getLeaveApplicationID(): ?string { return $this->leaveApplicationID; }
    public function setLeaveApplicationID(?string $leaveApplicationID): self { $this->leaveApplicationID = $leaveApplicationID; return $this; }
    public function getEmployeeID(): ?string { return $this->employeeID; }
    public function setEmployeeID(?string $employeeID): self { $this->employeeID = $employeeID; return $this; }
    public function getLeaveTypeID(): ?string { return $this->leaveTypeID; }
    public function setLeaveTypeID(?string $leaveTypeID): self { $this->leaveTypeID = $leaveTypeID; return $this; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(?string $title): self { $this->title = $title; return $this; }
    public function getStartDate(): ?string { return $this->startDate; }
    public function setStartDate(?string $startDate): self { $this->startDate = $startDate; return $this; }
    public function getEndDate(): ?string { return $this->endDate; }
    public function setEndDate(?string $endDate): self { $this->endDate = $endDate; return $this; }
    public function getStatus(): ?string { return $this->status; }
    public function setStatus(?string $status): self { $this->status = $status; return $this; }
    public function status(string $status): self
    {
        $this->status = strtoupper($status);

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'LeaveApplicationID' => Field::string()->using('setLeaveApplicationID'),
            'EmployeeID' => Field::string()->using('setEmployeeID'),
            'LeaveTypeID' => Field::string()->using('setLeaveTypeID'),
            'Title' => Field::string()->using('setTitle'),
            'StartDate' => Field::string()->using('setStartDate'),
            'EndDate' => Field::string()->using('setEndDate'),
            'Status' => Field::string()->using('setStatus'),
        ];
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a leave application without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->leaveApplicationID !== null) {
            $payload = $payload->id($this->leaveApplicationID);
        }

        if ($this->employeeID !== null) {
            $payload = $payload->employee($this->employeeID);
        }

        if ($this->leaveTypeID !== null) {
            $payload = $payload->leaveType($this->leaveTypeID);
        }

        if ($this->title !== null) {
            $payload = $payload->title($this->title);
        }

        if ($this->startDate !== null) {
            $payload = $payload->startDate($this->startDate);
        }

        if ($this->endDate !== null) {
            $payload = $payload->endDate($this->endDate);
        }

        return $payload->save();
    }

    public function approve(): self
    {
        if ($this->client === null || $this->leaveApplicationID === null) {
            throw new RuntimeException('Cannot approve a leave application without a bound client context and leave application id.');
        }

        return (new LeaveApplications($this->client))->approve($this->leaveApplicationID);
    }

    public function reject(): self
    {
        if ($this->client === null || $this->leaveApplicationID === null) {
            throw new RuntimeException('Cannot reject a leave application without a bound client context and leave application id.');
        }

        return (new LeaveApplications($this->client))->reject($this->leaveApplicationID);
    }
}
