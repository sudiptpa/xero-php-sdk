<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TaxDeclaration extends Model
{
    public function __construct(
        private ?string $employeeID = null,
        private ?string $employmentBasis = null,
        private ?string $tFNExemptionType = null,
        private ?string $taxFileNumber = null,
        private ?string $aBN = null,
        private ?bool $australianResidentForTaxPurposes = null,
        private ?string $residencyStatus = null,
        private ?string $taxScaleType = null,
        private ?string $workCondition = null,
        private ?string $seniorMaritalStatus = null,
        private ?bool $taxFreeThresholdClaimed = null,
        private ?float $taxOffsetEstimatedAmount = null,
        private ?bool $hasHELPDebt = null,
        private ?bool $hasSFSSDebt = null,
        private ?bool $hasTradeSupportLoanDebt = null,
        private ?float $upwardVariationTaxWithholdingAmount = null,
        private ?bool $eligibleToReceiveLeaveLoading = null,
        private ?float $approvedWithholdingVariationPercentage = null,
        private ?bool $hasStudentStartupLoan = null,
        private ?bool $hasLoanOrStudentDebt = null,
        private ?string $updatedDateUTC = null,
        private ?bool $includeLeaveLoadingInQualifyingEarnings = null,
    ) {
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

    public function getEmploymentBasis(): ?string
    {
        return $this->employmentBasis;
    }

    public function setEmploymentBasis(?string $employmentBasis): self
    {
        $this->employmentBasis = $employmentBasis;
        return $this;
    }

    public function getTFNExemptionType(): ?string
    {
        return $this->tFNExemptionType;
    }

    public function setTFNExemptionType(?string $tFNExemptionType): self
    {
        $this->tFNExemptionType = $tFNExemptionType;
        return $this;
    }

    public function getTaxFileNumber(): ?string
    {
        return $this->taxFileNumber;
    }

    public function setTaxFileNumber(?string $taxFileNumber): self
    {
        $this->taxFileNumber = $taxFileNumber;
        return $this;
    }

    public function getABN(): ?string
    {
        return $this->aBN;
    }

    public function setABN(?string $aBN): self
    {
        $this->aBN = $aBN;
        return $this;
    }

    public function getAustralianResidentForTaxPurposes(): ?bool
    {
        return $this->australianResidentForTaxPurposes;
    }

    public function setAustralianResidentForTaxPurposes(?bool $australianResidentForTaxPurposes): self
    {
        $this->australianResidentForTaxPurposes = $australianResidentForTaxPurposes;
        return $this;
    }

    public function getResidencyStatus(): ?string
    {
        return $this->residencyStatus;
    }

    public function setResidencyStatus(?string $residencyStatus): self
    {
        $this->residencyStatus = $residencyStatus;
        return $this;
    }

    public function getTaxScaleType(): ?string
    {
        return $this->taxScaleType;
    }

    public function setTaxScaleType(?string $taxScaleType): self
    {
        $this->taxScaleType = $taxScaleType;
        return $this;
    }

    public function getWorkCondition(): ?string
    {
        return $this->workCondition;
    }

    public function setWorkCondition(?string $workCondition): self
    {
        $this->workCondition = $workCondition;
        return $this;
    }

    public function getSeniorMaritalStatus(): ?string
    {
        return $this->seniorMaritalStatus;
    }

    public function setSeniorMaritalStatus(?string $seniorMaritalStatus): self
    {
        $this->seniorMaritalStatus = $seniorMaritalStatus;
        return $this;
    }

    public function getTaxFreeThresholdClaimed(): ?bool
    {
        return $this->taxFreeThresholdClaimed;
    }

    public function setTaxFreeThresholdClaimed(?bool $taxFreeThresholdClaimed): self
    {
        $this->taxFreeThresholdClaimed = $taxFreeThresholdClaimed;
        return $this;
    }

    public function getTaxOffsetEstimatedAmount(): ?float
    {
        return $this->taxOffsetEstimatedAmount;
    }

    public function setTaxOffsetEstimatedAmount(?float $taxOffsetEstimatedAmount): self
    {
        $this->taxOffsetEstimatedAmount = $taxOffsetEstimatedAmount;
        return $this;
    }

    public function getHasHELPDebt(): ?bool
    {
        return $this->hasHELPDebt;
    }

    public function setHasHELPDebt(?bool $hasHELPDebt): self
    {
        $this->hasHELPDebt = $hasHELPDebt;
        return $this;
    }

    public function getHasSFSSDebt(): ?bool
    {
        return $this->hasSFSSDebt;
    }

    public function setHasSFSSDebt(?bool $hasSFSSDebt): self
    {
        $this->hasSFSSDebt = $hasSFSSDebt;
        return $this;
    }

    public function getHasTradeSupportLoanDebt(): ?bool
    {
        return $this->hasTradeSupportLoanDebt;
    }

    public function setHasTradeSupportLoanDebt(?bool $hasTradeSupportLoanDebt): self
    {
        $this->hasTradeSupportLoanDebt = $hasTradeSupportLoanDebt;
        return $this;
    }

    public function getUpwardVariationTaxWithholdingAmount(): ?float
    {
        return $this->upwardVariationTaxWithholdingAmount;
    }

    public function setUpwardVariationTaxWithholdingAmount(?float $upwardVariationTaxWithholdingAmount): self
    {
        $this->upwardVariationTaxWithholdingAmount = $upwardVariationTaxWithholdingAmount;
        return $this;
    }

    public function getEligibleToReceiveLeaveLoading(): ?bool
    {
        return $this->eligibleToReceiveLeaveLoading;
    }

    public function setEligibleToReceiveLeaveLoading(?bool $eligibleToReceiveLeaveLoading): self
    {
        $this->eligibleToReceiveLeaveLoading = $eligibleToReceiveLeaveLoading;
        return $this;
    }

    public function getApprovedWithholdingVariationPercentage(): ?float
    {
        return $this->approvedWithholdingVariationPercentage;
    }

    public function setApprovedWithholdingVariationPercentage(?float $approvedWithholdingVariationPercentage): self
    {
        $this->approvedWithholdingVariationPercentage = $approvedWithholdingVariationPercentage;
        return $this;
    }

    public function getHasStudentStartupLoan(): ?bool
    {
        return $this->hasStudentStartupLoan;
    }

    public function setHasStudentStartupLoan(?bool $hasStudentStartupLoan): self
    {
        $this->hasStudentStartupLoan = $hasStudentStartupLoan;
        return $this;
    }

    public function getHasLoanOrStudentDebt(): ?bool
    {
        return $this->hasLoanOrStudentDebt;
    }

    public function setHasLoanOrStudentDebt(?bool $hasLoanOrStudentDebt): self
    {
        $this->hasLoanOrStudentDebt = $hasLoanOrStudentDebt;
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

    public function getIncludeLeaveLoadingInQualifyingEarnings(): ?bool
    {
        return $this->includeLeaveLoadingInQualifyingEarnings;
    }

    public function setIncludeLeaveLoadingInQualifyingEarnings(?bool $includeLeaveLoadingInQualifyingEarnings): self
    {
        $this->includeLeaveLoadingInQualifyingEarnings = $includeLeaveLoadingInQualifyingEarnings;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'EmployeeID' => Field::string()->using('setEmployeeID'),
            'EmploymentBasis' => Field::string()->using('setEmploymentBasis'),
            'TFNExemptionType' => Field::string()->using('setTFNExemptionType'),
            'TaxFileNumber' => Field::string()->using('setTaxFileNumber'),
            'ABN' => Field::string()->using('setABN'),
            'AustralianResidentForTaxPurposes' => Field::boolean()->using('setAustralianResidentForTaxPurposes'),
            'ResidencyStatus' => Field::string()->using('setResidencyStatus'),
            'TaxScaleType' => Field::string()->using('setTaxScaleType'),
            'WorkCondition' => Field::string()->using('setWorkCondition'),
            'SeniorMaritalStatus' => Field::string()->using('setSeniorMaritalStatus'),
            'TaxFreeThresholdClaimed' => Field::boolean()->using('setTaxFreeThresholdClaimed'),
            'TaxOffsetEstimatedAmount' => Field::number()->using('setTaxOffsetEstimatedAmount'),
            'HasHELPDebt' => Field::boolean()->using('setHasHELPDebt'),
            'HasSFSSDebt' => Field::boolean()->using('setHasSFSSDebt'),
            'HasTradeSupportLoanDebt' => Field::boolean()->using('setHasTradeSupportLoanDebt'),
            'UpwardVariationTaxWithholdingAmount' => Field::number()->using('setUpwardVariationTaxWithholdingAmount'),
            'EligibleToReceiveLeaveLoading' => Field::boolean()->using('setEligibleToReceiveLeaveLoading'),
            'ApprovedWithholdingVariationPercentage' => Field::number()->using('setApprovedWithholdingVariationPercentage'),
            'HasStudentStartupLoan' => Field::boolean()->using('setHasStudentStartupLoan'),
            'HasLoanOrStudentDebt' => Field::boolean()->using('setHasLoanOrStudentDebt'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'IncludeLeaveLoadingInQualifyingEarnings' => Field::boolean()->using('setIncludeLeaveLoadingInQualifyingEarnings'),
        ];
    }
}
