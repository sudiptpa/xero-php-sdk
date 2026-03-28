<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

final class Payslip
{
    /**
     */
    public function __construct(
        private ?string $payslipID = null,
        private ?string $employeeID = null,
        private ?string $paymentDate = null,
        private ?string $netPay = null,
    ) {
    }

    public function getPayslipID(): ?string { return $this->payslipID; }
    public function setPayslipID(?string $payslipID): self { $this->payslipID = $payslipID; return $this; }
    public function getEmployeeID(): ?string { return $this->employeeID; }
    public function setEmployeeID(?string $employeeID): self { $this->employeeID = $employeeID; return $this; }
    public function getPaymentDate(): ?string { return $this->paymentDate; }
    public function setPaymentDate(?string $paymentDate): self { $this->paymentDate = $paymentDate; return $this; }
    public function getNetPay(): ?string { return $this->netPay; }
    public function setNetPay(?string $netPay): self { $this->netPay = $netPay; return $this; }
    /**
     * @return array<string, mixed>
     */
    /**
     * @param array<string, mixed> $raw
     */
}
