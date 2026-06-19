<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Payslip extends Model
{
    private ?string $payslipID = null;
    private ?string $employeeID = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?float $wages = null;
    private ?float $deductions = null;
    private ?float $tax = null;
    private ?float $super = null;
    private ?float $reimbursements = null;
    private ?float $netPay = null;
    private ?string $updatedDateUTC = null;

    /** @var list<array<string, mixed>> */
    private array $earningsLines = [];

    /** @var list<array<string, mixed>> */
    private array $leaveEarningsLines = [];

    /** @var list<array<string, mixed>> */
    private array $timesheetEarningsLines = [];

    /** @var list<array<string, mixed>> */
    private array $deductionLines = [];

    /** @var list<array<string, mixed>> */
    private array $leaveAccrualLines = [];

    /** @var list<array<string, mixed>> */
    private array $reimbursementLines = [];

    /** @var list<array<string, mixed>> */
    private array $superannuationLines = [];

    /** @var list<array<string, mixed>> */
    private array $taxLines = [];

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

    /** @return list<array<string, mixed>> */
    public function getEarningsLines(): array
    {
        return $this->earningsLines;
    }

    /** @param list<array<string, mixed>> $earningsLines */
    public function setEarningsLines(array $earningsLines): self
    {
        $this->earningsLines = $earningsLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getLeaveEarningsLines(): array
    {
        return $this->leaveEarningsLines;
    }

    /** @param list<array<string, mixed>> $leaveEarningsLines */
    public function setLeaveEarningsLines(array $leaveEarningsLines): self
    {
        $this->leaveEarningsLines = $leaveEarningsLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getTimesheetEarningsLines(): array
    {
        return $this->timesheetEarningsLines;
    }

    /** @param list<array<string, mixed>> $timesheetEarningsLines */
    public function setTimesheetEarningsLines(array $timesheetEarningsLines): self
    {
        $this->timesheetEarningsLines = $timesheetEarningsLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getDeductionLines(): array
    {
        return $this->deductionLines;
    }

    /** @param list<array<string, mixed>> $deductionLines */
    public function setDeductionLines(array $deductionLines): self
    {
        $this->deductionLines = $deductionLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getLeaveAccrualLines(): array
    {
        return $this->leaveAccrualLines;
    }

    /** @param list<array<string, mixed>> $leaveAccrualLines */
    public function setLeaveAccrualLines(array $leaveAccrualLines): self
    {
        $this->leaveAccrualLines = $leaveAccrualLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getReimbursementLines(): array
    {
        return $this->reimbursementLines;
    }

    /** @param list<array<string, mixed>> $reimbursementLines */
    public function setReimbursementLines(array $reimbursementLines): self
    {
        $this->reimbursementLines = $reimbursementLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getSuperannuationLines(): array
    {
        return $this->superannuationLines;
    }

    /** @param list<array<string, mixed>> $superannuationLines */
    public function setSuperannuationLines(array $superannuationLines): self
    {
        $this->superannuationLines = $superannuationLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getTaxLines(): array
    {
        return $this->taxLines;
    }

    /** @param list<array<string, mixed>> $taxLines */
    public function setTaxLines(array $taxLines): self
    {
        $this->taxLines = $taxLines;

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
            'Wages' => Field::number()->using('setWages'),
            'Deductions' => Field::number()->using('setDeductions'),
            'Tax' => Field::number()->using('setTax'),
            'Super' => Field::number()->using('setSuper'),
            'Reimbursements' => Field::number()->using('setReimbursements'),
            'NetPay' => Field::number()->using('setNetPay'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'EarningsLines' => Field::array()->using('setEarningsLines'),
            'LeaveEarningsLines' => Field::array()->using('setLeaveEarningsLines'),
            'TimesheetEarningsLines' => Field::array()->using('setTimesheetEarningsLines'),
            'DeductionLines' => Field::array()->using('setDeductionLines'),
            'LeaveAccrualLines' => Field::array()->using('setLeaveAccrualLines'),
            'ReimbursementLines' => Field::array()->using('setReimbursementLines'),
            'SuperannuationLines' => Field::array()->using('setSuperannuationLines'),
            'TaxLines' => Field::array()->using('setTaxLines'),
        ];
    }
}
