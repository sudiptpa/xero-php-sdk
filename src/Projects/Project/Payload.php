<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Project;

use DateTimeInterface;
use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $projectId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $projectId): self
    {
        $clone = clone $this;
        $clone->projectId = $projectId;

        return $clone;
    }

    public function title(string $title): self
    {
        $clone = clone $this;
        $clone->payload['Title'] = $title;

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->payload['ContactID'] = $contactId;

        return $clone;
    }

    public function state(string $state): self
    {
        $clone = clone $this;
        $clone->payload['State'] = strtoupper($state);

        return $clone;
    }

    public function estimateMinutes(int $minutes): self
    {
        $clone = clone $this;
        $clone->payload['EstimateMinutes'] = $minutes;

        return $clone;
    }

    public function deadline(DateTimeInterface|string $deadlineUtc): self
    {
        $clone = clone $this;
        $clone->payload['DeadlineUTC'] = $deadlineUtc instanceof DateTimeInterface
            ? $deadlineUtc->format(DateTimeInterface::ATOM)
            : $deadlineUtc;

        return $clone;
    }

    public function notes(string $notes): self
    {
        $clone = clone $this;
        $clone->payload['Notes'] = $notes;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Project
    {
        $request = $this->projectId === null
            ? $this->client->post('/projects.xro/2.0/Projects')
            : $this->client->put('/projects.xro/2.0/Projects/' . $this->projectId);

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send();

        $payload = $response->json();
        $project = Projects::single($payload);

        return Project::fromArray(is_array($project) ? $project : [], $this->client);
    }
}
