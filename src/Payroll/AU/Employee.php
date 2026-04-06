<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Payroll\AU\LeaveApplication\Payload as LeaveApplicationPayload;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Employee extends Model
{
    private ?string $employeeID = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $emailAddress = null;
    private ?string $status = null;


    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getEmployeeID(): ?string
    {
        return $this->employeeID;
    }

    public function setEmployeeID(?string $employeeID): self
    {
        $this->employeeID = $employeeID;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'EmployeeID' => Field::string()->using('setEmployeeID'),
            'FirstName' => Field::string()->using('setFirstName'),
            'LastName' => Field::string()->using('setLastName'),
            'EmailAddress' => Field::string()->using('setEmailAddress'),
            'Status' => Field::string()->using('setStatus'),
        ];
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an employee without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->employeeID !== null) {
            $payload = $payload->id($this->employeeID);
        }
        if ($this->firstName !== null) {
            $payload = $payload->firstName($this->firstName);
        }
        if ($this->lastName !== null) {
            $payload = $payload->lastName($this->lastName);
        }
        if ($this->emailAddress !== null) {
            $payload = $payload->emailAddress($this->emailAddress);
        }

        return $payload->save();
    }

    /** @return array<string, mixed> */
    public function leaveBalances(): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load leave balances without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leaveBalances($this->employeeID);
    }

    public function createLeaveApplication(): LeaveApplicationPayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create a leave application without a bound client context and employee id.');
        }

        return (new LeaveApplicationPayload($this->client))->employee($this->employeeID);
    }
}
