<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Employee;

use RuntimeException;
use Sujip\Xero\Client;

final class Employee
{
    private ?string $employeeID = null;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $status = null;

    private ?string $emailAddress = null;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    public function firstName(string $firstName): self
    {
        return $this->setFirstName($firstName);
    }

    public function lastName(string $lastName): self
    {
        return $this->setLastName($lastName);
    }

    public function email(string $emailAddress): self
    {
        return $this->setEmailAddress($emailAddress);
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

        if ($this->status !== null) {
            $payload = $payload->status($this->status);
        }

        if ($this->emailAddress !== null) {
            $payload = $payload->email($this->emailAddress);
        }

        return $payload->save();
    }
}
