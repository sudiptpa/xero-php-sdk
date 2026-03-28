<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\TimeEntry;

use RuntimeException;
use Sujip\Xero\Client;

final class TimeEntry
{
    private ?string $timeEntryID = null;

    private ?string $taskID = null;

    private ?string $userID = null;

    private ?string $dateUTC = null;

    private ?string $status = null;

    private int|float|null $duration = null;

    private ?string $projectID = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getTimeEntryID(): ?string
    {
        return $this->timeEntryID;
    }

    public function setTimeEntryID(?string $timeEntryID): self
    {
        $this->timeEntryID = $timeEntryID;

        return $this;
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

    public function getUserID(): ?string
    {
        return $this->userID;
    }

    public function setUserID(?string $userID): self
    {
        $this->userID = $userID;

        return $this;
    }

    public function getDateUTC(): ?string
    {
        return $this->dateUTC;
    }

    public function setDateUTC(?string $dateUTC): self
    {
        $this->dateUTC = $dateUTC;

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

    public function getDuration(): int|float|null
    {
        return $this->duration;
    }

    public function setDuration(int|float|null $duration): self
    {
        $this->duration = $duration;

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

    public function durationMinutes(int $minutes): self
    {
        return $this->setDuration($minutes);
    }

    public function save(): self
    {
        if ($this->client === null || $this->projectID === null) {
            throw new RuntimeException('Cannot save a time entry without a bound client context and project id.');
        }

        $payload = new Payload($this->client, $this->projectID);

        if ($this->timeEntryID !== null) {
            $payload = $payload->id($this->timeEntryID);
        }

        if ($this->taskID !== null) {
            $payload = $payload->task($this->taskID);
        }

        if ($this->userID !== null) {
            $payload = $payload->user($this->userID);
        }

        if ($this->dateUTC !== null) {
            $payload = $payload->date($this->dateUTC);
        }

        if ($this->duration !== null) {
            $payload = $payload->durationMinutes((int) $this->duration);
        }

        return $payload->save();
    }

    public function delete(): void
    {
        if ($this->client === null || $this->projectID === null || $this->timeEntryID === null) {
            throw new RuntimeException('Cannot delete a time entry without a bound client context, project id, and time entry id.');
        }

        (new TimeEntries($this->client, $this->projectID))->delete($this->timeEntryID);
    }
}
