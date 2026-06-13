<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Project;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Json;
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
     * @return PaginatedCollection<Project>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedCollection
    {
        $builder = $this;

        if ($page !== null) {
            $builder = $builder->page($page);
        }

        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/projects.xro/2.0/Projects']);
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
        return Json::extractList($payload, 'Projects')
            ?: Json::extractList($payload, 'projects')
            ?: Json::extractList($payload, 'Items')
            ?: Json::extractList($payload, 'items');
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>|null
     */
    public static function single(array $payload): ?array
    {
        if (array_key_exists('projectId', $payload)) {
            return $payload;
        }

        return Json::extractObject($payload, 'Project')
            ?: Json::extractObject($payload, 'project')
            ?: self::many($payload)[0]
            ?? null;
    }

    /**
     * @param array<string, mixed> $project
     */
    public function mapProject(array $project): Project
    {
        return (new Project($this->client))->fill($project);
    }
}
