<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Task;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Projects\Project\Amount;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Task extends Model
{
    private ?string $taskId = null;

    private ?string $name = null;

    private ?Amount $rate = null;

    private ?string $chargeType = null;

    private ?int $estimateMinutes = null;

    private ?string $projectId = null;

    private ?int $totalMinutes = null;

    private ?Amount $totalAmount = null;

    private ?int $minutesInvoiced = null;

    private ?int $minutesToBeInvoiced = null;

    private ?int $fixedMinutes = null;

    private ?int $nonChargeableMinutes = null;

    private ?Amount $amountToBeInvoiced = null;

    private ?Amount $amountInvoiced = null;

    private ?string $status = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getTaskId(): ?string
    {
        return $this->taskId;
    }

    public function setTaskId(?string $taskId): self
    {
        $this->taskId = $taskId;

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

    public function getRate(): ?Amount
    {
        return $this->rate;
    }

    public function setRate(?Amount $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getChargeType(): ?string
    {
        return $this->chargeType;
    }

    public function setChargeType(?string $chargeType): self
    {
        $this->chargeType = $chargeType === null ? null : strtoupper($chargeType);

        return $this;
    }

    public function getEstimateMinutes(): ?int
    {
        return $this->estimateMinutes;
    }

    public function setEstimateMinutes(?int $estimateMinutes): self
    {
        $this->estimateMinutes = $estimateMinutes;

        return $this;
    }

    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getTotalMinutes(): ?int
    {
        return $this->totalMinutes;
    }

    public function setTotalMinutes(?int $totalMinutes): self
    {
        $this->totalMinutes = $totalMinutes;

        return $this;
    }

    public function getTotalAmount(): ?Amount
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(?Amount $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getMinutesInvoiced(): ?int
    {
        return $this->minutesInvoiced;
    }

    public function setMinutesInvoiced(?int $minutesInvoiced): self
    {
        $this->minutesInvoiced = $minutesInvoiced;

        return $this;
    }

    public function getMinutesToBeInvoiced(): ?int
    {
        return $this->minutesToBeInvoiced;
    }

    public function setMinutesToBeInvoiced(?int $minutesToBeInvoiced): self
    {
        $this->minutesToBeInvoiced = $minutesToBeInvoiced;

        return $this;
    }

    public function getFixedMinutes(): ?int
    {
        return $this->fixedMinutes;
    }

    public function setFixedMinutes(?int $fixedMinutes): self
    {
        $this->fixedMinutes = $fixedMinutes;

        return $this;
    }

    public function getNonChargeableMinutes(): ?int
    {
        return $this->nonChargeableMinutes;
    }

    public function setNonChargeableMinutes(?int $nonChargeableMinutes): self
    {
        $this->nonChargeableMinutes = $nonChargeableMinutes;

        return $this;
    }

    public function getAmountToBeInvoiced(): ?Amount
    {
        return $this->amountToBeInvoiced;
    }

    public function setAmountToBeInvoiced(?Amount $amountToBeInvoiced): self
    {
        $this->amountToBeInvoiced = $amountToBeInvoiced;

        return $this;
    }

    public function getAmountInvoiced(): ?Amount
    {
        return $this->amountInvoiced;
    }

    public function setAmountInvoiced(?Amount $amountInvoiced): self
    {
        $this->amountInvoiced = $amountInvoiced;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status === null ? null : strtoupper($status);

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'taskId' => Field::string(),
            'name' => Field::string(),
            'rate' => Field::object(Amount::class),
            'chargeType' => Field::string(),
            'estimateMinutes' => Field::number(),
            'projectId' => Field::string(),
            'totalMinutes' => Field::number(),
            'totalAmount' => Field::object(Amount::class),
            'minutesInvoiced' => Field::number(),
            'minutesToBeInvoiced' => Field::number(),
            'fixedMinutes' => Field::number(),
            'nonChargeableMinutes' => Field::number(),
            'amountToBeInvoiced' => Field::object(Amount::class),
            'amountInvoiced' => Field::object(Amount::class),
            'status' => Field::string(),
        ];
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function rate(int|float $value, ?string $currency = null): self
    {
        return $this->setRate((new Amount())->setValue($value)->setCurrency($currency));
    }

    public function save(): self
    {
        if ($this->client === null || $this->projectId === null) {
            throw new RuntimeException('Cannot save a task without a bound client context and project id.');
        }

        $payload = new Payload($this->client, $this->projectId);

        if ($this->taskId !== null) {
            $payload = $payload->id($this->taskId);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        if ($this->chargeType !== null) {
            $payload = $payload->chargeType($this->chargeType);
        }

        if ($this->rate !== null && $this->rate->getValue() !== null) {
            $payload = $payload->rate($this->rate->getValue(), $this->rate->getCurrency());
        }

        if ($this->estimateMinutes !== null) {
            $payload = $payload->estimateMinutes($this->estimateMinutes);
        }

        return $payload->save();
    }

    public function delete(): void
    {
        if ($this->client === null || $this->projectId === null || $this->taskId === null) {
            throw new RuntimeException('Cannot delete a task without a bound client context, project id, and task id.');
        }

        (new Tasks($this->client, $this->projectId))->delete($this->taskId);
    }
}
