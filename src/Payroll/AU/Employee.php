<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Payroll\AU\Employee\HomeAddress;
use Sujip\Xero\Payroll\AU\Employee\OpeningBalances;
use Sujip\Xero\Payroll\AU\Employee\PayTemplate;
use Sujip\Xero\Payroll\AU\Employee\TaxDeclaration;
use Sujip\Xero\Payroll\AU\LeaveApplication\Payload as LeaveApplicationPayload;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class Employee extends Model
{
    private ?string $employeeID = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?HomeAddress $homeAddress = null;
    private ?string $dateOfBirth = null;
    private ?string $startDate = null;
    private ?string $title = null;
    private ?string $middleNames = null;
    private ?string $email = null;
    private ?string $gender = null;
    private ?string $phone = null;
    private ?string $mobile = null;
    private ?string $twitterUserName = null;
    private ?bool $isAuthorisedToApproveLeave = null;
    private ?bool $isAuthorisedToApproveTimesheets = null;
    private ?string $jobTitle = null;
    private ?string $classification = null;
    private ?string $ordinaryEarningsRateID = null;
    private ?string $payrollCalendarID = null;
    private ?string $employeeGroupName = null;
    private ?string $terminationDate = null;
    private ?string $terminationReason = null;
    private ?PayTemplate $payTemplate = null;
    private ?OpeningBalances $openingBalances = null;
    private ?TaxDeclaration $taxDeclaration = null;
    private ?string $incomeType = null;
    private ?string $employmentType = null;
    private ?string $countryOfResidence = null;
    private ?bool $isSTP2Qualified = null;
    private ?string $status = null;
    private ?string $updatedDateUTC = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

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

    public function getHomeAddress(): ?HomeAddress
    {
        return $this->homeAddress;
    }

    public function setHomeAddress(?HomeAddress $homeAddress): self
    {
        $this->homeAddress = $homeAddress;
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

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;
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

    public function getMiddleNames(): ?string
    {
        return $this->middleNames;
    }

    public function setMiddleNames(?string $middleNames): self
    {
        $this->middleNames = $middleNames;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function getTwitterUserName(): ?string
    {
        return $this->twitterUserName;
    }

    public function setTwitterUserName(?string $twitterUserName): self
    {
        $this->twitterUserName = $twitterUserName;
        return $this;
    }

    public function getIsAuthorisedToApproveLeave(): ?bool
    {
        return $this->isAuthorisedToApproveLeave;
    }

    public function setIsAuthorisedToApproveLeave(?bool $isAuthorisedToApproveLeave): self
    {
        $this->isAuthorisedToApproveLeave = $isAuthorisedToApproveLeave;
        return $this;
    }

    public function getIsAuthorisedToApproveTimesheets(): ?bool
    {
        return $this->isAuthorisedToApproveTimesheets;
    }

    public function setIsAuthorisedToApproveTimesheets(?bool $isAuthorisedToApproveTimesheets): self
    {
        $this->isAuthorisedToApproveTimesheets = $isAuthorisedToApproveTimesheets;
        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    public function getClassification(): ?string
    {
        return $this->classification;
    }

    public function setClassification(?string $classification): self
    {
        $this->classification = $classification;
        return $this;
    }

    public function getOrdinaryEarningsRateID(): ?string
    {
        return $this->ordinaryEarningsRateID;
    }

    public function setOrdinaryEarningsRateID(?string $ordinaryEarningsRateID): self
    {
        $this->ordinaryEarningsRateID = $ordinaryEarningsRateID;
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

    public function getEmployeeGroupName(): ?string
    {
        return $this->employeeGroupName;
    }

    public function setEmployeeGroupName(?string $employeeGroupName): self
    {
        $this->employeeGroupName = $employeeGroupName;
        return $this;
    }

    public function getTerminationDate(): ?string
    {
        return $this->terminationDate;
    }

    public function setTerminationDate(?string $terminationDate): self
    {
        $this->terminationDate = $terminationDate;
        return $this;
    }

    public function getTerminationReason(): ?string
    {
        return $this->terminationReason;
    }

    public function setTerminationReason(?string $terminationReason): self
    {
        $this->terminationReason = $terminationReason;
        return $this;
    }

    public function getPayTemplate(): ?PayTemplate
    {
        return $this->payTemplate;
    }

    public function setPayTemplate(?PayTemplate $payTemplate): self
    {
        $this->payTemplate = $payTemplate;
        return $this;
    }

    public function getOpeningBalances(): ?OpeningBalances
    {
        return $this->openingBalances;
    }

    public function setOpeningBalances(?OpeningBalances $openingBalances): self
    {
        $this->openingBalances = $openingBalances;
        return $this;
    }

    public function getTaxDeclaration(): ?TaxDeclaration
    {
        return $this->taxDeclaration;
    }

    public function setTaxDeclaration(?TaxDeclaration $taxDeclaration): self
    {
        $this->taxDeclaration = $taxDeclaration;
        return $this;
    }

    public function getIncomeType(): ?string
    {
        return $this->incomeType;
    }

    public function setIncomeType(?string $incomeType): self
    {
        $this->incomeType = $incomeType;
        return $this;
    }

    public function getEmploymentType(): ?string
    {
        return $this->employmentType;
    }

    public function setEmploymentType(?string $employmentType): self
    {
        $this->employmentType = $employmentType;
        return $this;
    }

    public function getCountryOfResidence(): ?string
    {
        return $this->countryOfResidence;
    }

    public function setCountryOfResidence(?string $countryOfResidence): self
    {
        $this->countryOfResidence = $countryOfResidence;
        return $this;
    }

    public function getIsSTP2Qualified(): ?bool
    {
        return $this->isSTP2Qualified;
    }

    public function setIsSTP2Qualified(?bool $isSTP2Qualified): self
    {
        $this->isSTP2Qualified = $isSTP2Qualified;
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

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;
        return $this;
    }

    /**
     * @return list<ValidationError>
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function addValidationError(ValidationError $validationError): self
    {
        $this->validationErrors[] = $validationError;
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
            'HomeAddress' => Field::object(HomeAddress::class)->using('setHomeAddress'),
            'DateOfBirth' => Field::string()->using('setDateOfBirth'),
            'StartDate' => Field::string()->using('setStartDate'),
            'Title' => Field::string()->using('setTitle'),
            'MiddleNames' => Field::string()->using('setMiddleNames'),
            'Email' => Field::string()->using('setEmail'),
            'Gender' => Field::string()->using('setGender'),
            'Phone' => Field::string()->using('setPhone'),
            'Mobile' => Field::string()->using('setMobile'),
            'TwitterUserName' => Field::string()->using('setTwitterUserName'),
            'IsAuthorisedToApproveLeave' => Field::boolean()->using('setIsAuthorisedToApproveLeave'),
            'IsAuthorisedToApproveTimesheets' => Field::boolean()->using('setIsAuthorisedToApproveTimesheets'),
            'JobTitle' => Field::string()->using('setJobTitle'),
            'Classification' => Field::string()->using('setClassification'),
            'OrdinaryEarningsRateID' => Field::string()->using('setOrdinaryEarningsRateID'),
            'PayrollCalendarID' => Field::string()->using('setPayrollCalendarID'),
            'EmployeeGroupName' => Field::string()->using('setEmployeeGroupName'),
            'TerminationDate' => Field::string()->using('setTerminationDate'),
            'TerminationReason' => Field::string()->using('setTerminationReason'),
            'PayTemplate' => Field::object(PayTemplate::class)->using('setPayTemplate'),
            'OpeningBalances' => Field::object(OpeningBalances::class)->using('setOpeningBalances'),
            'TaxDeclaration' => Field::object(TaxDeclaration::class)->using('setTaxDeclaration'),
            'IncomeType' => Field::string()->using('setIncomeType'),
            'EmploymentType' => Field::string()->using('setEmploymentType'),
            'CountryOfResidence' => Field::string()->using('setCountryOfResidence'),
            'IsSTP2Qualified' => Field::boolean()->using('setIsSTP2Qualified'),
            'Status' => Field::string()->using('setStatus'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'ValidationErrors' => Field::many(ValidationError::class),
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
        if ($this->email !== null) {
            $payload = $payload->email($this->email);
        }
        if ($this->dateOfBirth !== null) {
            $payload = $payload->dateOfBirth($this->dateOfBirth);
        }

        return $payload->save();
    }

    public function createLeaveApplication(): LeaveApplicationPayload
    {
        if ($this->client === null || $this->employeeID === null) {
            throw new RuntimeException('Cannot create a leave application without a bound client context and employee id.');
        }

        return (new LeaveApplicationPayload($this->client))->employee($this->employeeID);
    }
}
