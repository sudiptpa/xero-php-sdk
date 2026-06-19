<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayItem;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class EarningsOrder extends Model
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $statutoryDeductionCategory = null;

    private ?string $liabilityAccountId = null;

    private ?bool $currentRecord = null;

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

    public function getStatutoryDeductionCategory(): ?string
    {
        return $this->statutoryDeductionCategory;
    }

    public function setStatutoryDeductionCategory(?string $statutoryDeductionCategory): self
    {
        $this->statutoryDeductionCategory = $statutoryDeductionCategory;

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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'id' => Field::string(),
            'name' => Field::string(),
            'statutoryDeductionCategory' => Field::string(),
            'liabilityAccountId' => Field::string(),
            'currentRecord' => Field::boolean(),
        ];
    }
}
