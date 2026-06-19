<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\TimeEntry;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TimeEntry extends Model
{
    private ?string $timeEntryId = null;

    private ?string $userId = null;

    private ?string $projectId = null;

    private ?string $taskId = null;

    private ?string $dateUtc = null;

    private ?string $dateEnteredUtc = null;

    private int|float|null $duration = null;

    private ?string $description = null;

    private ?string $status = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getTimeEntryId(): ?string
    {
        return $this->timeEntryId;
    }

    public function setTimeEntryId(?string $timeEntryId): self
    {
        $this->timeEntryId = $timeEntryId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): self
    {
        $this->userId = $userId;

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

    public function getTaskId(): ?string
    {
        return $this->taskId;
    }

    public function setTaskId(?string $taskId): self
    {
        $this->taskId = $taskId;

        return $this;
    }

    public function getDateUtc(): ?string
    {
        return $this->dateUtc;
    }

    public function setDateUtc(?string $dateUtc): self
    {
        $this->dateUtc = $dateUtc;

        return $this;
    }

    public function getDateEnteredUtc(): ?string
    {
        return $this->dateEnteredUtc;
    }

    public function setDateEnteredUtc(?string $dateEnteredUtc): self
    {
        $this->dateEnteredUtc = $dateEnteredUtc;

        return $this;
    }

    public function getDuration(): int|float|null
    {
        return $this->duration;
    }

    public function setDuration(int|float|null $duration): self
    {
        $this->duration = $duration;

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
            'timeEntryId' => Field::string(),
            'userId' => Field::string(),
            'projectId' => Field::string(),
            'taskId' => Field::string(),
            'dateUtc' => Field::string(),
            'dateEnteredUtc' => Field::string(),
            'duration' => Field::number(),
            'description' => Field::string(),
            'status' => Field::string(),
        ];
    }

    public function durationMinutes(int $minutes): self
    {
        return $this->setDuration($minutes);
    }

    public function save(): self
    {
        if ($this->client === null || $this->projectId === null) {
            throw new RuntimeException('Cannot save a time entry without a bound client context and project id.');
        }

        $payload = new Payload($this->client, $this->projectId);

        if ($this->timeEntryId !== null) {
            $payload = $payload->id($this->timeEntryId);
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

        if ($this->description !== null) {
            $payload = $payload->description($this->description);
        }

        return $payload->save();
    }

    public function delete(): void
    {
        if ($this->client === null || $this->projectId === null || $this->timeEntryId === null) {
            throw new RuntimeException('Cannot delete a time entry without a bound client context, project id, and time entry id.');
        }

        (new TimeEntries($this->client, $this->projectId))->delete($this->timeEntryId);
    }
}
