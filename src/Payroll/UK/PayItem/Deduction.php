<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayItem;

use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Deduction extends Model implements SerializesRequest
{
    private ?string $deductionId = null;

    private ?string $deductionName = null;

    private ?string $deductionCategory = null;

    private ?string $liabilityAccountId = null;

    private ?bool $currentRecord = null;

    private ?float $standardAmount = null;

    private ?bool $reducesSuperLiability = null;

    private ?bool $reducesTaxLiability = null;

    private ?string $calculationType = null;

    private ?float $percentage = null;

    private ?bool $subjectToNIC = null;

    private ?bool $subjectToTax = null;

    private ?bool $isReducedByBasicRate = null;

    private ?bool $applyToPensionCalculations = null;

    private ?bool $isCalculatingOnQualifyingEarnings = null;

    private ?bool $isPension = null;

    public function getDeductionId(): ?string
    {
        return $this->deductionId;
    }

    public function setDeductionId(?string $deductionId): self
    {
        $this->deductionId = $deductionId;

        return $this;
    }

    public function getDeductionName(): ?string
    {
        return $this->deductionName;
    }

    public function setDeductionName(?string $deductionName): self
    {
        $this->deductionName = $deductionName;

        return $this;
    }

    public function getDeductionCategory(): ?string
    {
        return $this->deductionCategory;
    }

    public function setDeductionCategory(?string $deductionCategory): self
    {
        $this->deductionCategory = $deductionCategory;

        return $this;
    }

    public function getLiabilityAccountId(): ?string
    {
        return $this->liabilityAccountId;
    }

    public function setLiabilityAccountId(?string $liabilityAccountId): self
    {
        $this->liabilityAccountId = $liabilityAccountId;

        return $this;
    }

    public function getCurrentRecord(): ?bool
    {
        return $this->currentRecord;
    }

    public function setCurrentRecord(?bool $currentRecord): self
    {
        $this->currentRecord = $currentRecord;

        return $this;
    }

    public function getStandardAmount(): ?float
    {
        return $this->standardAmount;
    }

    public function setStandardAmount(?float $standardAmount): self
    {
        $this->standardAmount = $standardAmount;

        return $this;
    }

    public function getReducesSuperLiability(): ?bool
    {
        return $this->reducesSuperLiability;
    }

    public function setReducesSuperLiability(?bool $reducesSuperLiability): self
    {
        $this->reducesSuperLiability = $reducesSuperLiability;

        return $this;
    }

    public function getReducesTaxLiability(): ?bool
    {
        return $this->reducesTaxLiability;
    }

    public function setReducesTaxLiability(?bool $reducesTaxLiability): self
    {
        $this->reducesTaxLiability = $reducesTaxLiability;

        return $this;
    }

    public function getCalculationType(): ?string
    {
        return $this->calculationType;
    }

    public function setCalculationType(?string $calculationType): self
    {
        $this->calculationType = $calculationType;

        return $this;
    }

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(?float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getSubjectToNIC(): ?bool
    {
        return $this->subjectToNIC;
    }

    public function setSubjectToNIC(?bool $subjectToNIC): self
    {
        $this->subjectToNIC = $subjectToNIC;

        return $this;
    }

    public function getSubjectToTax(): ?bool
    {
        return $this->subjectToTax;
    }

    public function setSubjectToTax(?bool $subjectToTax): self
    {
        $this->subjectToTax = $subjectToTax;

        return $this;
    }

    public function getIsReducedByBasicRate(): ?bool
    {
        return $this->isReducedByBasicRate;
    }

    public function setIsReducedByBasicRate(?bool $isReducedByBasicRate): self
    {
        $this->isReducedByBasicRate = $isReducedByBasicRate;

        return $this;
    }

    public function getApplyToPensionCalculations(): ?bool
    {
        return $this->applyToPensionCalculations;
    }

    public function setApplyToPensionCalculations(?bool $applyToPensionCalculations): self
    {
        $this->applyToPensionCalculations = $applyToPensionCalculations;

        return $this;
    }

    public function getIsCalculatingOnQualifyingEarnings(): ?bool
    {
        return $this->isCalculatingOnQualifyingEarnings;
    }

    public function setIsCalculatingOnQualifyingEarnings(?bool $isCalculatingOnQualifyingEarnings): self
    {
        $this->isCalculatingOnQualifyingEarnings = $isCalculatingOnQualifyingEarnings;

        return $this;
    }

    public function getIsPension(): ?bool
    {
        return $this->isPension;
    }

    public function setIsPension(?bool $isPension): self
    {
        $this->isPension = $isPension;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'deductionId' => Field::string(),
            'deductionName' => Field::string(),
            'deductionCategory' => Field::string(),
            'liabilityAccountId' => Field::string(),
            'currentRecord' => Field::boolean(),
            'standardAmount' => Field::number(),
            'reducesSuperLiability' => Field::boolean(),
            'reducesTaxLiability' => Field::boolean(),
            'calculationType' => Field::string(),
            'percentage' => Field::number(),
            'subjectToNIC' => Field::boolean(),
            'subjectToTax' => Field::boolean(),
            'isReducedByBasicRate' => Field::boolean(),
            'applyToPensionCalculations' => Field::boolean(),
            'isCalculatingOnQualifyingEarnings' => Field::boolean(),
            'isPension' => Field::boolean(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'deductionId' => $this->getDeductionId(),
            'deductionName' => $this->getDeductionName(),
            'deductionCategory' => $this->getDeductionCategory(),
            'liabilityAccountId' => $this->getLiabilityAccountId(),
            'currentRecord' => $this->getCurrentRecord(),
            'standardAmount' => $this->getStandardAmount(),
            'reducesSuperLiability' => $this->getReducesSuperLiability(),
            'reducesTaxLiability' => $this->getReducesTaxLiability(),
            'calculationType' => $this->getCalculationType(),
            'percentage' => $this->getPercentage(),
            'subjectToNIC' => $this->getSubjectToNIC(),
            'subjectToTax' => $this->getSubjectToTax(),
            'isReducedByBasicRate' => $this->getIsReducedByBasicRate(),
            'applyToPensionCalculations' => $this->getApplyToPensionCalculations(),
            'isCalculatingOnQualifyingEarnings' => $this->getIsCalculatingOnQualifyingEarnings(),
            'isPension' => $this->getIsPension(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
