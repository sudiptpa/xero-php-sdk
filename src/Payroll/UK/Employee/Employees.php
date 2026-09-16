<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
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
     * @return ResourceCollection<EarningsTemplate>
     */
    public function payTemplate(string $employeeId): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/PayTemplates')
            ->send();

        $payTemplate = Json::extractObject($response->json(), 'payTemplate');
        $items = array_map(
            fn (array $template): EarningsTemplate => $this->mapEarningsTemplate($template),
            Json::extractList($payTemplate, 'earningTemplates')
        );

        return new ResourceCollection($items);
    }

    public function createEarningsTemplate(string $employeeId, EarningsTemplate $template, ?string $idempotencyKey = null): EarningsTemplate
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/Employees/' . $employeeId . '/PayTemplates/earnings')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($template->toRequest())
            ->send()
            ->json();

        return $this->mapEarningsTemplate(Json::extractObject($payload, 'earningTemplate'));
    }

    public function updateEarningsTemplate(string $employeeId, string $payTemplateEarningId, EarningsTemplate $template, ?string $idempotencyKey = null): EarningsTemplate
    {
        $payload = $this->client
            ->put('/payroll.xro/2.0/Employees/' . $employeeId . '/PayTemplates/earnings/' . $payTemplateEarningId)
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($template->toRequest())
            ->send()
            ->json();

        return $this->mapEarningsTemplate(Json::extractObject($payload, 'earningTemplate'));
    }

    public function deleteEarningsTemplate(string $employeeId, string $payTemplateEarningId): bool
    {
        $this->client
            ->delete('/payroll.xro/2.0/Employees/' . $employeeId . '/PayTemplates/earnings/' . $payTemplateEarningId)
            ->send();

        return true;
    }

    /**
     * @param list<EarningsTemplate> $templates
     * @return ResourceCollection<EarningsTemplate>
     */
    public function createEarningsTemplates(string $employeeId, array $templates, ?string $idempotencyKey = null): ResourceCollection
    {
        $body = array_map(static fn (EarningsTemplate $template): array => $template->toRequest(), $templates);

        $payload = $this->client
            ->post('/payroll.xro/2.0/Employees/' . $employeeId . '/paytemplateearnings')
            ->contentTypeJson()
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withBody(Json::encodeList($body))
            ->send()
            ->json();

        $items = array_map(
            fn (array $template): EarningsTemplate => $this->mapEarningsTemplate($template),
            Json::extractList($payload, 'earningTemplates')
        );

        return new ResourceCollection($items);
    }

    public function openingBalances(string $employeeId): EmployeeOpeningBalances
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/ukopeningbalances')
            ->send()
            ->json();

        return $this->mapOpeningBalances(Json::extractObject($payload, 'openingBalances'));
    }

    public function createOpeningBalances(string $employeeId, EmployeeOpeningBalances $balances, ?string $idempotencyKey = null): EmployeeOpeningBalances
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/Employees/' . $employeeId . '/ukopeningbalances')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($balances->toRequest())
            ->send()
            ->json();

        return $this->mapOpeningBalances(Json::extractObject($payload, 'openingBalances'));
    }

    public function updateOpeningBalances(string $employeeId, EmployeeOpeningBalances $balances, ?string $idempotencyKey = null): EmployeeOpeningBalances
    {
        $payload = $this->client
            ->put('/payroll.xro/2.0/Employees/' . $employeeId . '/ukopeningbalances')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($balances->toRequest())
            ->send()
            ->json();

        return $this->mapOpeningBalances(Json::extractObject($payload, 'openingBalances'));
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
    public function statutoryLeaveBalance(string $employeeId, ?string $leaveType = null, ?string $asOfDate = null): array
    {
        $request = $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/StatutoryLeaveBalance');

        $query = array_filter([
            'LeaveType' => $leaveType,
            'AsOfDate' => $asOfDate,
        ], static fn (mixed $value): bool => $value !== null && $value !== '');

        if ($query !== []) {
            $request = $request->withQuery($query);
        }

        return $request
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
     * @return ResourceCollection<EmployeeLeaveType>
     */
    public function leaveTypes(string $employeeId): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/LeaveTypes')
            ->send()
            ->json();

        $items = array_map(
            fn (array $leaveType): EmployeeLeaveType => $this->mapLeaveType($leaveType),
            Json::extractList($payload, 'leaveTypes')
        );

        return new ResourceCollection($items);
    }

    public function createLeave(string $employeeId): LeavePayload
    {
        return new LeavePayload($this->client, $employeeId);
    }

    public function createLeaveType(string $employeeId): LeaveTypePayload
    {
        return new LeaveTypePayload($this->client, $employeeId);
    }

    /**
     * @param array<string, mixed> $leave
     * @return array<string, mixed>
     */
    public function updateLeave(string $employeeId, string $leaveId, array $leave, ?string $idempotencyKey = null): array
    {
        return $this->client
            ->put('/payroll.xro/2.0/Employees/' . $employeeId . '/Leave/' . $leaveId)
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($leave)
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function deleteLeave(string $employeeId, string $leaveId): array
    {
        return $this->client
            ->delete('/payroll.xro/2.0/Employees/' . $employeeId . '/Leave/' . $leaveId)
            ->send()
            ->json();
    }

    /**
     * @param array<string, mixed> $salary
     * @return array<string, mixed>
     */
    public function updateSalaryAndWage(string $employeeId, string $salaryAndWagesId, array $salary, ?string $idempotencyKey = null): array
    {
        return $this->client
            ->put('/payroll.xro/2.0/Employees/' . $employeeId . '/SalaryAndWages/' . $salaryAndWagesId)
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($salary)
            ->send()
            ->json();
    }

    public function deleteSalaryAndWage(string $employeeId, string $salaryAndWagesId): bool
    {
        $response = $this->client
            ->delete('/payroll.xro/2.0/Employees/' . $employeeId . '/SalaryAndWages/' . $salaryAndWagesId)
            ->send();

        return $response->status === 200;
    }

    /**
     * @param array<string, mixed> $employment
     * @return array<string, mixed>
     */
    public function createEmployment(string $employeeId, array $employment, ?string $idempotencyKey = null): array
    {
        return $this->client
            ->post('/payroll.xro/2.0/Employees/' . $employeeId . '/Employment')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($employment)
            ->send()
            ->json();
    }

    /**
     * @param array<string, mixed> $paymentMethod
     * @return array<string, mixed>
     */
    public function createPaymentMethod(string $employeeId, array $paymentMethod, ?string $idempotencyKey = null): array
    {
        return $this->client
            ->post('/payroll.xro/2.0/Employees/' . $employeeId . '/PaymentMethods')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($paymentMethod)
            ->send()
            ->json();
    }

    /**
     * @param array<string, mixed> $salary
     * @return array<string, mixed>
     */
    public function createSalaryAndWage(string $employeeId, array $salary, ?string $idempotencyKey = null): array
    {
        return $this->client
            ->post('/payroll.xro/2.0/Employees/' . $employeeId . '/SalaryAndWages')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($salary)
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
    public function leavePeriods(string $employeeId, string $startDate, string $endDate): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Employees/' . $employeeId . '/LeavePeriods')
            ->withQuery(['startDate' => $startDate, 'endDate' => $endDate])
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
    public function mapLeaveType(array $leaveType): EmployeeLeaveType
    {
        return (new EmployeeLeaveType())->fill($leaveType);
    }

    /**
     * @param array<string, mixed> $template
     */
    public function mapEarningsTemplate(array $template): EarningsTemplate
    {
        return (new EarningsTemplate())->fill($template);
    }

    /**
     * @param array<string, mixed> $balances
     */
    public function mapOpeningBalances(array $balances): EmployeeOpeningBalances
    {
        return (new EmployeeOpeningBalances())->fill($balances);
    }
}
