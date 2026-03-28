<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Employee;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Employees implements DefinesScopes
{
    use BuildsQueries;
    use InteractsWithBindings;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['accounting.settings'],
            granular: ['accounting.settings.read', 'accounting.settings']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<Employee>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Employees')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $employee): Employee => $this->mapEmployee($employee),
            $payload['Employees'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $employeeId): ?Employee
    {
        $response = $this->client
            ->get('/api.xro/2.0/Employees/' . $employeeId)
            ->send();

        $payload = $response->json();
        $employee = $payload['Employees'][0] ?? null;

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
     * @param array<string, mixed> $payload
     */
    public function mapEmployee(array $payload): Employee
    {
        return (new Employee($this->client))
            ->setEmployeeID(isset($payload['EmployeeID']) ? (string) $payload['EmployeeID'] : null)
            ->setFirstName(isset($payload['FirstName']) ? (string) $payload['FirstName'] : null)
            ->setLastName(isset($payload['LastName']) ? (string) $payload['LastName'] : null)
            ->setStatus(isset($payload['Status']) ? (string) $payload['Status'] : null)
            ->setEmailAddress(isset($payload['EmailAddress']) ? (string) $payload['EmailAddress'] : null)
            ;
    }
}
