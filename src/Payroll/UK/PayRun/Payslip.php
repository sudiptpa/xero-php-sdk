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

    /** @var list<EarningsLine> */
    private array $earningsLines = [];

    /** @var list<LeaveEarningsLine> */
    private array $leaveEarningsLines = [];

    /** @var list<TimesheetEarningsLine> */
    private array $timesheetEarningsLines = [];

    /** @var list<DeductionLine> */
    private array $deductionLines = [];

    /** @var list<ReimbursementLine> */
    private array $reimbursementLines = [];

    /** @var list<LeaveAccrualLine> */
    private array $leaveAccrualLines = [];

    /** @var list<BenefitLine> */
    private array $benefitLines = [];

    /** @var list<PaymentLine> */
    private array $paymentLines = [];

    /** @var list<TaxLine> */
    private array $employeeTaxLines = [];

    /** @var list<TaxLine> */
    private array $employerTaxLines = [];

    /** @var list<CourtOrderLine> */
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

    /** @return list<EarningsLine> */
    public function getEarningsLines(): array
    {
        return $this->earningsLines;
    }

    public function addEarningsLine(EarningsLine $earningsLine): self
    {
        $this->earningsLines[] = $earningsLine;

        return $this;
    }

    /** @return list<LeaveEarningsLine> */
    public function getLeaveEarningsLines(): array
    {
        return $this->leaveEarningsLines;
    }

    public function addLeaveEarningsLine(LeaveEarningsLine $leaveEarningsLine): self
    {
        $this->leaveEarningsLines[] = $leaveEarningsLine;

        return $this;
    }

    /** @return list<TimesheetEarningsLine> */
    public function getTimesheetEarningsLines(): array
    {
        return $this->timesheetEarningsLines;
    }

    public function addTimesheetEarningsLine(TimesheetEarningsLine $timesheetEarningsLine): self
    {
        $this->timesheetEarningsLines[] = $timesheetEarningsLine;

        return $this;
    }

    /** @return list<DeductionLine> */
    public function getDeductionLines(): array
    {
        return $this->deductionLines;
    }

    public function addDeductionLine(DeductionLine $deductionLine): self
    {
        $this->deductionLines[] = $deductionLine;

        return $this;
    }

    /** @return list<ReimbursementLine> */
    public function getReimbursementLines(): array
    {
        return $this->reimbursementLines;
    }

    public function addReimbursementLine(ReimbursementLine $reimbursementLine): self
    {
        $this->reimbursementLines[] = $reimbursementLine;

        return $this;
    }

    /** @return list<LeaveAccrualLine> */
    public function getLeaveAccrualLines(): array
    {
        return $this->leaveAccrualLines;
    }

    public function addLeaveAccrualLine(LeaveAccrualLine $leaveAccrualLine): self
    {
        $this->leaveAccrualLines[] = $leaveAccrualLine;

        return $this;
    }

    /** @return list<BenefitLine> */
    public function getBenefitLines(): array
    {
        return $this->benefitLines;
    }

    public function addBenefitLine(BenefitLine $benefitLine): self
    {
        $this->benefitLines[] = $benefitLine;

        return $this;
    }

    /** @return list<PaymentLine> */
    public function getPaymentLines(): array
    {
        return $this->paymentLines;
    }

    public function addPaymentLine(PaymentLine $paymentLine): self
    {
        $this->paymentLines[] = $paymentLine;

        return $this;
    }

    /** @return list<TaxLine> */
    public function getEmployeeTaxLines(): array
    {
        return $this->employeeTaxLines;
    }

    public function addEmployeeTaxLine(TaxLine $employeeTaxLine): self
    {
        $this->employeeTaxLines[] = $employeeTaxLine;

        return $this;
    }

    /** @return list<TaxLine> */
    public function getEmployerTaxLines(): array
    {
        return $this->employerTaxLines;
    }

    public function addEmployerTaxLine(TaxLine $employerTaxLine): self
    {
        $this->employerTaxLines[] = $employerTaxLine;

        return $this;
    }

    /** @return list<CourtOrderLine> */
    public function getCourtOrderLines(): array
    {
        return $this->courtOrderLines;
    }

    public function addCourtOrderLine(CourtOrderLine $courtOrderLine): self
    {
        $this->courtOrderLines[] = $courtOrderLine;

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
            'earningsLines' => Field::many(EarningsLine::class),
            'leaveEarningsLines' => Field::many(LeaveEarningsLine::class),
            'timesheetEarningsLines' => Field::many(TimesheetEarningsLine::class),
            'deductionLines' => Field::many(DeductionLine::class),
            'reimbursementLines' => Field::many(ReimbursementLine::class),
            'leaveAccrualLines' => Field::many(LeaveAccrualLine::class),
            'benefitLines' => Field::many(BenefitLine::class),
            'paymentLines' => Field::many(PaymentLine::class),
            'employeeTaxLines' => Field::many(TaxLine::class),
            'employerTaxLines' => Field::many(TaxLine::class),
            'courtOrderLines' => Field::many(CourtOrderLine::class),
        ];
    }
}
