<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU;

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
        $clone->payload['FirstName'] = $firstName;

        return $clone;
    }

    public function lastName(string $lastName): self
    {
        $clone = clone $this;
        $clone->payload['LastName'] = $lastName;

        return $clone;
    }

    public function email(string $email): self
    {
        $clone = clone $this;
        $clone->payload['Email'] = $email;

        return $clone;
    }

    public function dateOfBirth(string $dateOfBirth): self
    {
        $clone = clone $this;
        $clone->payload['DateOfBirth'] = $dateOfBirth;

        return $clone;
    }

    public function homeAddress(
        string $addressLine1,
        string $city,
        ?string $region = null,
        ?string $postalCode = null,
        ?string $country = null,
        ?string $addressLine2 = null,
    ): self {
        $clone = clone $this;
        $clone->payload['HomeAddress'] = array_filter([
            'AddressLine1' => $addressLine1,
            'AddressLine2' => $addressLine2,
            'City' => $city,
            'Region' => $region,
            'PostalCode' => $postalCode,
            'Country' => $country,
        ], static fn (mixed $value): bool => $value !== null);

        return $clone;
    }

    /** @param array<string, mixed> $taxDeclaration */
    public function taxDeclaration(array $taxDeclaration): self
    {
        $clone = clone $this;
        $clone->payload['TaxDeclaration'] = $taxDeclaration;

        return $clone;
    }

    /** @param list<array<string, mixed>> $bankAccounts */
    public function bankAccounts(array $bankAccounts): self
    {
        $clone = clone $this;
        $clone->payload['BankAccounts'] = $bankAccounts;

        return $clone;
    }

    /** @param array<string, mixed> $payTemplate */
    public function payTemplate(array $payTemplate): self
    {
        $clone = clone $this;
        $clone->payload['PayTemplate'] = $payTemplate;

        return $clone;
    }

    /** @param array<string, mixed> $openingBalances */
    public function openingBalances(array $openingBalances): self
    {
        $clone = clone $this;
        $clone->payload['OpeningBalances'] = $openingBalances;

        return $clone;
    }

    /** @param list<array<string, mixed>> $superMemberships */
    public function superMemberships(array $superMemberships): self
    {
        $clone = clone $this;
        $clone->payload['SuperMemberships'] = $superMemberships;

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
            ? $this->client->post('/payroll.xro/1.0/Employees')
            : $this->client->post('/payroll.xro/1.0/Employees/' . $this->employeeId);

        if ($this->employeeId !== null) {
            $this->payload['EmployeeID'] = $this->employeeId;
        }

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->contentTypeJson()
            ->withBody(Json::encodeList([$this->payload]))
            ->send();

        $payload = $response->json();
        $employee = Json::extractFirst($payload, 'Employees') ?? Json::extractObject($payload, 'Employee');

        if ($employee === []) {
            return new Employee($this->client);
        }

        return (new Employees($this->client))->mapEmployee($employee);
    }
}
