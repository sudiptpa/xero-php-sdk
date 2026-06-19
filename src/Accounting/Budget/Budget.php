<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Budget;

use Sujip\Xero\Accounting\TrackingCategory\TrackingCategory;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Budget extends Model
{
    private ?string $budgetID = null;
    private ?string $status = null;
    private ?string $type = null;
    private ?string $description = null;
    private ?string $updatedDateUTC = null;

    /**
     * @var list<BudgetLine>
     */
    private array $budgetLines = [];

    /**
     * @var list<TrackingCategory>
     */
    private array $tracking = [];

    public function getBudgetID(): ?string
    {
        return $this->budgetID;
    }

    public function setBudgetID(?string $budgetID): self
    {
        $this->budgetID = $budgetID;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    /**
     * @return list<BudgetLine>
     */
    public function getBudgetLines(): array
    {
        return $this->budgetLines;
    }

    /**
     * @param list<BudgetLine> $budgetLines
     */
    public function setBudgetLines(array $budgetLines): self
    {
        $this->budgetLines = $budgetLines;

        return $this;
    }

    public function addBudgetLine(BudgetLine $budgetLine): self
    {
        $this->budgetLines[] = $budgetLine;

        return $this;
    }

    /**
     * @return list<TrackingCategory>
     */
    public function getTracking(): array
    {
        return $this->tracking;
    }

    /**
     * @param list<TrackingCategory> $tracking
     */
    public function setTracking(array $tracking): self
    {
        $this->tracking = $tracking;

        return $this;
    }

    public function addTracking(TrackingCategory $tracking): self
    {
        $this->tracking[] = $tracking;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'BudgetID' => Field::string()->using('setBudgetID'),
            'Status' => Field::string()->using('setStatus'),
            'Type' => Field::string()->using('setType'),
            'Description' => Field::string()->using('setDescription'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'BudgetLines' => Field::many(BudgetLine::class)->using('addBudgetLine'),
            'Tracking' => Field::many(TrackingCategory::class)->using('addTracking'),
        ];
    }
}
