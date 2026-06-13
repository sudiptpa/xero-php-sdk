<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\StatutoryLeave;

use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class EmployeeStatutorySickLeave extends Model implements SerializesRequest
{
    private ?string $statutoryLeaveID = null;

    private ?string $employeeID = null;

    private ?string $leaveTypeID = null;

    private ?string $startDate = null;

    private ?string $endDate = null;

    private ?string $type = null;

    private ?string $status = null;

    /**
     * @var array<int|string, mixed>
     */
    private array $workPattern = [];

    private ?bool $isPregnancyRelated = null;

    private ?bool $sufficientNotice = null;

    private ?bool $isEntitled = null;

    private ?float $entitlementWeeksRequested = null;

    private ?float $entitlementWeeksQualified = null;

    private ?float $entitlementWeeksRemaining = null;

    private ?bool $overlapsWithOtherLeave = null;

    /**
     * @var array<int|string, mixed>
     */
    private array $entitlementFailureReasons = [];

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

    public function getLeaveTypeID(): ?string
    {
        return $this->leaveTypeID;
    }

    public function setLeaveTypeID(?string $leaveTypeID): self
    {
        $this->leaveTypeID = $leaveTypeID;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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
     * @return array<int|string, mixed>
     */
    public function getWorkPattern(): array
    {
        return $this->workPattern;
    }

    /**
     * @param array<int|string, mixed> $workPattern
     */
    public function setWorkPattern(array $workPattern): self
    {
        $this->workPattern = $workPattern;

        return $this;
    }

    public function getIsPregnancyRelated(): ?bool
    {
        return $this->isPregnancyRelated;
    }

    public function setIsPregnancyRelated(?bool $isPregnancyRelated): self
    {
        $this->isPregnancyRelated = $isPregnancyRelated;

        return $this;
    }

    public function getSufficientNotice(): ?bool
    {
        return $this->sufficientNotice;
    }

    public function setSufficientNotice(?bool $sufficientNotice): self
    {
        $this->sufficientNotice = $sufficientNotice;

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

    public function getEntitlementWeeksRequested(): ?float
    {
        return $this->entitlementWeeksRequested;
    }

    public function setEntitlementWeeksRequested(?float $entitlementWeeksRequested): self
    {
        $this->entitlementWeeksRequested = $entitlementWeeksRequested;

        return $this;
    }

    public function getEntitlementWeeksQualified(): ?float
    {
        return $this->entitlementWeeksQualified;
    }

    public function setEntitlementWeeksQualified(?float $entitlementWeeksQualified): self
    {
        $this->entitlementWeeksQualified = $entitlementWeeksQualified;

        return $this;
    }

    public function getEntitlementWeeksRemaining(): ?float
    {
        return $this->entitlementWeeksRemaining;
    }

    public function setEntitlementWeeksRemaining(?float $entitlementWeeksRemaining): self
    {
        $this->entitlementWeeksRemaining = $entitlementWeeksRemaining;

        return $this;
    }

    public function getOverlapsWithOtherLeave(): ?bool
    {
        return $this->overlapsWithOtherLeave;
    }

    public function setOverlapsWithOtherLeave(?bool $overlapsWithOtherLeave): self
    {
        $this->overlapsWithOtherLeave = $overlapsWithOtherLeave;

        return $this;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getEntitlementFailureReasons(): array
    {
        return $this->entitlementFailureReasons;
    }

    /**
     * @param array<int|string, mixed> $entitlementFailureReasons
     */
    public function setEntitlementFailureReasons(array $entitlementFailureReasons): self
    {
        $this->entitlementFailureReasons = $entitlementFailureReasons;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'statutoryLeaveID' => Field::string(),
            'employeeID' => Field::string(),
            'leaveTypeID' => Field::string(),
            'startDate' => Field::string(),
            'endDate' => Field::string(),
            'type' => Field::string(),
            'status' => Field::string(),
            'workPattern' => Field::array(),
            'isPregnancyRelated' => Field::boolean(),
            'sufficientNotice' => Field::boolean(),
            'isEntitled' => Field::boolean(),
            'entitlementWeeksRequested' => Field::number(),
            'entitlementWeeksQualified' => Field::number(),
            'entitlementWeeksRemaining' => Field::number(),
            'overlapsWithOtherLeave' => Field::boolean(),
            'entitlementFailureReasons' => Field::array(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'statutoryLeaveID' => $this->getStatutoryLeaveID(),
            'employeeID' => $this->getEmployeeID(),
            'leaveTypeID' => $this->getLeaveTypeID(),
            'startDate' => $this->getStartDate(),
            'endDate' => $this->getEndDate(),
            'workPattern' => $this->getWorkPattern() === [] ? null : $this->getWorkPattern(),
            'isPregnancyRelated' => $this->getIsPregnancyRelated(),
            'sufficientNotice' => $this->getSufficientNotice(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
