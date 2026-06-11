<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Employee extends Model
{
    private ?string $employeeID = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
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
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }
    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }
    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'employeeID' => Field::string()->using('setEmployeeID'),
            'firstName' => Field::string()->using('setFirstName'),
            'lastName' => Field::string()->using('setLastName'),
            'email' => Field::string()->using('setEmailAddress'),
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

    /** @return ResourceCollection<\Sujip\Xero\Payroll\NZ\LeaveType\LeaveType> */
    public function leaveTypes(): ResourceCollection
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load leave types without a bound client context and employee id.');
        }
        return (new Employees($this->client))->leaveTypes($this->employeeID);
    }

    /** @return array<string, mixed> */
    public function leavePeriods(string $startDate, string $endDate): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load leave periods without a bound client context and employee id.');
        }
        return (new Employees($this->client))->leavePeriods($this->employeeID, $startDate, $endDate);
    }

    /** @return array<string, mixed> */
    public function leaveBalances(): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load leave balances without a bound client context and employee id.');
        }
        return (new Employees($this->client))->leaveBalances($this->employeeID);
    }

    /** @return array<string, mixed> */
    public function leaves(): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load employee leave records without a bound client context and employee id.');
        }
        return (new Employees($this->client))->leaves($this->employeeID);
    }

    /** @return array<string, mixed> */
    public function leave(string $leaveId): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load a specific employee leave record without a bound client context and employee id.');
        }
        return (new Employees($this->client))->leave($this->employeeID, $leaveId);
    }

    /** @return array<string, mixed> */
    public function paymentMethod(): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load employee payment methods without a bound client context and employee id.');
        }
        return (new Employees($this->client))->paymentMethod($this->employeeID);
    }

    /** @return array<string, mixed> */
    public function tax(): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load employee tax details without a bound client context and employee id.');
        }
        return (new Employees($this->client))->tax($this->employeeID);
    }

    /** @return array<string, mixed> */
    public function workingPatterns(): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load employee working patterns without a bound client context and employee id.');
        }
        return (new Employees($this->client))->workingPatterns($this->employeeID);
    }

    /** @return array<string, mixed> */
    public function workingPattern(string $workingPatternId): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load a single employee working pattern without a bound client context and employee id.');
        }
        return (new Employees($this->client))->workingPattern($this->employeeID, $workingPatternId);
    }

    public function leaveSetup(): LeaveSetupPayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee leave setup without a bound client context and employee id.');
        }
        return (new Employees($this->client))->leaveSetup($this->employeeID);
    }
    public function openingBalances(): OpeningBalancesPayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee opening balances without a bound client context and employee id.');
        }
        return (new Employees($this->client))->openingBalances($this->employeeID);
    }
    public function createEmployment(): EmploymentPayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee employment details without a bound client context and employee id.');
        }
        return (new Employees($this->client))->createEmployment($this->employeeID);
    }
    public function createLeave(): LeavePayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee leave without a bound client context and employee id.');
        }
        return (new Employees($this->client))->createLeave($this->employeeID);
    }
    public function createPaymentMethod(): PaymentMethodPayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee payment methods without a bound client context and employee id.');
        }
        return (new Employees($this->client))->createPaymentMethod($this->employeeID);
    }
    public function createSalaryAndWage(): SalaryAndWagePayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee salary and wages without a bound client context and employee id.');
        }
        return (new Employees($this->client))->createSalaryAndWage($this->employeeID);
    }
    public function createWorkingPattern(): WorkingPatternPayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee working patterns without a bound client context and employee id.');
        }
        return (new Employees($this->client))->createWorkingPattern($this->employeeID);
    }
    /** @return array<string, mixed> */
    public function salaryAndWages(?int $page = null): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load employee salary and wages without a bound client context and employee id.');
        }
        return (new Employees($this->client))->salaryAndWages($this->employeeID, $page ?? 1);
    }
    /** @return array<string, mixed> */
    public function salaryAndWage(string $salaryAndWagesId): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load a specific salary and wages record without a bound client context and employee id.');
        }
        return (new Employees($this->client))->salaryAndWage($this->employeeID, $salaryAndWagesId);
    }
}
