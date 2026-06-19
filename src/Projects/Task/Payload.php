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
        $clone->payload['name'] = $name;

        return $clone;
    }

    public function chargeType(string $chargeType): self
    {
        $clone = clone $this;
        $clone->payload['chargeType'] = strtoupper($chargeType);

        return $clone;
    }

    public function rate(int|float $value, ?string $currency = null): self
    {
        $clone = clone $this;
        $clone->payload['rate'] = $currency === null
            ? ['value' => $value]
            : ['currency' => $currency, 'value' => $value];

        return $clone;
    }

    public function estimateMinutes(int $minutes): self
    {
        $clone = clone $this;
        $clone->payload['estimateMinutes'] = $minutes;

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
            $fallback = (new Task($this->client))->fill($this->payload)->setProjectId($this->projectId);

            if ($this->taskId !== null) {
                $fallback->setTaskId($this->taskId);
            }

            return $fallback;
        }

        return (new Tasks($this->client, $this->projectId))->mapTask($task);
    }
}
