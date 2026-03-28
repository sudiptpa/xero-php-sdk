<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Task;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $taskId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $projectId
    ) {
    }

    public function id(string $taskId): self
    {
        $clone = clone $this;
        $clone->taskId = $taskId;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['Name'] = $name;

        return $clone;
    }

    public function chargeType(string $chargeType): self
    {
        $clone = clone $this;
        $clone->payload['ChargeType'] = strtoupper($chargeType);

        return $clone;
    }

    public function rate(int|float $rate): self
    {
        $clone = clone $this;
        $clone->payload['Rate'] = $rate;

        return $clone;
    }

    public function estimateMinutes(int $minutes): self
    {
        $clone = clone $this;
        $clone->payload['EstimateMinutes'] = $minutes;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Task
    {
        $request = $this->taskId === null
            ? $this->client->post('/projects.xro/2.0/Projects/' . $this->projectId . '/Tasks')
            : $this->client->put('/projects.xro/2.0/Projects/' . $this->projectId . '/Tasks/' . $this->taskId);

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send();

        $payload = $response->json();
        $task = Tasks::single($payload);

        if (! is_array($task)) {
            return (new Task($this->client))->setProjectID($this->projectId);
        }

        return (new Tasks($this->client, $this->projectId))->mapTask($task);
    }
}
