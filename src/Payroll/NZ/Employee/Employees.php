<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;
use Sujip\Xero\Payroll\NZ\LeaveType\LeaveType;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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
        $items = array_map(fn (array $employee): Employee => $this->mapEmployee($employee), Json::extractList($payload, 'employees'));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Employee>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/Employees']);
    }

    public function find(string $employeeId): ?Employee
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId)
            ->send();

        $payload = $response->json();
        $employee = Json::extractFirst($payload, 'employees') ?? Json::extractObject($payload, 'employee') ?: null;

        return $employee !== null ? $this->mapEmployee($employee) : null;
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
        $items = array_map(
            fn (array $leaveType): LeaveType => $this->mapLeaveType($leaveType),
            Json::extractList($payload, 'LeaveTypes')
        );

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

    /**
     * @return array<string, mixed>
     */
    public function tax(string $employeeId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/Tax')
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function workingPatterns(string $employeeId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/Working-Patterns')
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function workingPattern(string $employeeId, string $workingPatternId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/Working-Patterns/' . $workingPatternId)
            ->send()
            ->json();
    }

    public function leaveSetup(string $employeeId): LeaveSetupPayload
    {
        return new LeaveSetupPayload($this->client, $employeeId);
    }

    public function openingBalances(string $employeeId): OpeningBalancesPayload
    {
        return new OpeningBalancesPayload($this->client, $employeeId);
    }

    public function createEmployment(string $employeeId): EmploymentPayload
    {
        return new EmploymentPayload($this->client, $employeeId);
    }

    public function createLeave(string $employeeId): LeavePayload
    {
        return new LeavePayload($this->client, $employeeId);
    }

    public function createPaymentMethod(string $employeeId): PaymentMethodPayload
    {
        return new PaymentMethodPayload($this->client, $employeeId);
    }

    public function createSalaryAndWage(string $employeeId): SalaryAndWagePayload
    {
        return new SalaryAndWagePayload($this->client, $employeeId);
    }

    public function createWorkingPattern(string $employeeId): WorkingPatternPayload
    {
        return new WorkingPatternPayload($this->client, $employeeId);
    }

    /**
     * @return array<string, mixed>
     */
    public function employment(string $employeeId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/Employment')
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function salaryAndWages(string $employeeId, int $page = 1): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/SalaryAndWages')
            ->withQuery(['page' => $page])
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function salaryAndWage(string $employeeId, string $salaryAndWagesId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/SalaryAndWages/' . $salaryAndWagesId)
            ->send()
            ->json();
    }

    /**
     * @param array<string, mixed> $employee
     */
    public function mapEmployee(array $employee): Employee
    {
        return (new Employee($this->client))->fill($employee);
    }

    /**
     * @param array<string, mixed> $leaveType
     */
    public function mapLeaveType(array $leaveType): LeaveType
    {
        return (new LeaveType())->fill($leaveType);
    }
}
