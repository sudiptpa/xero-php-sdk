<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\TimeEntry;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class TimeEntry
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $taskId,
        public ?string $userId,
        public ?string $dateUtc,
        public ?string $status,
        public int|float|null $duration,
        public array $raw = [],
        private ?Client $client = null,
        public ?string $projectId = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null, ?string $projectId = null): self
    {
        return new self(
            $payload['TimeEntryID'] ?? $payload['TimeEntryId'] ?? null,
            $payload['TaskID'] ?? $payload['TaskId'] ?? null,
            $payload['UserID'] ?? $payload['UserId'] ?? null,
            $payload['DateUTC'] ?? $payload['DateUtc'] ?? null,
            $payload['Status'] ?? null,
            $payload['Duration'] ?? null,
            $payload,
            $client,
            $projectId ?? $payload['ProjectID'] ?? $payload['ProjectId'] ?? null
        );
    }

    public function durationMinutes(int $minutes): self
    {
        $payload = $this->raw;
        $payload['Duration'] = $minutes;

        return new self($this->id, $this->taskId, $this->userId, $this->dateUtc, $this->status, $minutes, $payload, $this->client, $this->projectId);
    }

    public function save(): self
    {
        if ($this->client === null || $this->projectId === null) {
            throw new RuntimeException('Cannot save a time entry without a bound client context and project id.');
        }

        $payload = new Payload($this->client, $this->projectId);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->taskId !== null) {
            $payload = $payload->task($this->taskId);
        }

        if ($this->userId !== null) {
            $payload = $payload->user($this->userId);
        }

        if ($this->dateUtc !== null) {
            $payload = $payload->date($this->dateUtc);
        }

        if ($this->duration !== null) {
            $payload = $payload->durationMinutes((int) $this->duration);
        }

        return $payload->save();
    }

    public function delete(): void
    {
        if ($this->client === null || $this->projectId === null || $this->id === null) {
            throw new RuntimeException('Cannot delete a time entry without a bound client context, project id, and time entry id.');
        }

        (new TimeEntries($this->client, $this->projectId))->delete($this->id);
    }
}
