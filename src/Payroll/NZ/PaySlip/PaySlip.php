<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PaySlip;

use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PaySlip extends Model implements SerializesRequest
{
    private ?string $paySlipID = null;

    private ?string $employeeID = null;

    private ?string $payRunID = null;

    private ?string $lastEdited = null;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?float $totalEarnings = null;

    private ?float $grossEarnings = null;

    private ?float $totalPay = null;

    private ?float $totalEmployerTaxes = null;

    private ?float $totalEmployeeTaxes = null;

    private ?float $totalDeductions = null;

    private ?float $totalReimbursements = null;

    private ?float $totalStatutoryDeductions = null;

    private ?float $totalSuperannuation = null;

    private ?string $bacsHash = null;

    private ?string $paymentMethod = null;

    /**
     * @var array<int|string, mixed>
     */
    private array $earningsLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $leaveEarningsLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $timesheetEarningsLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $deductionLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $reimbursementLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $leaveAccrualLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $superannuationLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $paymentLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $employeeTaxLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $employerTaxLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $statutoryDeductionLines = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $taxSettings = [];

    /**
     * @var array<int|string, mixed>
     */
    private array $grossEarningsHistory = [];

    public function getPaySlipID(): ?string
    {
        return $this->paySlipID;
    }

    public function setPaySlipID(?string $paySlipID): self
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

    public function getTotalStatutoryDeductions(): ?float
    {
        return $this->totalStatutoryDeductions;
    }

    public function setTotalStatutoryDeductions(?float $totalStatutoryDeductions): self
    {
        $this->totalStatutoryDeductions = $totalStatutoryDeductions;

        return $this;
    }

    public function getTotalSuperannuation(): ?float
    {
        return $this->totalSuperannuation;
    }

    public function setTotalSuperannuation(?float $totalSuperannuation): self
    {
        $this->totalSuperannuation = $totalSuperannuation;

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

    /**
     * @return array<int|string, mixed>
     */
    public function getEarningsLines(): array
    {
        return $this->earningsLines;
    }

    /**
     * @param array<int|string, mixed> $earningsLines
     */
    public function setEarningsLines(array $earningsLines): self
    {
        $this->earningsLines = $earningsLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getLeaveEarningsLines(): array
    {
        return $this->leaveEarningsLines;
    }

    /**
     * @param array<int|string, mixed> $leaveEarningsLines
     */
    public function setLeaveEarningsLines(array $leaveEarningsLines): self
    {
        $this->leaveEarningsLines = $leaveEarningsLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getTimesheetEarningsLines(): array
    {
        return $this->timesheetEarningsLines;
    }

    /**
     * @param array<int|string, mixed> $timesheetEarningsLines
     */
    public function setTimesheetEarningsLines(array $timesheetEarningsLines): self
    {
        $this->timesheetEarningsLines = $timesheetEarningsLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getDeductionLines(): array
    {
        return $this->deductionLines;
    }

    /**
     * @param array<int|string, mixed> $deductionLines
     */
    public function setDeductionLines(array $deductionLines): self
    {
        $this->deductionLines = $deductionLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getReimbursementLines(): array
    {
        return $this->reimbursementLines;
    }

    /**
     * @param array<int|string, mixed> $reimbursementLines
     */
    public function setReimbursementLines(array $reimbursementLines): self
    {
        $this->reimbursementLines = $reimbursementLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getLeaveAccrualLines(): array
    {
        return $this->leaveAccrualLines;
    }

    /**
     * @param array<int|string, mixed> $leaveAccrualLines
     */
    public function setLeaveAccrualLines(array $leaveAccrualLines): self
    {
        $this->leaveAccrualLines = $leaveAccrualLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getSuperannuationLines(): array
    {
        return $this->superannuationLines;
    }

    /**
     * @param array<int|string, mixed> $superannuationLines
     */
    public function setSuperannuationLines(array $superannuationLines): self
    {
        $this->superannuationLines = $superannuationLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getPaymentLines(): array
    {
        return $this->paymentLines;
    }

    /**
     * @param array<int|string, mixed> $paymentLines
     */
    public function setPaymentLines(array $paymentLines): self
    {
        $this->paymentLines = $paymentLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getEmployeeTaxLines(): array
    {
        return $this->employeeTaxLines;
    }

    /**
     * @param array<int|string, mixed> $employeeTaxLines
     */
    public function setEmployeeTaxLines(array $employeeTaxLines): self
    {
        $this->employeeTaxLines = $employeeTaxLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getEmployerTaxLines(): array
    {
        return $this->employerTaxLines;
    }

    /**
     * @param array<int|string, mixed> $employerTaxLines
     */
    public function setEmployerTaxLines(array $employerTaxLines): self
    {
        $this->employerTaxLines = $employerTaxLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getStatutoryDeductionLines(): array
    {
        return $this->statutoryDeductionLines;
    }

    /**
     * @param array<int|string, mixed> $statutoryDeductionLines
     */
    public function setStatutoryDeductionLines(array $statutoryDeductionLines): self
    {
        $this->statutoryDeductionLines = $statutoryDeductionLines;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getTaxSettings(): array
    {
        return $this->taxSettings;
    }

    /**
     * @param array<int|string, mixed> $taxSettings
     */
    public function setTaxSettings(array $taxSettings): self
    {
        $this->taxSettings = $taxSettings;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getGrossEarningsHistory(): array
    {
        return $this->grossEarningsHistory;
    }

    /**
     * @param array<int|string, mixed> $grossEarningsHistory
     */
    public function setGrossEarningsHistory(array $grossEarningsHistory): self
    {
        $this->grossEarningsHistory = $grossEarningsHistory;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'paySlipID' => Field::string(),
            'employeeID' => Field::string(),
            'payRunID' => Field::string(),
            'lastEdited' => Field::string(),
            'firstName' => Field::string(),
            'lastName' => Field::string(),
            'totalEarnings' => Field::number(),
            'grossEarnings' => Field::number(),
            'totalPay' => Field::number(),
            'totalEmployerTaxes' => Field::number(),
            'totalEmployeeTaxes' => Field::number(),
            'totalDeductions' => Field::number(),
            'totalReimbursements' => Field::number(),
            'totalStatutoryDeductions' => Field::number(),
            'totalSuperannuation' => Field::number(),
            'bacsHash' => Field::string(),
            'paymentMethod' => Field::string(),
            'earningsLines' => Field::array(),
            'leaveEarningsLines' => Field::array(),
            'timesheetEarningsLines' => Field::array(),
            'deductionLines' => Field::array(),
            'reimbursementLines' => Field::array(),
            'leaveAccrualLines' => Field::array(),
            'superannuationLines' => Field::array(),
            'paymentLines' => Field::array(),
            'employeeTaxLines' => Field::array(),
            'employerTaxLines' => Field::array(),
            'statutoryDeductionLines' => Field::array(),
            'taxSettings' => Field::array(),
            'grossEarningsHistory' => Field::array(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'paySlipID' => $this->getPaySlipID(),
            'employeeID' => $this->getEmployeeID(),
            'payRunID' => $this->getPayRunID(),
            'lastEdited' => $this->getLastEdited(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'totalEarnings' => $this->getTotalEarnings(),
            'grossEarnings' => $this->getGrossEarnings(),
            'totalPay' => $this->getTotalPay(),
            'totalEmployerTaxes' => $this->getTotalEmployerTaxes(),
            'totalEmployeeTaxes' => $this->getTotalEmployeeTaxes(),
            'totalDeductions' => $this->getTotalDeductions(),
            'totalReimbursements' => $this->getTotalReimbursements(),
            'totalStatutoryDeductions' => $this->getTotalStatutoryDeductions(),
            'totalSuperannuation' => $this->getTotalSuperannuation(),
            'bacsHash' => $this->getBacsHash(),
            'paymentMethod' => $this->getPaymentMethod(),
            'earningsLines' => $this->getEarningsLines(),
            'leaveEarningsLines' => $this->getLeaveEarningsLines(),
            'timesheetEarningsLines' => $this->getTimesheetEarningsLines(),
            'deductionLines' => $this->getDeductionLines(),
            'reimbursementLines' => $this->getReimbursementLines(),
            'leaveAccrualLines' => $this->getLeaveAccrualLines(),
            'superannuationLines' => $this->getSuperannuationLines(),
            'paymentLines' => $this->getPaymentLines(),
            'employeeTaxLines' => $this->getEmployeeTaxLines(),
            'employerTaxLines' => $this->getEmployerTaxLines(),
            'statutoryDeductionLines' => $this->getStatutoryDeductionLines(),
            'taxSettings' => $this->getTaxSettings(),
            'grossEarningsHistory' => $this->getGrossEarningsHistory(),
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }
}
