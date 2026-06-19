<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Timesheet;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class Timesheet extends Model
{
    private ?string $timesheetID = null;
    private ?string $employeeID = null;
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $status = null;
    private ?float $hours = null;

    /**
     * @var list<array<string, mixed>>
     */
    private array $timesheetLines = [];
    private ?string $updatedDateUTC = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

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

    public function getHours(): ?float
    {
        return $this->hours;
    }

    public function setHours(?float $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getTimesheetLines(): array
    {
        return $this->timesheetLines;
    }

    /**
     * @param list<array<string, mixed>> $timesheetLines
     */
    public function setTimesheetLines(array $timesheetLines): self
    {
        $this->timesheetLines = $timesheetLines;

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
            'TimesheetID' => Field::string()->using('setTimesheetID'),
            'EmployeeID' => Field::string()->using('setEmployeeID'),
            'StartDate' => Field::string()->using('setStartDate'),
            'EndDate' => Field::string()->using('setEndDate'),
            'Status' => Field::string()->using('setStatus'),
            'Hours' => Field::number()->using('setHours'),
            'TimesheetLines' => Field::array()->using('setTimesheetLines'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'ValidationErrors' => Field::many(ValidationError::class),
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
}
