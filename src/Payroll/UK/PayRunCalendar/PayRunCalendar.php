<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRunCalendar;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PayRunCalendar extends Model
{
    public function __construct(
        private ?string $payrollCalendarID = null,
        private ?string $name = null,
        private ?string $calendarType = null,
        private ?string $periodStartDate = null,
        private ?string $periodEndDate = null,
        private ?string $paymentDate = null,
        private ?string $updatedDateUTC = null,
    ) {
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCalendarType(): ?string
    {
        return $this->calendarType;
    }

    public function setCalendarType(?string $calendarType): self
    {
        $this->calendarType = $calendarType;

        return $this;
    }

    public function getPeriodStartDate(): ?string
    {
        return $this->periodStartDate;
    }

    public function setPeriodStartDate(?string $periodStartDate): self
    {
        $this->periodStartDate = $periodStartDate;

        return $this;
    }

    public function getPeriodEndDate(): ?string
    {
        return $this->periodEndDate;
    }

    public function setPeriodEndDate(?string $periodEndDate): self
    {
        $this->periodEndDate = $periodEndDate;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'payrollCalendarID' => Field::string()->using('setPayrollCalendarID'),
            'name' => Field::string()->using('setName'),
            'calendarType' => Field::string()->using('setCalendarType'),
            'periodStartDate' => Field::string()->using('setPeriodStartDate'),
            'periodEndDate' => Field::string()->using('setPeriodEndDate'),
            'paymentDate' => Field::string()->using('setPaymentDate'),
            'updatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
        ];
    }
}
