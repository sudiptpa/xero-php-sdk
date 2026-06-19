<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PayItem;

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
        ], static fn (mixed $value): bool => $value !== null);
    }
}
