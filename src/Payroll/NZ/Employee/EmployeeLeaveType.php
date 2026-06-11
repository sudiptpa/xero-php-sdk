<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class EmployeeLeaveType extends Model
{
    public function __construct(
        private ?string $leaveTypeID = null,
        private ?string $scheduleOfAccrual = null,
        private ?float $unitsAccruedAnnually = null,
        private ?string $typeOfUnitsToAccrue = null,
        private ?float $maximumToAccrue = null,
        private ?float $openingBalance = null,
        private ?string $openingBalanceTypeOfUnits = null,
        private ?float $rateAccruedHourly = null,
        private ?float $percentageOfGrossEarnings = null,
        private ?bool $includeHolidayPayEveryPay = null,
        private ?bool $showAnnualLeaveInAdvance = null,
        private ?float $annualLeaveTotalAmountPaid = null,
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

    public function getUnitsAccruedAnnually(): ?float
    {
        return $this->unitsAccruedAnnually;
    }

    public function setUnitsAccruedAnnually(?float $unitsAccruedAnnually): self
    {
        $this->unitsAccruedAnnually = $unitsAccruedAnnually;

        return $this;
    }

    public function getTypeOfUnitsToAccrue(): ?string
    {
        return $this->typeOfUnitsToAccrue;
    }

    public function setTypeOfUnitsToAccrue(?string $typeOfUnitsToAccrue): self
    {
        $this->typeOfUnitsToAccrue = $typeOfUnitsToAccrue;

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

    public function getOpeningBalanceTypeOfUnits(): ?string
    {
        return $this->openingBalanceTypeOfUnits;
    }

    public function setOpeningBalanceTypeOfUnits(?string $openingBalanceTypeOfUnits): self
    {
        $this->openingBalanceTypeOfUnits = $openingBalanceTypeOfUnits;

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

    public function getPercentageOfGrossEarnings(): ?float
    {
        return $this->percentageOfGrossEarnings;
    }

    public function setPercentageOfGrossEarnings(?float $percentageOfGrossEarnings): self
    {
        $this->percentageOfGrossEarnings = $percentageOfGrossEarnings;

        return $this;
    }

    public function getIncludeHolidayPayEveryPay(): ?bool
    {
        return $this->includeHolidayPayEveryPay;
    }

    public function setIncludeHolidayPayEveryPay(?bool $includeHolidayPayEveryPay): self
    {
        $this->includeHolidayPayEveryPay = $includeHolidayPayEveryPay;

        return $this;
    }

    public function getShowAnnualLeaveInAdvance(): ?bool
    {
        return $this->showAnnualLeaveInAdvance;
    }

    public function setShowAnnualLeaveInAdvance(?bool $showAnnualLeaveInAdvance): self
    {
        $this->showAnnualLeaveInAdvance = $showAnnualLeaveInAdvance;

        return $this;
    }

    public function getAnnualLeaveTotalAmountPaid(): ?float
    {
        return $this->annualLeaveTotalAmountPaid;
    }

    public function setAnnualLeaveTotalAmountPaid(?float $annualLeaveTotalAmountPaid): self
    {
        $this->annualLeaveTotalAmountPaid = $annualLeaveTotalAmountPaid;

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
            'unitsAccruedAnnually' => Field::number()->using('setUnitsAccruedAnnually'),
            'typeOfUnitsToAccrue' => Field::string()->using('setTypeOfUnitsToAccrue'),
            'maximumToAccrue' => Field::number()->using('setMaximumToAccrue'),
            'openingBalance' => Field::number()->using('setOpeningBalance'),
            'openingBalanceTypeOfUnits' => Field::string()->using('setOpeningBalanceTypeOfUnits'),
            'rateAccruedHourly' => Field::number()->using('setRateAccruedHourly'),
            'percentageOfGrossEarnings' => Field::number()->using('setPercentageOfGrossEarnings'),
            'includeHolidayPayEveryPay' => Field::boolean()->using('setIncludeHolidayPayEveryPay'),
            'showAnnualLeaveInAdvance' => Field::boolean()->using('setShowAnnualLeaveInAdvance'),
            'annualLeaveTotalAmountPaid' => Field::number()->using('setAnnualLeaveTotalAmountPaid'),
            'scheduleOfAccrualDate' => Field::string()->using('setScheduleOfAccrualDate'),
        ];
    }
}
