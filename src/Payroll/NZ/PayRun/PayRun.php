<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PayRun extends Model
{
    /**
     */
    public function __construct(
        private ?string $payRunID = null,
        private ?string $payrollCalendarID = null,
        private ?string $payRunStatus = null,
        private ?string $paymentDate = null,
    ) {
    }

    public function getPayRunID(): ?string
    {
        return $this->payRunID;
    }

    public function setPayRunID(?string $payRunID): self
    {
        $this->payRunID = $payRunID;

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

    public function getPayRunStatus(): ?string
    {
        return $this->payRunStatus;
    }

    public function setPayRunStatus(?string $payRunStatus): self
    {
        $this->payRunStatus = $payRunStatus;

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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'PayRunID' => Field::string()->using('setPayRunID'),
            'PayrollCalendarID' => Field::string()->using('setPayrollCalendarID'),
            'PayRunStatus' => Field::string()->using('setPayRunStatus'),
            'Status' => Field::string()->using('setPayRunStatus'),
            'PaymentDate' => Field::string()->using('setPaymentDate'),
        ];
    }

}
