<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\LeaveType;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

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
        $items = array_values(array_map(
            fn (array $leaveType): LeaveType => $this->mapLeaveType($leaveType),
            $payload['LeaveTypes'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<LeaveType>
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

        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/LeaveTypes']);
    }

    public function find(string $leaveTypeId): ?LeaveType
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/LeaveTypes/' . $leaveTypeId)
            ->send();

        $payload = $response->json();
        $leaveType = $payload['LeaveTypes'][0] ?? $payload['LeaveType'] ?? null;

        return is_array($leaveType) ? $this->mapLeaveType($leaveType) : null;
    }

    /**
     * @param array<string, mixed> $leaveType
     */
    public function mapLeaveType(array $leaveType): LeaveType
    {
        return (new LeaveType())
            ->setLeaveTypeID($leaveType['LeaveTypeID'] ?? null)
            ->setName($leaveType['Name'] ?? null)
            ->setIsActive(isset($leaveType['IsActive']) ? (bool) $leaveType['IsActive'] : null)
            ;
    }
}
