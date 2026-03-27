<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Project;

use Sujip\Xero\Client;

final class Patch
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $projectId
    ) {
    }

    public function state(string $state): self
    {
        $clone = clone $this;
        $clone->payload['State'] = strtoupper($state);

        return $clone;
    }

    public function close(): self
    {
        return $this->state('CLOSED');
    }

    public function reopen(): self
    {
        return $this->state('INPROGRESS');
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Project
    {
        $response = $this->client
            ->patch('/projects.xro/2.0/Projects/' . $this->projectId)
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send();

        $payload = $response->json();
        $project = Projects::single($payload);

        return Project::fromArray(is_array($project) ? $project : [], $this->client);
    }
}
