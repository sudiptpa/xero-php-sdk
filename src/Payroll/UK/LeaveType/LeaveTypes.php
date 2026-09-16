<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\LeaveType;

use Sujip\Xero\Client;
use Sujip\Xero\Concerns\HasPagination;
use Sujip\Xero\Contracts\DefinesScopes;
use Sujip\Xero\Contracts\PaginatesResults;
use Sujip\Xero\Support\Headers;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class LeaveTypes implements PaginatesResults, DefinesScopes
{
    use HasPagination;

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

    /**
     * @return ResourceCollection<LeaveType>
     */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/LeaveTypes')
            ->withQuery($this->paginationQuery())
            ->send()
            ->json();

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

    /**
     * @param array<string, mixed> $leaveType
     */
    public function create(array $leaveType, ?string $idempotencyKey = null): LeaveType
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/LeaveTypes')
            ->withHeaders(Headers::idempotency($idempotencyKey))
            ->withJson($leaveType)
            ->send()
            ->json();

        $leaveType = Json::extractObject($payload, 'leaveType');

        return $leaveType !== [] ? $this->mapLeaveType($leaveType) : new LeaveType();
    }

    /**
     * @param array<string, mixed> $leaveType
     */
    public function mapLeaveType(array $leaveType): LeaveType
    {
        return (new LeaveType())->fill($leaveType);
    }
}
