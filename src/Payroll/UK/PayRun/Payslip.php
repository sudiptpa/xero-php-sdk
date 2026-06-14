<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Payslip extends Model
{
    public function __construct(
        private ?string $paySlipID = null,
        private ?string $employeeID = null,
        private ?string $payRunID = null,
        private ?string $lastEdited = null,
        private ?string $firstName = null,
        private ?string $lastName = null,
        private ?float $totalEarnings = null,
        private ?float $grossEarnings = null,
        private ?float $totalPay = null,
        private ?float $totalEmployerTaxes = null,
        private ?float $totalEmployeeTaxes = null,
        private ?float $totalDeductions = null,
        private ?float $totalReimbursements = null,
        private ?float $totalCourtOrders = null,
        private ?float $totalBenefits = null,
        private ?string $bacsHash = null,
        private ?string $paymentMethod = null,
    ) {
    }

    /** @var list<array<string, mixed>> */
    private array $earningsLines = [];

    /** @var list<array<string, mixed>> */
    private array $leaveEarningsLines = [];

    /** @var list<array<string, mixed>> */
    private array $timesheetEarningsLines = [];

    /** @var list<array<string, mixed>> */
    private array $deductionLines = [];

    /** @var list<array<string, mixed>> */
    private array $reimbursementLines = [];

    /** @var list<array<string, mixed>> */
    private array $leaveAccrualLines = [];

    /** @var list<array<string, mixed>> */
    private array $benefitLines = [];

    /** @var list<array<string, mixed>> */
    private array $paymentLines = [];

    /** @var list<array<string, mixed>> */
    private array $employeeTaxLines = [];

    /** @var list<array<string, mixed>> */
    private array $employerTaxLines = [];

    /** @var list<array<string, mixed>> */
    private array $courtOrderLines = [];

    public function getPayslipID(): ?string
    {
        return $this->paySlipID;
    }

    public function setPayslipID(?string $paySlipID): self
    {
        $this->paySlipID = $paySlipID;

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

    public function getPayRunID(): ?string
    {
        return $this->payRunID;
    }

    public function setPayRunID(?string $payRunID): self
    {
        $this->payRunID = $payRunID;

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

    public function getTotalEarnings(): ?float
    {
        return $this->totalEarnings;
    }

    public function setTotalEarnings(?float $totalEarnings): self
    {
        $this->totalEarnings = $totalEarnings;

        return $this;
    }

    public function getGrossEarnings(): ?float
    {
        return $this->grossEarnings;
    }

    public function setGrossEarnings(?float $grossEarnings): self
    {
        $this->grossEarnings = $grossEarnings;

        return $this;
    }

    public function getTotalPay(): ?float
    {
        return $this->totalPay;
    }

    public function setTotalPay(?float $totalPay): self
    {
        $this->totalPay = $totalPay;

        return $this;
    }

    public function getTotalEmployerTaxes(): ?float
    {
        return $this->totalEmployerTaxes;
    }

    public function setTotalEmployerTaxes(?float $totalEmployerTaxes): self
    {
        $this->totalEmployerTaxes = $totalEmployerTaxes;

        return $this;
    }

    public function getTotalEmployeeTaxes(): ?float
    {
        return $this->totalEmployeeTaxes;
    }

    public function setTotalEmployeeTaxes(?float $totalEmployeeTaxes): self
    {
        $this->totalEmployeeTaxes = $totalEmployeeTaxes;

        return $this;
    }

    public function getTotalDeductions(): ?float
    {
        return $this->totalDeductions;
    }

    public function setTotalDeductions(?float $totalDeductions): self
    {
        $this->totalDeductions = $totalDeductions;

        return $this;
    }

    public function getTotalReimbursements(): ?float
    {
        return $this->totalReimbursements;
    }

    public function setTotalReimbursements(?float $totalReimbursements): self
    {
        $this->totalReimbursements = $totalReimbursements;

        return $this;
    }

    public function getTotalCourtOrders(): ?float
    {
        return $this->totalCourtOrders;
    }

    public function setTotalCourtOrders(?float $totalCourtOrders): self
    {
        $this->totalCourtOrders = $totalCourtOrders;

        return $this;
    }

    public function getTotalBenefits(): ?float
    {
        return $this->totalBenefits;
    }

    public function setTotalBenefits(?float $totalBenefits): self
    {
        $this->totalBenefits = $totalBenefits;

        return $this;
    }

    public function getBacsHash(): ?string
    {
        return $this->bacsHash;
    }

    public function setBacsHash(?string $bacsHash): self
    {
        $this->bacsHash = $bacsHash;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

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
    public function getBenefitLines(): array
    {
        return $this->benefitLines;
    }

    /** @param list<array<string, mixed>> $benefitLines */
    public function setBenefitLines(array $benefitLines): self
    {
        $this->benefitLines = $benefitLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getPaymentLines(): array
    {
        return $this->paymentLines;
    }

    /** @param list<array<string, mixed>> $paymentLines */
    public function setPaymentLines(array $paymentLines): self
    {
        $this->paymentLines = $paymentLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getEmployeeTaxLines(): array
    {
        return $this->employeeTaxLines;
    }

    /** @param list<array<string, mixed>> $employeeTaxLines */
    public function setEmployeeTaxLines(array $employeeTaxLines): self
    {
        $this->employeeTaxLines = $employeeTaxLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getEmployerTaxLines(): array
    {
        return $this->employerTaxLines;
    }

    /** @param list<array<string, mixed>> $employerTaxLines */
    public function setEmployerTaxLines(array $employerTaxLines): self
    {
        $this->employerTaxLines = $employerTaxLines;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function getCourtOrderLines(): array
    {
        return $this->courtOrderLines;
    }

    /** @param list<array<string, mixed>> $courtOrderLines */
    public function setCourtOrderLines(array $courtOrderLines): self
    {
        $this->courtOrderLines = $courtOrderLines;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'paySlipID' => Field::string()->using('setPayslipID'),
            'employeeID' => Field::string()->using('setEmployeeID'),
            'payRunID' => Field::string()->using('setPayRunID'),
            'lastEdited' => Field::string()->using('setLastEdited'),
            'firstName' => Field::string()->using('setFirstName'),
            'lastName' => Field::string()->using('setLastName'),
            'totalEarnings' => Field::number()->using('setTotalEarnings'),
            'grossEarnings' => Field::number()->using('setGrossEarnings'),
            'totalPay' => Field::number()->using('setTotalPay'),
            'totalEmployerTaxes' => Field::number()->using('setTotalEmployerTaxes'),
            'totalEmployeeTaxes' => Field::number()->using('setTotalEmployeeTaxes'),
            'totalDeductions' => Field::number()->using('setTotalDeductions'),
            'totalReimbursements' => Field::number()->using('setTotalReimbursements'),
            'totalCourtOrders' => Field::number()->using('setTotalCourtOrders'),
            'totalBenefits' => Field::number()->using('setTotalBenefits'),
            'bacsHash' => Field::string()->using('setBacsHash'),
            'paymentMethod' => Field::string()->using('setPaymentMethod'),
            'earningsLines' => Field::array()->using('setEarningsLines'),
            'leaveEarningsLines' => Field::array()->using('setLeaveEarningsLines'),
            'timesheetEarningsLines' => Field::array()->using('setTimesheetEarningsLines'),
            'deductionLines' => Field::array()->using('setDeductionLines'),
            'reimbursementLines' => Field::array()->using('setReimbursementLines'),
            'leaveAccrualLines' => Field::array()->using('setLeaveAccrualLines'),
            'benefitLines' => Field::array()->using('setBenefitLines'),
            'paymentLines' => Field::array()->using('setPaymentLines'),
            'employeeTaxLines' => Field::array()->using('setEmployeeTaxLines'),
            'employerTaxLines' => Field::array()->using('setEmployerTaxLines'),
            'courtOrderLines' => Field::array()->using('setCourtOrderLines'),
        ];
    }
}
