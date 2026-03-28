<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\TimeEntry;

use DateTimeInterface;
use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $timeEntryId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $projectId
    ) {
    }

    public function id(string $timeEntryId): self
    {
        $clone = clone $this;
        $clone->timeEntryId = $timeEntryId;

        return $clone;
    }

    public function task(string $taskId): self
    {
        $clone = clone $this;
        $clone->payload['TaskID'] = $taskId;

        return $clone;
    }

    public function user(string $userId): self
    {
        $clone = clone $this;
        $clone->payload['UserID'] = $userId;

        return $clone;
    }

    public function date(DateTimeInterface|string $dateUtc): self
    {
        $clone = clone $this;
        $clone->payload['DateUTC'] = $dateUtc instanceof DateTimeInterface
            ? $dateUtc->format(DateTimeInterface::ATOM)
            : $dateUtc;

        return $clone;
    }

    public function durationMinutes(int $minutes): self
    {
        $clone = clone $this;
        $clone->payload['Duration'] = $minutes;

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;
        $clone->payload['Description'] = $description;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): TimeEntry
    {
        $request = $this->timeEntryId === null
            ? $this->client->post('/projects.xro/2.0/Projects/' . $this->projectId . '/Time')
            : $this->client->put('/projects.xro/2.0/Projects/' . $this->projectId . '/Time/' . $this->timeEntryId);

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send();

        $payload = $response->json();
        $timeEntry = TimeEntries::single($payload);

        if (! is_array($timeEntry)) {
            return (new TimeEntry($this->client))->setProjectID($this->projectId);
        }

        return (new TimeEntries($this->client, $this->projectId))->mapTimeEntry($timeEntry);
    }
}
