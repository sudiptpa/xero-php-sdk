<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class StatutoryLeaveSummary extends Model
{
    public function __construct(
        private ?string $statutoryLeaveID = null,
        private ?string $employeeID = null,
        private ?string $type = null,
        private ?string $startDate = null,
        private ?string $endDate = null,
        private ?bool $isEntitled = null,
        private ?string $status = null,
    ) {
    }

    public function getStatutoryLeaveID(): ?string
    {
        return $this->statutoryLeaveID;
    }

    public function setStatutoryLeaveID(?string $statutoryLeaveID): self
    {
        $this->statutoryLeaveID = $statutoryLeaveID;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getIsEntitled(): ?bool
    {
        return $this->isEntitled;
    }

    public function setIsEntitled(?bool $isEntitled): self
    {
        $this->isEntitled = $isEntitled;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'statutoryLeaveID' => Field::string()->using('setStatutoryLeaveID'),
            'employeeID' => Field::string()->using('setEmployeeID'),
            'type' => Field::string()->using('setType'),
            'startDate' => Field::string()->using('setStartDate'),
            'endDate' => Field::string()->using('setEndDate'),
            'isEntitled' => Field::boolean()->using('setIsEntitled'),
            'status' => Field::string()->using('setStatus'),
        ];
    }
}
