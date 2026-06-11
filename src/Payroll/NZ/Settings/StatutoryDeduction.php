<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class StatutoryDeduction extends Model
{
    public function __construct(
        private ?string $id = null,
        private ?string $name = null,
        private ?string $statutoryDeductionCategory = null,
        private ?string $liabilityAccountId = null,
        private ?bool $currentRecord = null,
    ) {
    }

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
            'id' => Field::string()->using('setId'),
            'name' => Field::string()->using('setName'),
            'statutoryDeductionCategory' => Field::string()->using('setStatutoryDeductionCategory'),
            'liabilityAccountId' => Field::string()->using('setLiabilityAccountId'),
            'currentRecord' => Field::boolean()->using('setCurrentRecord'),
        ];
    }
}
