<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Timesheet;

use Sujip\Xero\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TimesheetLine extends Model implements SerializesRequest
{
    private ?string $timesheetLineID = null;
    private ?string $date = null;
    private ?string $earningsRateID = null;
    private ?string $trackingItemID = null;
    private ?float $numberOfUnits = null;

    public function getTimesheetLineID(): ?string
    {
        return $this->timesheetLineID;
    }

    public function setTimesheetLineID(?string $timesheetLineID): self
    {
        $this->timesheetLineID = $timesheetLineID;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEarningsRateID(): ?string
    {
        return $this->earningsRateID;
    }

    public function setEarningsRateID(?string $earningsRateID): self
    {
        $this->earningsRateID = $earningsRateID;

        return $this;
    }

    public function getTrackingItemID(): ?string
    {
        return $this->trackingItemID;
    }

    public function setTrackingItemID(?string $trackingItemID): self
    {
        $this->trackingItemID = $trackingItemID;

        return $this;
    }

    public function getNumberOfUnits(): ?float
    {
        return $this->numberOfUnits;
    }

    public function setNumberOfUnits(?float $numberOfUnits): self
    {
        $this->numberOfUnits = $numberOfUnits;

        return $this;
    }

    /** @return array<string, Field> */
    protected static function getDefinitions(): array
    {
        return [
            'timesheetLineID' => Field::string()->using('setTimesheetLineID'),
            'date' => Field::string()->using('setDate'),
            'earningsRateID' => Field::string()->using('setEarningsRateID'),
            'trackingItemID' => Field::string()->using('setTrackingItemID'),
            'numberOfUnits' => Field::number()->using('setNumberOfUnits'),
        ];
    }

    /** @return array<string, mixed> */
    public function toRequest(): array
    {
        return array_filter([
            'timesheetLineID' => $this->timesheetLineID,
            'date' => $this->date,
            'earningsRateID' => $this->earningsRateID,
            'trackingItemID' => $this->trackingItemID,
            'numberOfUnits' => $this->numberOfUnits,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
