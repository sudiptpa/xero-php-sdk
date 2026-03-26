<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Project;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Projects\Task\Tasks;
use Sujip\Xero\Projects\TimeEntry\TimeEntries;

final readonly class Project
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $title,
        public ?string $state,
        public ?string $contactId,
        public ?string $deadlineUtc,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['ProjectID'] ?? $payload['ProjectId'] ?? null,
            $payload['Title'] ?? null,
            $payload['State'] ?? null,
            $payload['Contact']['ContactID'] ?? $payload['ContactID'] ?? null,
            $payload['DeadlineUTC'] ?? $payload['DeadlineUtc'] ?? null,
            $payload,
            $client
        );
    }

    public function title(string $title): self
    {
        $payload = $this->raw;
        $payload['Title'] = $title;

        return new self($this->id, $title, $this->state, $this->contactId, $this->deadlineUtc, $payload, $this->client);
    }

    public function state(string $state): self
    {
        $state = strtoupper($state);
        $payload = $this->raw;
        $payload['State'] = $state;

        return new self($this->id, $this->title, $state, $this->contactId, $this->deadlineUtc, $payload, $this->client);
    }

    public function deadline(string $deadlineUtc): self
    {
        $payload = $this->raw;
        $payload['DeadlineUTC'] = $deadlineUtc;

        return new self($this->id, $this->title, $this->state, $this->contactId, $deadlineUtc, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a project without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->title !== null) {
            $payload = $payload->title($this->title);
        }

        if ($this->contactId !== null) {
            $payload = $payload->contact($this->contactId);
        }

        if ($this->state !== null) {
            $payload = $payload->state($this->state);
        }

        if ($this->deadlineUtc !== null) {
            $payload = $payload->deadline($this->deadlineUtc);
        }

        return $payload->save();
    }

    public function tasks(): Tasks
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access project tasks without a bound client context and project id.');
        }

        return new Tasks($this->client, $this->id);
    }

    public function timeEntries(): TimeEntries
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access project time entries without a bound client context and project id.');
        }

        return new TimeEntries($this->client, $this->id);
    }

    public function close(): self
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot close a project without a bound client context and project id.');
        }

        return (new Projects($this->client))->patch($this->id)->close()->save();
    }

    public function reopen(): self
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot reopen a project without a bound client context and project id.');
        }

        return (new Projects($this->client))->patch($this->id)->reopen()->save();
    }
}
