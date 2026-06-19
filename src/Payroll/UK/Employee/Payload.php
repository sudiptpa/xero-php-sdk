<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

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
        $clone->payload['firstName'] = $firstName;

        return $clone;
    }

    public function lastName(string $lastName): self
    {
        $clone = clone $this;
        $clone->payload['lastName'] = $lastName;

        return $clone;
    }

    public function emailAddress(string $emailAddress): self
    {
        $clone = clone $this;
        $clone->payload['email'] = $emailAddress;

        return $clone;
    }

    public function dateOfBirth(string $dateOfBirth): self
    {
        $clone = clone $this;
        $clone->payload['dateOfBirth'] = $dateOfBirth;

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
            : $this->client->put('/payroll.xro/2.0/Employees/' . $this->employeeId);

        if ($this->employeeId !== null) {
            $this->payload['employeeID'] = $this->employeeId;
        }

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send();

        $payload = $response->json();
        $employee = Json::extractFirst($payload, 'employees') ?? Json::extractObject($payload, 'employee');

        if ($employee === []) {
            return new Employee($this->client);
        }

        return (new Employees($this->client))->mapEmployee($employee);
    }
}
