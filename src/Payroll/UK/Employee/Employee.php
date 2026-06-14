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
    private ?string $title = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $dateOfBirth = null;
    private ?string $emailAddress = null;
    private ?string $gender = null;
    private ?string $phoneNumber = null;
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $payrollCalendarID = null;
    private ?string $updatedDateUTC = null;
    private ?string $createdDateUTC = null;
    private ?string $niCategory = null;
    private ?string $nationalInsuranceNumber = null;
    private ?bool $isOffPayrollWorker = null;
    private ?Address $address = null;

    /**
     * @var list<NICategory>
     */
    private array $niCategories = [];

    /**
     * @var list<Contract>
     */
    private array $contracts = [];


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
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }
    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }
    public function setDateOfBirth(?string $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }
    public function getGender(): ?string
    {
        return $this->gender;
    }
    public function setGender(?string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }
    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }
    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }
    public function getPayrollCalendarID(): ?string
    {
        return $this->payrollCalendarID;
    }
    public function setPayrollCalendarID(?string $payrollCalendarID): self
    {
        $this->payrollCalendarID = $payrollCalendarID;
        return $this;
    }
    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }
    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;
        return $this;
    }
    public function getCreatedDateUTC(): ?string
    {
        return $this->createdDateUTC;
    }
    public function setCreatedDateUTC(?string $createdDateUTC): self
    {
        $this->createdDateUTC = $createdDateUTC;
        return $this;
    }
    public function getNiCategory(): ?string
    {
        return $this->niCategory;
    }
    public function setNiCategory(?string $niCategory): self
    {
        $this->niCategory = $niCategory;
        return $this;
    }
    public function getNationalInsuranceNumber(): ?string
    {
        return $this->nationalInsuranceNumber;
    }
    public function setNationalInsuranceNumber(?string $nationalInsuranceNumber): self
    {
        $this->nationalInsuranceNumber = $nationalInsuranceNumber;
        return $this;
    }
    public function getIsOffPayrollWorker(): ?bool
    {
        return $this->isOffPayrollWorker;
    }
    public function setIsOffPayrollWorker(?bool $isOffPayrollWorker): self
    {
        $this->isOffPayrollWorker = $isOffPayrollWorker;
        return $this;
    }
    public function getAddress(): ?Address
    {
        return $this->address;
    }
    public function setAddress(?Address $address): self
    {
        $this->address = $address;
        return $this;
    }
    /**
     * @return list<NICategory>
     */
    public function getNiCategories(): array
    {
        return $this->niCategories;
    }
    public function addNiCategory(NICategory $niCategory): self
    {
        $this->niCategories[] = $niCategory;
        return $this;
    }
    /**
     * @return list<Contract>
     */
    public function getContracts(): array
    {
        return $this->contracts;
    }
    public function addContract(Contract $contract): self
    {
        $this->contracts[] = $contract;
        return $this;
    }
    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'employeeID' => Field::string()->using('setEmployeeID'),
            'title' => Field::string()->using('setTitle'),
            'firstName' => Field::string()->using('setFirstName'),
            'lastName' => Field::string()->using('setLastName'),
            'dateOfBirth' => Field::string()->using('setDateOfBirth'),
            'email' => Field::string()->using('setEmailAddress'),
            'gender' => Field::string()->using('setGender'),
            'phoneNumber' => Field::string()->using('setPhoneNumber'),
            'startDate' => Field::string()->using('setStartDate'),
            'endDate' => Field::string()->using('setEndDate'),
            'payrollCalendarID' => Field::string()->using('setPayrollCalendarID'),
            'updatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'createdDateUTC' => Field::string()->using('setCreatedDateUTC'),
            'niCategory' => Field::string()->using('setNiCategory'),
            'nationalInsuranceNumber' => Field::string()->using('setNationalInsuranceNumber'),
            'isOffPayrollWorker' => Field::boolean()->using('setIsOffPayrollWorker'),
            'address' => Field::object(Address::class)->using('setAddress'),
            'niCategories' => Field::many(NICategory::class),
            'contracts' => Field::many(Contract::class),
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
    /** @return array<string, mixed> */
    public function statutoryLeaveBalance(?string $leaveType = null, ?string $asOfDate = null): array
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load statutory leave balance without a bound client context and employee id.');
        }
        return (new Employees($this->client))->statutoryLeaveBalance($this->employeeID, $leaveType, $asOfDate);
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
            throw new RuntimeException('Cannot load employee payment method without a bound client context and employee id.');
        }
        return (new Employees($this->client))->paymentMethod($this->employeeID);
    }
    /** @return ResourceCollection<EmployeeLeaveType> */
    public function leaveTypes(): ResourceCollection
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot load employee leave types without a bound client context and employee id.');
        }
        return (new Employees($this->client))->leaveTypes($this->employeeID);
    }
    public function createLeave(): LeavePayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee leave without a bound client context and employee id.');
        }
        return (new Employees($this->client))->createLeave($this->employeeID);
    }
    public function createLeaveType(): LeaveTypePayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create employee leave types without a bound client context and employee id.');
        }
        return (new Employees($this->client))->createLeaveType($this->employeeID);
    }
}
