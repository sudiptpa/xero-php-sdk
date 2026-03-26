<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;
use Sujip\Xero\Payroll\NZ\LeaveType\LeaveType;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ScopeRequirements;

final class Employees implements PaginatesResults, DefinesScopes
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

    public function filter(string $filter): self
    {
        $clone = clone $this;
        $clone->query['filter'] = $filter;

        return $clone;
    }

    /**
     * @return ResourceCollection<Employee>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Employees')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $employee): Employee => Employee::fromArray($employee, $this->client),
            $payload['Employees'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Employee>
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

        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/Employees']);
    }

    public function find(string $employeeId): ?Employee
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId)
            ->send();

        $payload = $response->json();
        $employee = $payload['Employees'][0] ?? $payload['Employee'] ?? null;

        return is_array($employee) ? Employee::fromArray($employee, $this->client) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $employeeId): Payload
    {
        return (new Payload($this->client))->id($employeeId);
    }

    /**
     * @return ResourceCollection<LeaveType>
     */
    public function leaveTypes(string $employeeId): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/LeaveTypes')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $leaveType): LeaveType => LeaveType::fromArray($leaveType),
            $payload['LeaveTypes'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return array<string, mixed>
     */
    public function leavePeriods(string $employeeId, string $startDate, string $endDate): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/LeavePeriods')
            ->withQuery([
                'startDate' => $startDate,
                'endDate' => $endDate,
            ])
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function leaveBalances(string $employeeId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/LeaveBalances')
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function leaves(string $employeeId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/Leave')
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function leave(string $employeeId, string $leaveId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/Leave/' . $leaveId)
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function paymentMethod(string $employeeId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/PaymentMethods')
            ->send()
            ->json();
    }
}
