<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayrollCalendar;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class PayrollCalendar extends Model
{
    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function __construct(
        private ?string $payrollCalendarID = null,
        private ?string $name = null,
        private ?string $calendarType = null,
        private ?string $startDate = null,
        private ?string $paymentDate = null,
        private ?string $updatedDateUtc = null,
        private ?string $referenceDate = null,
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
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }
    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;
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

    public function getUpdatedDateUtc(): ?string
    {
        return $this->updatedDateUtc;
    }
    public function setUpdatedDateUtc(?string $updatedDateUtc): self
    {
        $this->updatedDateUtc = $updatedDateUtc;
        return $this;
    }

    public function getReferenceDate(): ?string
    {
        return $this->referenceDate;
    }
    public function setReferenceDate(?string $referenceDate): self
    {
        $this->referenceDate = $referenceDate;
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
            'PayrollCalendarID' => Field::string()->using('setPayrollCalendarID'),
            'Name' => Field::string()->using('setName'),
            'CalendarType' => Field::string()->using('setCalendarType'),
            'StartDate' => Field::string()->using('setStartDate'),
            'PaymentDate' => Field::string()->using('setPaymentDate'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUtc'),
            'ReferenceDate' => Field::string()->using('setReferenceDate'),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }
}
