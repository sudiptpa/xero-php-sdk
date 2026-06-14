<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\RepeatingInvoice;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Schedule extends Model
{
    private ?int $period = null;

    private ?string $unit = null;

    private ?int $dueDate = null;

    private ?string $dueDateType = null;

    private ?string $startDate = null;

    private ?string $nextScheduledDate = null;

    private ?string $endDate = null;

    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function setPeriod(?int $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getDueDate(): ?int
    {
        return $this->dueDate;
    }

    public function setDueDate(?int $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getDueDateType(): ?string
    {
        return $this->dueDateType;
    }

    public function setDueDateType(?string $dueDateType): self
    {
        $this->dueDateType = $dueDateType;

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

    public function getNextScheduledDate(): ?string
    {
        return $this->nextScheduledDate;
    }

    public function setNextScheduledDate(?string $nextScheduledDate): self
    {
        $this->nextScheduledDate = $nextScheduledDate;

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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Period' => Field::number(),
            'Unit' => Field::string(),
            'DueDate' => Field::number(),
            'DueDateType' => Field::string(),
            'StartDate' => Field::string(),
            'NextScheduledDate' => Field::string(),
            'EndDate' => Field::string(),
        ];
    }
}
