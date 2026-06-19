<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PayRun extends Model
{
    private ?string $payRunID = null;
    private ?string $payrollCalendarID = null;
    private ?string $payRunStatus = null;
    private ?string $paymentDate = null;
    private ?string $periodStartDate = null;
    private ?string $periodEndDate = null;
    private int|float|null $totalCost = null;
    private int|float|null $totalPay = null;
    private ?string $payRunType = null;
    private ?string $calendarType = null;
    private ?string $postedDateTime = null;

    /**
     * @var list<Payslip>
     */
    private array $paySlips = [];

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

    public function getPeriodStartDate(): ?string
    {
        return $this->periodStartDate;
    }

    public function setPeriodStartDate(?string $periodStartDate): self
    {
        $this->periodStartDate = $periodStartDate;

        return $this;
    }

    public function getPeriodEndDate(): ?string
    {
        return $this->periodEndDate;
    }

    public function setPeriodEndDate(?string $periodEndDate): self
    {
        $this->periodEndDate = $periodEndDate;

        return $this;
    }

    public function getTotalCost(): int|float|null
    {
        return $this->totalCost;
    }

    public function setTotalCost(int|float|null $totalCost): self
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    public function getTotalPay(): int|float|null
    {
        return $this->totalPay;
    }

    public function setTotalPay(int|float|null $totalPay): self
    {
        $this->totalPay = $totalPay;

        return $this;
    }

    public function getPayRunType(): ?string
    {
        return $this->payRunType;
    }

    public function setPayRunType(?string $payRunType): self
    {
        $this->payRunType = $payRunType;

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

    public function getPostedDateTime(): ?string
    {
        return $this->postedDateTime;
    }

    public function setPostedDateTime(?string $postedDateTime): self
    {
        $this->postedDateTime = $postedDateTime;

        return $this;
    }

    /**
     * @return list<Payslip>
     */
    public function getPaySlips(): array
    {
        return $this->paySlips;
    }

    public function addPaySlip(Payslip $paySlip): self
    {
        $this->paySlips[] = $paySlip;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'payRunID' => Field::string()->using('setPayRunID'),
            'payrollCalendarID' => Field::string()->using('setPayrollCalendarID'),
            'periodStartDate' => Field::string()->using('setPeriodStartDate'),
            'periodEndDate' => Field::string()->using('setPeriodEndDate'),
            'paymentDate' => Field::string()->using('setPaymentDate'),
            'totalCost' => Field::number()->using('setTotalCost'),
            'totalPay' => Field::number()->using('setTotalPay'),
            'payRunStatus' => Field::string()->using('setPayRunStatus'),
            'payRunType' => Field::string()->using('setPayRunType'),
            'calendarType' => Field::string()->using('setCalendarType'),
            'postedDateTime' => Field::string()->using('setPostedDateTime'),
            'paySlips' => Field::many(Payslip::class),
        ];
    }

    /**
     * @return \Sujip\Xero\Support\ResourceCollection<Payslip>
     */
    public function payslips(): \Sujip\Xero\Support\ResourceCollection
    {
        if ($this->client === null || $this->payRunID === null) {
            throw new RuntimeException('Cannot load payslips without a bound client context and pay run id.');
        }

        return (new PayRuns($this->client))->payslips($this->payRunID)->get();
    }
}
