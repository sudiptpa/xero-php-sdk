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
    private ?string $wages = null;
    private ?string $deductions = null;
    private ?string $tax = null;
    private ?string $super = null;
    private ?string $reimbursements = null;
    private ?string $netPay = null;
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

    public function getWages(): ?string
    {
        return $this->wages;
    }

    public function setWages(?string $wages): self
    {
        $this->wages = $wages;

        return $this;
    }

    public function getDeductions(): ?string
    {
        return $this->deductions;
    }

    public function setDeductions(?string $deductions): self
    {
        $this->deductions = $deductions;

        return $this;
    }

    public function getTax(): ?string
    {
        return $this->tax;
    }

    public function setTax(?string $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getSuper(): ?string
    {
        return $this->super;
    }

    public function setSuper(?string $super): self
    {
        $this->super = $super;

        return $this;
    }

    public function getReimbursements(): ?string
    {
        return $this->reimbursements;
    }

    public function setReimbursements(?string $reimbursements): self
    {
        $this->reimbursements = $reimbursements;

        return $this;
    }

    public function getNetPay(): ?string
    {
        return $this->netPay;
    }

    public function setNetPay(?string $netPay): self
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
            'Wages' => Field::string()->using('setWages'),
            'Deductions' => Field::string()->using('setDeductions'),
            'Tax' => Field::string()->using('setTax'),
            'Super' => Field::string()->using('setSuper'),
            'Reimbursements' => Field::string()->using('setReimbursements'),
            'NetPay' => Field::string()->using('setNetPay'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
        ];
    }
}
