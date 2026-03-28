<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Project;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Projects\Task\Tasks;
use Sujip\Xero\Projects\TimeEntry\TimeEntries;

final class Project
{
    private ?string $projectID = null;

    private ?string $title = null;

    private ?string $state = null;

    private ?string $contactID = null;

    private ?string $deadlineUTC = null;

    public function __construct(
        private ?Client $client = null
    ) {
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state === null ? null : strtoupper($state);

        return $this;
    }

    public function getContactID(): ?string
    {
        return $this->contactID;
    }

    public function setContactID(?string $contactID): self
    {
        $this->contactID = $contactID;

        return $this;
    }

    public function getDeadlineUTC(): ?string
    {
        return $this->deadlineUTC;
    }

    public function setDeadlineUTC(?string $deadlineUTC): self
    {
        $this->deadlineUTC = $deadlineUTC;

        return $this;
    }

    public function title(string $title): self
    {
        return $this->setTitle($title);
    }

    public function state(string $state): self
    {
        return $this->setState($state);
    }

    public function deadline(string $deadlineUtc): self
    {
        return $this->setDeadlineUTC($deadlineUtc);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a project without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->projectID !== null) {
            $payload = $payload->id($this->projectID);
        }

        if ($this->title !== null) {
            $payload = $payload->title($this->title);
        }

        if ($this->contactID !== null) {
            $payload = $payload->contact($this->contactID);
        }

        if ($this->state !== null) {
            $payload = $payload->state($this->state);
        }

        if ($this->deadlineUTC !== null) {
            $payload = $payload->deadline($this->deadlineUTC);
        }

        return $payload->save();
    }

    public function tasks(): Tasks
    {
        if ($this->client === null || $this->projectID === null) {
            throw new RuntimeException('Cannot access project tasks without a bound client context and project id.');
        }

        return new Tasks($this->client, $this->projectID);
    }

    public function timeEntries(): TimeEntries
    {
        if ($this->client === null || $this->projectID === null) {
            throw new RuntimeException('Cannot access project time entries without a bound client context and project id.');
        }

        return new TimeEntries($this->client, $this->projectID);
    }

    public function close(): self
    {
        if ($this->client === null || $this->projectID === null) {
            throw new RuntimeException('Cannot close a project without a bound client context and project id.');
        }

        return (new Projects($this->client))->patch($this->projectID)->close()->save();
    }

    public function reopen(): self
    {
        if ($this->client === null || $this->projectID === null) {
            throw new RuntimeException('Cannot reopen a project without a bound client context and project id.');
        }

        return (new Projects($this->client))->patch($this->projectID)->reopen()->save();
    }
}
