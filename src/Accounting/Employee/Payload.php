<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Employee;

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

    public function email(string $emailAddress): self
    {
        $clone = clone $this;
        $clone->payload['EmailAddress'] = $emailAddress;

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->payload['Status'] = $status;

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
        if ($this->employeeId !== null) {
            $this->payload['EmployeeID'] = $this->employeeId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/Employees')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['Employees' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $employee = $payload['Employees'][0] ?? [];

        return (new Employees($this->client))
            ->mapEmployee(is_array($employee) ? $employee : []);
    }
}
