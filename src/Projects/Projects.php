<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects;

use Sujip\Xero\Client;
use Sujip\Xero\Projects\Project\Payload as ProjectPayload;
use Sujip\Xero\Projects\Project\Patch as ProjectPatch;
use Sujip\Xero\Projects\Project\Project;
use Sujip\Xero\Projects\Project\Projects as ProjectsResource;
use Sujip\Xero\Projects\ProjectUser\ProjectUsers;
use Sujip\Xero\Projects\Task\Tasks;
use Sujip\Xero\Projects\TimeEntry\TimeEntries;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Projects implements DefinesScopes
{
    private ProjectsResource $projects;

    public function __construct(
        private Client $client
    ) {
        $this->projects = new ProjectsResource($client);
    }

    public function scopes(): ScopeRequirements
    {
        return $this->projects()->scopes();
    }

    public function page(int $page): self
    {
        $clone = clone $this;
        $clone->projects = $this->projects->page($page);

        return $clone;
    }

    public function perPage(int $perPage): self
    {
        $clone = clone $this;
        $clone->projects = $this->projects->perPage($perPage);

        return $clone;
    }

    public function ids(string ...$projectIds): self
    {
        $clone = clone $this;
        $clone->projects = $this->projects->ids(...$projectIds);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->projects = $this->projects->contact($contactId);

        return $clone;
    }

    public function states(string ...$states): self
    {
        $clone = clone $this;
        $clone->projects = $this->projects->states(...$states);

        return $clone;
    }

    /**
     * @return ResourceCollection<Project>
     */
    public function get(): ResourceCollection
    {
        return $this->projects()->get();
    }

    /**
     * @return PaginatedCollection<Project>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedCollection
    {
        return $this->projects()->paginate($page, $perPage);
    }

    public function find(string $projectId): ?Project
    {
        return $this->projects()->find($projectId);
    }

    public function create(): ProjectPayload
    {
        return $this->projects()->create();
    }

    public function update(string $projectId): ProjectPayload
    {
        return $this->projects()->update($projectId);
    }

    public function patch(string $projectId): ProjectPatch
    {
        return $this->projects()->patch($projectId);
    }

    public function users(): ProjectUsers
    {
        return new ProjectUsers($this->client);
    }

    public function tasks(string $projectId): Tasks
    {
        return new Tasks($this->client, $projectId);
    }

    public function timeEntries(string $projectId): TimeEntries
    {
        return new TimeEntries($this->client, $projectId);
    }

    public function projects(): ProjectsResource
    {
        return $this->projects;
    }

    public function client(): Client
    {
        return $this->client;
    }
}
