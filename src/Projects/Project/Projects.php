<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Project;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Projects implements PaginatesResults, DefinesScopes
{
    use HasPagination;

    /**
     * @var array<string, scalar|array<int, scalar>|null>
     */
    private array $query = [];

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['projects'],
            granular: ['projects.read', 'projects']
        );
    }

    public function ids(string ...$projectIds): self
    {
        $clone = clone $this;
        $clone->query['projectIds'] = implode(',', $projectIds);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->query['contactID'] = $contactId;

        return $clone;
    }

    public function states(string ...$states): self
    {
        $clone = clone $this;
        $clone->query['states'] = implode(',', array_map('strtoupper', $states));

        return $clone;
    }

    /**
     * @return ResourceCollection<Project>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/projects.xro/2.0/Projects')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(fn (array $project): Project => $this->mapProject($project), self::many($payload));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Project>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedResult
    {
        $builder = $this;

        if ($page !== null) {
            $builder = $builder->page($page);
        }

        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }

        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/projects.xro/2.0/Projects']);
    }

    public function find(string $projectId): ?Project
    {
        $response = $this->client
            ->get('/projects.xro/2.0/Projects/' . $projectId)
            ->send();

        $payload = $response->json();
        $project = self::single($payload);

        return is_array($project) ? $this->mapProject($project) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $projectId): Payload
    {
        return (new Payload($this->client))->id($projectId);
    }

    public function patch(string $projectId): Patch
    {
        return new Patch($this->client, $projectId);
    }

    /**
     * @param array<string, mixed> $payload
     * @return list<array<string, mixed>>
     */
    public static function many(array $payload): array
    {
        $items = $payload['Projects'] ?? $payload['projects'] ?? $payload['Items'] ?? $payload['items'] ?? [];

        return array_values(array_filter($items, 'is_array'));
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>|null
     */
    public static function single(array $payload): ?array
    {
        $item = $payload['Project'] ?? $payload['project'] ?? self::many($payload)[0] ?? null;

        return is_array($item) ? $item : null;
    }

    /**
     * @param array<string, mixed> $project
     */
    public function mapProject(array $project): Project
    {
        return (new Project($this->client))
            ->setProjectID($project['ProjectID'] ?? $project['ProjectId'] ?? null)
            ->setTitle($project['Title'] ?? null)
            ->setState($project['State'] ?? null)
            ->setContactID($project['Contact']['ContactID'] ?? $project['ContactID'] ?? null)
            ->setDeadlineUTC($project['DeadlineUTC'] ?? $project['DeadlineUtc'] ?? null);
    }
}
