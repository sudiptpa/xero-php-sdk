<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\LeaveType;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class LeaveTypes implements PaginatesResults, DefinesScopes
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
            broad: ['payroll.settings'],
            granular: ['payroll.settings.read', 'payroll.settings']
        );
    }

    public function activeOnly(bool $activeOnly = true): self
    {
        $clone = clone $this;
        $clone->query['ActiveOnly'] = $activeOnly;

        return $clone;
    }

    /**
     * @return ResourceCollection<LeaveType>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/LeaveTypes')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $leaveType): LeaveType => $this->mapLeaveType($leaveType),
            Json::extractList($payload, 'leaveTypes')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<LeaveType>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/LeaveTypes']);
    }

    public function find(string $leaveTypeId): ?LeaveType
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/LeaveTypes/' . $leaveTypeId)
            ->send();

        $payload = $response->json();
        $leaveType = Json::extractFirst($payload, 'leaveTypes') ?? Json::extractObject($payload, 'leaveType') ?: null;

        return $leaveType !== null ? $this->mapLeaveType($leaveType) : null;
    }

    /**
     * @param array<string, mixed> $leaveType
     */
    public function mapLeaveType(array $leaveType): LeaveType
    {
        return (new LeaveType())->fill($leaveType);
    }
}
