<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PayslipSummary extends Model
{
    private ?string $payslipID = null;
    private ?string $employeeID = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $lastEdited = null;
    private ?float $wages = null;
    private ?float $deductions = null;
    private ?float $tax = null;
    private ?float $super = null;
    private ?float $reimbursements = null;
    private ?float $netPay = null;
    private ?string $updatedDateUTC = null;

    public function getPayslipID(): ?string
    {
        return $this->payslipID;
    }

    public function setPayslipID(?string $payslipID): self
    {
        $this->payslipID = $payslipID;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLastEdited(): ?string
    {
        return $this->lastEdited;
    }

    public function setLastEdited(?string $lastEdited): self
    {
        $this->lastEdited = $lastEdited;

        return $this;
    }

    public function getWages(): ?float
    {
        return $this->wages;
    }

    public function setWages(?float $wages): self
    {
        $this->wages = $wages;

        return $this;
    }

    public function getDeductions(): ?float
    {
        return $this->deductions;
    }

    public function setDeductions(?float $deductions): self
    {
        $this->deductions = $deductions;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(?float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getSuper(): ?float
    {
        return $this->super;
    }

    public function setSuper(?float $super): self
    {
        $this->super = $super;

        return $this;
    }

    public function getReimbursements(): ?float
    {
        return $this->reimbursements;
    }

    public function setReimbursements(?float $reimbursements): self
    {
        $this->reimbursements = $reimbursements;

        return $this;
    }

    public function getNetPay(): ?float
    {
        return $this->netPay;
    }

    public function setNetPay(?float $netPay): self
    {
        $this->netPay = $netPay;

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
            'PayslipID' => Field::string()->using('setPayslipID'),
            'EmployeeID' => Field::string()->using('setEmployeeID'),
            'FirstName' => Field::string()->using('setFirstName'),
            'LastName' => Field::string()->using('setLastName'),
            'LastEdited' => Field::string()->using('setLastEdited'),
            'Wages' => Field::number()->using('setWages'),
            'Deductions' => Field::number()->using('setDeductions'),
            'Tax' => Field::number()->using('setTax'),
            'Super' => Field::number()->using('setSuper'),
            'Reimbursements' => Field::number()->using('setReimbursements'),
            'NetPay' => Field::number()->using('setNetPay'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
        ];
    }
}
