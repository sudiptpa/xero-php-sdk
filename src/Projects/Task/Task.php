<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Task;

use RuntimeException;
use Sujip\Xero\Client;

final class Task
{
    private ?string $taskID = null;

    private ?string $name = null;

    private ?string $chargeType = null;

    private int|float|null $rate = null;

    private ?string $projectID = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getTaskID(): ?string
    {
        return $this->taskID;
    }

    public function setTaskID(?string $taskID): self
    {
        $this->taskID = $taskID;

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

    public function getChargeType(): ?string
    {
        return $this->chargeType;
    }

    public function setChargeType(?string $chargeType): self
    {
        $this->chargeType = $chargeType === null ? null : strtoupper($chargeType);

        return $this;
    }

    public function getRate(): int|float|null
    {
        return $this->rate;
    }

    public function setRate(int|float|null $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getProjectID(): ?string
    {
        return $this->projectID;
    }

    public function setProjectID(?string $projectID): self
    {
        $this->projectID = $projectID;

        return $this;
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function rate(int|float $rate): self
    {
        return $this->setRate($rate);
    }

    public function save(): self
    {
        if ($this->client === null || $this->projectID === null) {
            throw new RuntimeException('Cannot save a task without a bound client context and project id.');
        }

        $payload = new Payload($this->client, $this->projectID);

        if ($this->taskID !== null) {
            $payload = $payload->id($this->taskID);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        if ($this->chargeType !== null) {
            $payload = $payload->chargeType($this->chargeType);
        }

        if ($this->rate !== null) {
            $payload = $payload->rate($this->rate);
        }

        return $payload->save();
    }

    public function delete(): void
    {
        if ($this->client === null || $this->projectID === null || $this->taskID === null) {
            throw new RuntimeException('Cannot delete a task without a bound client context, project id, and task id.');
        }

        (new Tasks($this->client, $this->projectID))->delete($this->taskID);
    }
}
