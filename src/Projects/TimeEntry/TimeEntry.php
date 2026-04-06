<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\TimeEntry;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TimeEntry extends Model
{
    private ?string $timeEntryID = null;

    private ?string $taskID = null;

    private ?string $userID = null;

    private ?string $dateUTC = null;

    private ?string $status = null;

    private int|float|null $duration = null;

    private ?string $projectID = null;

    private ?string $dateEnteredUTC = null;

    private ?string $description = null;

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

    public function getDateEnteredUTC(): ?string
    {
        return $this->dateEnteredUTC;
    }

    public function setDateEnteredUTC(?string $dateEnteredUTC): self
    {
        $this->dateEnteredUTC = $dateEnteredUTC;

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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'TimeEntryID' => Field::string()->using('setTimeEntryID'),
            'TimeEntryId' => Field::string()->using('setTimeEntryID'),
            'timeEntryId' => Field::string()->using('setTimeEntryID'),
            'TaskID' => Field::string()->using('setTaskID'),
            'TaskId' => Field::string()->using('setTaskID'),
            'taskId' => Field::string()->using('setTaskID'),
            'UserID' => Field::string()->using('setUserID'),
            'UserId' => Field::string()->using('setUserID'),
            'userId' => Field::string()->using('setUserID'),
            'DateUTC' => Field::string()->using('setDateUTC'),
            'DateUtc' => Field::string()->using('setDateUTC'),
            'dateUtc' => Field::string()->using('setDateUTC'),
            'DateEnteredUtc' => Field::string()->using('setDateEnteredUTC'),
            'dateEnteredUtc' => Field::string()->using('setDateEnteredUTC'),
            'Status' => Field::string(),
            'status' => Field::string()->using('setStatus'),
            'Duration' => Field::number(),
            'duration' => Field::number()->using('setDuration'),
            'ProjectID' => Field::string()->using('setProjectID'),
            'ProjectId' => Field::string()->using('setProjectID'),
            'projectId' => Field::string()->using('setProjectID'),
            'Description' => Field::string()->using('setDescription'),
            'description' => Field::string()->using('setDescription'),
        ];
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
