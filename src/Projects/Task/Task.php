<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Task;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Task
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $chargeType,
        public int|float|null $rate,
        public ?string $projectId,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null, ?string $projectId = null): self
    {
        return new self(
            $payload['TaskID'] ?? $payload['TaskId'] ?? null,
            $payload['Name'] ?? null,
            $payload['ChargeType'] ?? null,
            $payload['Rate'] ?? null,
            $projectId ?? $payload['ProjectID'] ?? $payload['ProjectId'] ?? null,
            $payload,
            $client
        );
    }

    public function name(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self($this->id, $name, $this->chargeType, $this->rate, $this->projectId, $payload, $this->client);
    }

    public function rate(int|float $rate): self
    {
        $payload = $this->raw;
        $payload['Rate'] = $rate;

        return new self($this->id, $this->name, $this->chargeType, $rate, $this->projectId, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null || $this->projectId === null) {
            throw new RuntimeException('Cannot save a task without a bound client context and project id.');
        }

        $payload = new Payload($this->client, $this->projectId);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
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
        if ($this->client === null || $this->projectId === null || $this->id === null) {
            throw new RuntimeException('Cannot delete a task without a bound client context, project id, and task id.');
        }

        (new Tasks($this->client, $this->projectId))->delete($this->id);
    }
}
