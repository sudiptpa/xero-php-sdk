<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Contract extends Model
{
    public function __construct(
        private ?string $startDate = null,
        private ?string $employmentStatus = null,
        private ?string $contractType = null,
        private ?string $publicKey = null,
        private ?bool $isFixedTerm = null,
        private ?string $fixedTermEndDate = null,
        private ?DevelopmentalRoleDetails $developmentalRoleDetails = null,
    ) {
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEmploymentStatus(): ?string
    {
        return $this->employmentStatus;
    }

    public function setEmploymentStatus(?string $employmentStatus): self
    {
        $this->employmentStatus = $employmentStatus;

        return $this;
    }

    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    public function setContractType(?string $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function setPublicKey(?string $publicKey): self
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    public function getIsFixedTerm(): ?bool
    {
        return $this->isFixedTerm;
    }

    public function setIsFixedTerm(?bool $isFixedTerm): self
    {
        $this->isFixedTerm = $isFixedTerm;

        return $this;
    }

    public function getFixedTermEndDate(): ?string
    {
        return $this->fixedTermEndDate;
    }

    public function setFixedTermEndDate(?string $fixedTermEndDate): self
    {
        $this->fixedTermEndDate = $fixedTermEndDate;

        return $this;
    }

    public function getDevelopmentalRoleDetails(): ?DevelopmentalRoleDetails
    {
        return $this->developmentalRoleDetails;
    }

    public function setDevelopmentalRoleDetails(?DevelopmentalRoleDetails $developmentalRoleDetails): self
    {
        $this->developmentalRoleDetails = $developmentalRoleDetails;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'startDate' => Field::string()->using('setStartDate'),
            'employmentStatus' => Field::string()->using('setEmploymentStatus'),
            'contractType' => Field::string()->using('setContractType'),
            'publicKey' => Field::string()->using('setPublicKey'),
            'isFixedTerm' => Field::boolean()->using('setIsFixedTerm'),
            'fixedTermEndDate' => Field::string()->using('setFixedTermEndDate'),
            'developmentalRoleDetails' => Field::object(DevelopmentalRoleDetails::class)->using('setDevelopmentalRoleDetails'),
        ];
    }
}
