<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\LeaveApplication;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class LeaveApplications implements PaginatesResults, DefinesScopes
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
            broad: ['payroll.employees'],
            granular: ['payroll.employees.read', 'payroll.employees']
        );
    }

    public function modifiedSince(DateTimeInterface $date): self
    {
        $clone = clone $this;
        $clone->query['If-Modified-Since'] = $date->format(DateTimeInterface::ATOM);

        return $clone;
    }

    public function where(string $where): self
    {
        $clone = clone $this;
        $clone->query['where'] = $where;

        return $clone;
    }

    public function orderBy(string $order): self
    {
        $clone = clone $this;
        $clone->query['order'] = $order;

        return $clone;
    }

    /**
     * @return ResourceCollection<LeaveApplication>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/LeaveApplications')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $leaveApplication): LeaveApplication => $this->mapLeaveApplication($leaveApplication),
            Json::extractList($payload, 'LeaveApplications')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<LeaveApplication>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/1.0/LeaveApplications']);
    }

    public function find(string $leaveApplicationId): ?LeaveApplication
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/LeaveApplications/' . $leaveApplicationId)
            ->send();

        $payload = $response->json();
        $leaveApplication = Json::extractFirst($payload, 'LeaveApplications') ?? Json::extractObject($payload, 'LeaveApplication') ?: null;

        return $leaveApplication !== null ? $this->mapLeaveApplication($leaveApplication) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $leaveApplicationId): Payload
    {
        return (new Payload($this->client))->id($leaveApplicationId);
    }

    public function approve(string $leaveApplicationId): LeaveApplication
    {
        $response = $this->client
            ->post('/payroll.xro/1.0/LeaveApplications/' . $leaveApplicationId . '/approve')
            ->send();

        $payload = $response->json();
        $leaveApplication = Json::extractFirst($payload, 'LeaveApplications') ?? Json::extractObject($payload, 'LeaveApplication');

        return $leaveApplication !== [] ? $this->mapLeaveApplication($leaveApplication) : new LeaveApplication($this->client);
    }

    public function reject(string $leaveApplicationId): LeaveApplication
    {
        $response = $this->client
            ->post('/payroll.xro/1.0/LeaveApplications/' . $leaveApplicationId . '/reject')
            ->send();

        $payload = $response->json();
        $leaveApplication = Json::extractFirst($payload, 'LeaveApplications') ?? Json::extractObject($payload, 'LeaveApplication');

        return $leaveApplication !== [] ? $this->mapLeaveApplication($leaveApplication) : new LeaveApplication($this->client);
    }

    /**
     * @param array<string, mixed> $leaveApplication
     */
    public function mapLeaveApplication(array $leaveApplication): LeaveApplication
    {
        return (new LeaveApplication($this->client))->fill($leaveApplication);
    }
}
