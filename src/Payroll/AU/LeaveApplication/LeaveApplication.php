<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\LeaveApplication;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class LeaveApplication extends Model
{
    private ?string $leaveApplicationID = null;
    private ?string $employeeID = null;
    private ?string $leaveTypeID = null;
    private ?string $title = null;
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $description = null;
    private ?string $payOutType = null;

    /**
     * @var list<array<string, mixed>>
     */
    private array $leavePeriods = [];
    private ?string $status = null;
    private ?string $updatedDateUTC = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getLeaveApplicationID(): ?string
    {
        return $this->leaveApplicationID;
    }
    public function setLeaveApplicationID(?string $leaveApplicationID): self
    {
        $this->leaveApplicationID = $leaveApplicationID;
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
    public function getLeaveTypeID(): ?string
    {
        return $this->leaveTypeID;
    }
    public function setLeaveTypeID(?string $leaveTypeID): self
    {
        $this->leaveTypeID = $leaveTypeID;
        return $this;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle(?string $title): self
    {
        $this->title = $title;
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
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function getPayOutType(): ?string
    {
        return $this->payOutType;
    }
    public function setPayOutType(?string $payOutType): self
    {
        $this->payOutType = $payOutType;
        return $this;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getLeavePeriods(): array
    {
        return $this->leavePeriods;
    }

    /**
     * @param list<array<string, mixed>> $leavePeriods
     */
    public function setLeavePeriods(array $leavePeriods): self
    {
        $this->leavePeriods = $leavePeriods;
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
    public function status(string $status): self
    {
        $this->status = strtoupper($status);

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

    /**
     * @return list<ValidationError>
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function addValidationError(ValidationError $validationError): self
    {
        $this->validationErrors[] = $validationError;
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
            'Description' => Field::string()->using('setDescription'),
            'PayOutType' => Field::string()->using('setPayOutType'),
            'LeavePeriods' => Field::array()->using('setLeavePeriods'),
            'Status' => Field::string()->using('setStatus'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'ValidationErrors' => Field::many(ValidationError::class),
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
