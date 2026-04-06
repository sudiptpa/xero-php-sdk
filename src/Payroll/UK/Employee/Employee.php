<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

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
    private ?string $status = null;


    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getEmployeeID(): ?string { return $this->employeeID; }
    public function setEmployeeID(?string $employeeID): self { $this->employeeID = $employeeID; return $this; }
    public function getFirstName(): ?string { return $this->firstName; }
    public function setFirstName(?string $firstName): self { $this->firstName = $firstName; return $this; }
    public function getLastName(): ?string { return $this->lastName; }
    public function setLastName(?string $lastName): self { $this->lastName = $lastName; return $this; }
    public function getEmailAddress(): ?string { return $this->emailAddress; }
    public function setEmailAddress(?string $emailAddress): self { $this->emailAddress = $emailAddress; return $this; }
    public function getStatus(): ?string { return $this->status; }
    public function setStatus(?string $status): self { $this->status = $status; return $this; }

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
        if ($this->employeeID !== null) { $payload = $payload->id($this->employeeID); }
        if ($this->firstName !== null) { $payload = $payload->firstName($this->firstName); }
        if ($this->lastName !== null) { $payload = $payload->lastName($this->lastName); }
        if ($this->emailAddress !== null) { $payload = $payload->emailAddress($this->emailAddress); }
        return $payload->save();
    }

    /** @return array<string, mixed> */
    public function leaveBalances(): array
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot load leave balances without a bound client context and employee id.'); }
        return (new Employees($this->client))->leaveBalances($this->employeeID);
    }
    /** @return array<string, mixed> */
    public function statutoryLeaveBalance(?string $leaveType = null, ?string $asOfDate = null): array
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot load statutory leave balance without a bound client context and employee id.'); }
        return (new Employees($this->client))->statutoryLeaveBalance($this->employeeID, $leaveType, $asOfDate);
    }
    /** @return array<string, mixed> */
    public function leaves(): array
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot load employee leave records without a bound client context and employee id.'); }
        return (new Employees($this->client))->leaves($this->employeeID);
    }
    /** @return array<string, mixed> */
    public function leave(string $leaveId): array
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot load a specific employee leave record without a bound client context and employee id.'); }
        return (new Employees($this->client))->leave($this->employeeID, $leaveId);
    }
    /** @return array<string, mixed> */
    public function paymentMethod(): array
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot load employee payment method without a bound client context and employee id.'); }
        return (new Employees($this->client))->paymentMethod($this->employeeID);
    }
    /** @return array<string, mixed> */
    public function employment(): array
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot load employee employment details without a bound client context and employee id.'); }
        return (new Employees($this->client))->employment($this->employeeID);
    }
    /** @return ResourceCollection<LeaveType> */
    public function leaveTypes(): ResourceCollection
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot load employee leave types without a bound client context and employee id.'); }
        return (new Employees($this->client))->leaveTypes($this->employeeID);
    }
    public function createLeave(): LeavePayload
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot create employee leave without a bound client context and employee id.'); }
        return (new Employees($this->client))->createLeave($this->employeeID);
    }
    public function createLeaveType(): LeaveTypePayload
    {
        if ($this->client === null || $this->employeeID === null) { throw new RuntimeException('Cannot create employee leave types without a bound client context and employee id.'); }
        return (new Employees($this->client))->createLeaveType($this->employeeID);
    }
}
