<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Concerns\HasPagination;

final class Employees implements PaginatesResults
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
     * @return ResourceCollection<Employee>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/Employees')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(fn (array $employee): Employee => $this->mapEmployee($employee), $payload['Employees'] ?? []));

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

        $items = $builder->get();

        return new PaginatedResult(
            $items,
            $builder->currentPage(),
            $builder->currentPerPage(),
            [
                'path' => '/payroll.xro/1.0/Employees',
            ]
        );
    }

    public function find(string $employeeId): ?Employee
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/Employees/' . $employeeId)
            ->send();

        $payload = $response->json();
        $employee = $payload['Employees'][0] ?? $payload['Employee'] ?? null;

        return is_array($employee) ? $this->mapEmployee($employee) : null;
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
     * @return array<string, mixed>
     */
    public function leaveBalances(string $employeeId): array
    {
        return $this->client
            ->get('/payroll.xro/1.0/Employees/' . $employeeId . '/LeaveBalances')
            ->send()
            ->json();
    }

    /**
     * @param array<string, mixed> $employee
     */
    public function mapEmployee(array $employee): Employee
    {
        return (new Employee($this->client))
            ->setEmployeeID($employee['EmployeeID'] ?? null)
            ->setFirstName($employee['FirstName'] ?? null)
            ->setLastName($employee['LastName'] ?? null)
            ->setEmailAddress($employee['EmailAddress'] ?? null)
            ->setStatus($employee['Status'] ?? null)
            ;
    }
}
