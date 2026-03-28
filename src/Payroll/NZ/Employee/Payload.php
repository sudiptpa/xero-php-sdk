<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $employeeId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $employeeId): self
    {
        $clone = clone $this;
        $clone->employeeId = $employeeId;

        return $clone;
    }

    public function firstName(string $firstName): self
    {
        $clone = clone $this;
        $clone->payload['FirstName'] = $firstName;

        return $clone;
    }

    public function lastName(string $lastName): self
    {
        $clone = clone $this;
        $clone->payload['LastName'] = $lastName;

        return $clone;
    }

    public function emailAddress(string $emailAddress): self
    {
        $clone = clone $this;
        $clone->payload['EmailAddress'] = $emailAddress;

        return $clone;
    }

    public function dateOfBirth(string $dateOfBirth): self
    {
        $clone = clone $this;
        $clone->payload['DateOfBirth'] = $dateOfBirth;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Employee
    {
        $request = $this->employeeId === null
            ? $this->client->post('/payroll.xro/2.0/Employees')
            : $this->client->post('/payroll.xro/2.0/Employees/' . $this->employeeId);

        if ($this->employeeId !== null) {
            $this->payload['EmployeeID'] = $this->employeeId;
        }

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['Employee' => $this->payload])
            ->send();

        $payload = $response->json();
        $employee = $payload['Employees'][0] ?? $payload['Employee'] ?? [];

        if (! is_array($employee)) {
            return new Employee($this->client);
        }

        return (new Employees($this->client))->mapEmployee($employee);
    }
}
