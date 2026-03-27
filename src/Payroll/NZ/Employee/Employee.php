<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

final readonly class Employee
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $emailAddress,
        public ?string $status,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['EmployeeID'] ?? null,
            $payload['FirstName'] ?? null,
            $payload['LastName'] ?? null,
            $payload['EmailAddress'] ?? null,
            $payload['Status'] ?? null,
            $payload,
            $client
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an employee without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
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

    /**
     * @return ResourceCollection<\Sujip\Xero\Payroll\NZ\LeaveType\LeaveType>
     */
    public function leaveTypes(): ResourceCollection
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load leave types without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leaveTypes($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function leavePeriods(string $startDate, string $endDate): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load leave periods without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leavePeriods($this->id, $startDate, $endDate);
    }

    /**
     * @return array<string, mixed>
     */
    public function leaveBalances(): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load leave balances without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leaveBalances($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function leaves(): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load employee leave records without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leaves($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function leave(string $leaveId): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load a specific employee leave record without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leave($this->id, $leaveId);
    }

    /**
     * @return array<string, mixed>
     */
    public function paymentMethod(): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load employee payment methods without a bound client context and employee id.');
        }

        return (new Employees($this->client))->paymentMethod($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function tax(): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load employee tax details without a bound client context and employee id.');
        }

        return (new Employees($this->client))->tax($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function workingPatterns(): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load employee working patterns without a bound client context and employee id.');
        }

        return (new Employees($this->client))->workingPatterns($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function workingPattern(string $workingPatternId): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load a single employee working pattern without a bound client context and employee id.');
        }

        return (new Employees($this->client))->workingPattern($this->id, $workingPatternId);
    }

    public function leaveSetup(): LeaveSetupPayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot create employee leave setup without a bound client context and employee id.');
        }

        return (new Employees($this->client))->leaveSetup($this->id);
    }

    public function openingBalances(): OpeningBalancesPayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot create employee opening balances without a bound client context and employee id.');
        }

        return (new Employees($this->client))->openingBalances($this->id);
    }

    public function createEmployment(): EmploymentPayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot create employee employment details without a bound client context and employee id.');
        }

        return (new Employees($this->client))->createEmployment($this->id);
    }

    public function createLeave(): LeavePayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot create employee leave without a bound client context and employee id.');
        }

        return (new Employees($this->client))->createLeave($this->id);
    }

    public function createPaymentMethod(): PaymentMethodPayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot create employee payment methods without a bound client context and employee id.');
        }

        return (new Employees($this->client))->createPaymentMethod($this->id);
    }

    public function createSalaryAndWage(): SalaryAndWagePayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot create employee salary and wage records without a bound client context and employee id.');
        }

        return (new Employees($this->client))->createSalaryAndWage($this->id);
    }

    public function createWorkingPattern(): WorkingPatternPayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot create employee working patterns without a bound client context and employee id.');
        }

        return (new Employees($this->client))->createWorkingPattern($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function employment(): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load employee employment details without a bound client context and employee id.');
        }

        return (new Employees($this->client))->employment($this->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function salaryAndWages(int $page = 1): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load employee salary and wages without a bound client context and employee id.');
        }

        return (new Employees($this->client))->salaryAndWages($this->id, $page);
    }

    /**
     * @return array<string, mixed>
     */
    public function salaryAndWage(string $salaryAndWagesId): array
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load a single employee salary and wages record without a bound client context and employee id.');
        }

        return (new Employees($this->client))->salaryAndWage($this->id, $salaryAndWagesId);
    }
}
