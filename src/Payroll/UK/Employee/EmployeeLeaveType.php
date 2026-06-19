<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class EmployeeLeaveType extends Model
{
    public function __construct(
        private ?string $leaveTypeID = null,
        private ?string $scheduleOfAccrual = null,
        private ?float $hoursAccruedAnnually = null,
        private ?float $maximumToAccrue = null,
        private ?float $openingBalance = null,
        private ?float $rateAccruedHourly = null,
        private ?string $scheduleOfAccrualDate = null,
    ) {
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

    public function getScheduleOfAccrual(): ?string
    {
        return $this->scheduleOfAccrual;
    }

    public function setScheduleOfAccrual(?string $scheduleOfAccrual): self
    {
        $this->scheduleOfAccrual = $scheduleOfAccrual;

        return $this;
    }

    public function getHoursAccruedAnnually(): ?float
    {
        return $this->hoursAccruedAnnually;
    }

    public function setHoursAccruedAnnually(?float $hoursAccruedAnnually): self
    {
        $this->hoursAccruedAnnually = $hoursAccruedAnnually;

        return $this;
    }

    public function getMaximumToAccrue(): ?float
    {
        return $this->maximumToAccrue;
    }

    public function setMaximumToAccrue(?float $maximumToAccrue): self
    {
        $this->maximumToAccrue = $maximumToAccrue;

        return $this;
    }

    public function getOpeningBalance(): ?float
    {
        return $this->openingBalance;
    }

    public function setOpeningBalance(?float $openingBalance): self
    {
        $this->openingBalance = $openingBalance;

        return $this;
    }

    public function getRateAccruedHourly(): ?float
    {
        return $this->rateAccruedHourly;
    }

    public function setRateAccruedHourly(?float $rateAccruedHourly): self
    {
        $this->rateAccruedHourly = $rateAccruedHourly;

        return $this;
    }

    public function getScheduleOfAccrualDate(): ?string
    {
        return $this->scheduleOfAccrualDate;
    }

    public function setScheduleOfAccrualDate(?string $scheduleOfAccrualDate): self
    {
        $this->scheduleOfAccrualDate = $scheduleOfAccrualDate;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'leaveTypeID' => Field::string()->using('setLeaveTypeID'),
            'scheduleOfAccrual' => Field::string()->using('setScheduleOfAccrual'),
            'hoursAccruedAnnually' => Field::number()->using('setHoursAccruedAnnually'),
            'maximumToAccrue' => Field::number()->using('setMaximumToAccrue'),
            'openingBalance' => Field::number()->using('setOpeningBalance'),
            'rateAccruedHourly' => Field::number()->using('setRateAccruedHourly'),
            'scheduleOfAccrualDate' => Field::string()->using('setScheduleOfAccrualDate'),
        ];
    }
}
