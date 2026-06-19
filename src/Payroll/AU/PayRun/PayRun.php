<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ValidationError;

final class PayRun extends Model
{
    private ?string $payRunID = null;
    private ?string $payrollCalendarID = null;
    private ?string $payRunPeriodStartDate = null;
    private ?string $payRunPeriodEndDate = null;
    private ?string $payRunStatus = null;
    private ?string $paymentDate = null;
    private ?string $payslipMessage = null;
    private ?string $updatedDateUTC = null;

    /** @var list<PayslipSummary> */
    private array $payslips = [];
    private ?float $wages = null;
    private ?float $deductions = null;
    private ?float $tax = null;
    private ?float $super = null;
    private ?float $reimbursement = null;
    private ?float $netPay = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function __construct(
        private ?Client $client = null
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

    public function getPayRunPeriodStartDate(): ?string
    {
        return $this->payRunPeriodStartDate;
    }

    public function setPayRunPeriodStartDate(?string $payRunPeriodStartDate): self
    {
        $this->payRunPeriodStartDate = $payRunPeriodStartDate;

        return $this;
    }

    public function getPayRunPeriodEndDate(): ?string
    {
        return $this->payRunPeriodEndDate;
    }

    public function setPayRunPeriodEndDate(?string $payRunPeriodEndDate): self
    {
        $this->payRunPeriodEndDate = $payRunPeriodEndDate;

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

    public function getPayslipMessage(): ?string
    {
        return $this->payslipMessage;
    }

    public function setPayslipMessage(?string $payslipMessage): self
    {
        $this->payslipMessage = $payslipMessage;

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

    public function getReimbursement(): ?float
    {
        return $this->reimbursement;
    }

    public function setReimbursement(?float $reimbursement): self
    {
        $this->reimbursement = $reimbursement;

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

    public function addPayslipSummary(PayslipSummary $payslip): self
    {
        $this->payslips[] = $payslip;

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
            'PayRunPeriodStartDate' => Field::string()->using('setPayRunPeriodStartDate'),
            'PayRunPeriodEndDate' => Field::string()->using('setPayRunPeriodEndDate'),
            'PayRunStatus' => Field::string()->using('setPayRunStatus'),
            'PaymentDate' => Field::string()->using('setPaymentDate'),
            'PayslipMessage' => Field::string()->using('setPayslipMessage'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'Payslips' => Field::many(PayslipSummary::class)->using('addPayslipSummary'),
            'Wages' => Field::number()->using('setWages'),
            'Deductions' => Field::number()->using('setDeductions'),
            'Tax' => Field::number()->using('setTax'),
            'Super' => Field::number()->using('setSuper'),
            'Reimbursement' => Field::number()->using('setReimbursement'),
            'NetPay' => Field::number()->using('setNetPay'),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }

    /**
     * @return ResourceCollection<PayslipSummary>
     */
    public function payslips(): ResourceCollection
    {
        return new ResourceCollection($this->payslips);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a pay run without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->payRunID !== null) {
            $payload = $payload->id($this->payRunID);
        }

        if ($this->payrollCalendarID !== null) {
            $payload = $payload->payrollCalendar($this->payrollCalendarID);
        }

        return $payload->save();
    }
}
