<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRunCalendar;

final class PayRunCalendar
{
    /**
     */
    public function __construct(
        private ?string $payrollCalendarID = null,
        private ?string $name = null,
        private ?string $calendarType = null,
        private ?string $periodStartDate = null,
    ) {
    }

    public function getPayrollCalendarID(): ?string { return $this->payrollCalendarID; }
    public function setPayrollCalendarID(?string $payrollCalendarID): self { $this->payrollCalendarID = $payrollCalendarID; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): self { $this->name = $name; return $this; }
    public function getCalendarType(): ?string { return $this->calendarType; }
    public function setCalendarType(?string $calendarType): self { $this->calendarType = $calendarType; return $this; }
    public function getPeriodStartDate(): ?string { return $this->periodStartDate; }
    public function setPeriodStartDate(?string $periodStartDate): self { $this->periodStartDate = $periodStartDate; return $this; }
    /**
     * @return array<string, mixed>
     */
    /**
     * @param array<string, mixed> $raw
     */
}
