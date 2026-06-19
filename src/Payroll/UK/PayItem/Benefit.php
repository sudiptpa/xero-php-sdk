<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayItem;

use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Benefit extends Model implements SerializesRequest
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $category = null;

    private ?string $liabilityAccountId = null;

    private ?string $expenseAccountId = null;

    private ?float $standardAmount = null;

    private ?float $percentage = null;

    private ?string $calculationType = null;

    private ?bool $currentRecord = null;

    private ?bool $subjectToNIC = null;

    private ?bool $subjectToPension = null;

    private ?bool $subjectToTax = null;

    private ?bool $isCalculatingOnQualifyingEarnings = null;

    private ?bool $showBalanceToEmployee = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

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

    public function getExpenseAccountId(): ?string
    {
        return $this->expenseAccountId;
    }

    public function setExpenseAccountId(?string $expenseAccountId): self
    {
        $this->expenseAccountId = $expenseAccountId;

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

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(?float $percentage): self
    {
        $this->percentage = $percentage;

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

    public function getCurrentRecord(): ?bool
    {
        return $this->currentRecord;
    }

    public function setCurrentRecord(?bool $currentRecord): self
    {
        $this->currentRecord = $currentRecord;

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

    public function getSubjectToPension(): ?bool
    {
        return $this->subjectToPension;
    }

    public function setSubjectToPension(?bool $subjectToPension): self
    {
        $this->subjectToPension = $subjectToPension;

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

    public function getIsCalculatingOnQualifyingEarnings(): ?bool
    {
        return $this->isCalculatingOnQualifyingEarnings;
    }

    public function setIsCalculatingOnQualifyingEarnings(?bool $isCalculatingOnQualifyingEarnings): self
    {
        $this->isCalculatingOnQualifyingEarnings = $isCalculatingOnQualifyingEarnings;

        return $this;
    }

    public function getShowBalanceToEmployee(): ?bool
    {
        return $this->showBalanceToEmployee;
    }

    public function setShowBalanceToEmployee(?bool $showBalanceToEmployee): self
    {
        $this->showBalanceToEmployee = $showBalanceToEmployee;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'id' => Field::string(),
            'name' => Field::string(),
            'category' => Field::string(),
            'liabilityAccountId' => Field::string(),
            'expenseAccountId' => Field::string(),
            'standardAmount' => Field::number(),
            'percentage' => Field::number(),
            'calculationType' => Field::string(),
            'currentRecord' => Field::boolean(),
            'subjectToNIC' => Field::boolean(),
            'subjectToPension' => Field::boolean(),
            'subjectToTax' => Field::boolean(),
            'isCalculatingOnQualifyingEarnings' => Field::boolean(),
            'showBalanceToEmployee' => Field::boolean(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'id' => $this->getId(),
            'name' => $this->getName(),
            'category' => $this->getCategory(),
            'liabilityAccountId' => $this->getLiabilityAccountId(),
            'expenseAccountId' => $this->getExpenseAccountId(),
            'standardAmount' => $this->getStandardAmount(),
            'percentage' => $this->getPercentage(),
            'calculationType' => $this->getCalculationType(),
            'currentRecord' => $this->getCurrentRecord(),
            'subjectToNIC' => $this->getSubjectToNIC(),
            'subjectToPension' => $this->getSubjectToPension(),
            'subjectToTax' => $this->getSubjectToTax(),
            'isCalculatingOnQualifyingEarnings' => $this->getIsCalculatingOnQualifyingEarnings(),
            'showBalanceToEmployee' => $this->getShowBalanceToEmployee(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
