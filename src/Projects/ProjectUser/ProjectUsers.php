<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\ProjectUser;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\ScopeRequirements;

final class ProjectUsers implements PaginatesResults, DefinesScopes
{
    use HasPagination;

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

    /**
     * @return ResourceCollection<ProjectUser>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/projects.xro/2.0/ProjectsUsers')
            ->withQuery($this->paginationQuery())
            ->send();

        $payload = $response->json();
        $items = Json::extractList($payload, 'items');

        return new ResourceCollection(array_map(
            fn (array $user): ProjectUser => $this->mapProjectUser($user),
            $items
        ));
    }

    /**
     * @return PaginatedCollection<ProjectUser>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/projects.xro/2.0/ProjectsUsers']);
    }

    /**
     * @param array<string, mixed> $user
     */
    public function mapProjectUser(array $user): ProjectUser
    {
        return (new ProjectUser())->fill($user);
    }
}
