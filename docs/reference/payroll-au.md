# Payroll AU reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Payroll\AU\Employee](#payrollauemployee)
- [Payroll\AU\Employee\HomeAddress](#payrollauemployeehomeaddress)
- [Payroll\AU\Employee\OpeningBalances](#payrollauemployeeopeningbalances)
- [Payroll\AU\Employee\PayTemplate](#payrollauemployeepaytemplate)
- [Payroll\AU\Employee\TaxDeclaration](#payrollauemployeetaxdeclaration)
- [Payroll\AU\Employees](#payrollauemployees)
- [Payroll\AU\LeaveApplication\LeaveApplication](#payrollauleaveapplicationleaveapplication)
- [Payroll\AU\LeaveApplication\LeaveApplications](#payrollauleaveapplicationleaveapplications)
- [Payroll\AU\LeaveApplication\Payload](#payrollauleaveapplicationpayload)
- [Payroll\AU\PayItem\PayItem](#payrollaupayitempayitem)
- [Payroll\AU\PayItem\PayItems](#payrollaupayitempayitems)
- [Payroll\AU\PayItem\Payload](#payrollaupayitempayload)
- [Payroll\AU\PayRun\PayRun](#payrollaupayrunpayrun)
- [Payroll\AU\PayRun\PayRuns](#payrollaupayrunpayruns)
- [Payroll\AU\PayRun\Payload](#payrollaupayrunpayload)
- [Payroll\AU\PayRun\Payslip](#payrollaupayrunpayslip)
- [Payroll\AU\PayRun\PayslipSummary](#payrollaupayrunpayslipsummary)
- [Payroll\AU\Payload](#payrollaupayload)
- [Payroll\AU\PayrollAU](#payrollaupayrollau)
- [Payroll\AU\PayrollCalendar\Payload](#payrollaupayrollcalendarpayload)
- [Payroll\AU\PayrollCalendar\PayrollCalendar](#payrollaupayrollcalendarpayrollcalendar)
- [Payroll\AU\PayrollCalendar\PayrollCalendars](#payrollaupayrollcalendarpayrollcalendars)
- [Payroll\AU\Settings\Settings](#payrollausettingssettings)
- [Payroll\AU\SuperFund\Payload](#payrollausuperfundpayload)
- [Payroll\AU\SuperFund\Product](#payrollausuperfundproduct)
- [Payroll\AU\SuperFund\Products](#payrollausuperfundproducts)
- [Payroll\AU\SuperFund\SuperFund](#payrollausuperfundsuperfund)
- [Payroll\AU\SuperFund\SuperFunds](#payrollausuperfundsuperfunds)
- [Payroll\AU\Timesheet\Payload](#payrollautimesheetpayload)
- [Payroll\AU\Timesheet\Timesheet](#payrollautimesheettimesheet)
- [Payroll\AU\Timesheet\Timesheets](#payrollautimesheettimesheets)

## Payroll\AU\Employee

[Source](../../src/Payroll/AU/Employee.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `EmployeeID` | string or null | `setEmployeeID()` |
| `FirstName` | string or null | `setFirstName()` |
| `LastName` | string or null | `setLastName()` |
| `HomeAddress` | object or null ([Payroll\AU\Employee\HomeAddress](payroll-au.md#payrollauemployeehomeaddress)) | `setHomeAddress()` |
| `DateOfBirth` | string or null | `setDateOfBirth()` |
| `StartDate` | string or null | `setStartDate()` |
| `Title` | string or null | `setTitle()` |
| `MiddleNames` | string or null | `setMiddleNames()` |
| `Email` | string or null | `setEmail()` |
| `Gender` | string or null | `setGender()` |
| `Phone` | string or null | `setPhone()` |
| `Mobile` | string or null | `setMobile()` |
| `TwitterUserName` | string or null | `setTwitterUserName()` |
| `IsAuthorisedToApproveLeave` | bool or null | `setIsAuthorisedToApproveLeave()` |
| `IsAuthorisedToApproveTimesheets` | bool or null | `setIsAuthorisedToApproveTimesheets()` |
| `JobTitle` | string or null | `setJobTitle()` |
| `Classification` | string or null | `setClassification()` |
| `OrdinaryEarningsRateID` | string or null | `setOrdinaryEarningsRateID()` |
| `PayrollCalendarID` | string or null | `setPayrollCalendarID()` |
| `EmployeeGroupName` | string or null | `setEmployeeGroupName()` |
| `TerminationDate` | string or null | `setTerminationDate()` |
| `TerminationReason` | string or null | `setTerminationReason()` |
| `BankAccounts` | array | `setBankAccounts()` |
| `PayTemplate` | object or null ([Payroll\AU\Employee\PayTemplate](payroll-au.md#payrollauemployeepaytemplate)) | `setPayTemplate()` |
| `OpeningBalances` | object or null ([Payroll\AU\Employee\OpeningBalances](payroll-au.md#payrollauemployeeopeningbalances)) | `setOpeningBalances()` |
| `TaxDeclaration` | object or null ([Payroll\AU\Employee\TaxDeclaration](payroll-au.md#payrollauemployeetaxdeclaration)) | `setTaxDeclaration()` |
| `IncomeType` | string or null | `setIncomeType()` |
| `EmploymentType` | string or null | `setEmploymentType()` |
| `CountryOfResidence` | string or null | `setCountryOfResidence()` |
| `IsSTP2Qualified` | bool or null | `setIsSTP2Qualified()` |
| `LeaveBalances` | array | `setLeaveBalances()` |
| `SuperMemberships` | array | `setSuperMemberships()` |
| `Status` | string or null | `setStatus()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/AU/Employee.php#L72)
- [`getEmployeeID(): ?string`](../../src/Payroll/AU/Employee.php#L77)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L82)
- [`getFirstName(): ?string`](../../src/Payroll/AU/Employee.php#L88)
- [`setFirstName(?string $firstName): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L93)
- [`getLastName(): ?string`](../../src/Payroll/AU/Employee.php#L99)
- [`setLastName(?string $lastName): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L104)
- [`getHomeAddress(): ?\Sujip\Xero\Payroll\AU\Employee\HomeAddress`](../../src/Payroll/AU/Employee.php#L110)
- [`setHomeAddress(?\Sujip\Xero\Payroll\AU\Employee\HomeAddress $homeAddress): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L115)
- [`getDateOfBirth(): ?string`](../../src/Payroll/AU/Employee.php#L121)
- [`setDateOfBirth(?string $dateOfBirth): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L126)
- [`getStartDate(): ?string`](../../src/Payroll/AU/Employee.php#L132)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L137)
- [`getTitle(): ?string`](../../src/Payroll/AU/Employee.php#L143)
- [`setTitle(?string $title): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L148)
- [`getMiddleNames(): ?string`](../../src/Payroll/AU/Employee.php#L154)
- [`setMiddleNames(?string $middleNames): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L159)
- [`getEmail(): ?string`](../../src/Payroll/AU/Employee.php#L165)
- [`setEmail(?string $email): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L170)
- [`getGender(): ?string`](../../src/Payroll/AU/Employee.php#L176)
- [`setGender(?string $gender): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L181)
- [`getPhone(): ?string`](../../src/Payroll/AU/Employee.php#L187)
- [`setPhone(?string $phone): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L192)
- [`getMobile(): ?string`](../../src/Payroll/AU/Employee.php#L198)
- [`setMobile(?string $mobile): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L203)
- [`getTwitterUserName(): ?string`](../../src/Payroll/AU/Employee.php#L209)
- [`setTwitterUserName(?string $twitterUserName): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L214)
- [`getIsAuthorisedToApproveLeave(): ?bool`](../../src/Payroll/AU/Employee.php#L220)
- [`setIsAuthorisedToApproveLeave(?bool $isAuthorisedToApproveLeave): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L225)
- [`getIsAuthorisedToApproveTimesheets(): ?bool`](../../src/Payroll/AU/Employee.php#L231)
- [`setIsAuthorisedToApproveTimesheets(?bool $isAuthorisedToApproveTimesheets): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L236)
- [`getJobTitle(): ?string`](../../src/Payroll/AU/Employee.php#L242)
- [`setJobTitle(?string $jobTitle): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L247)
- [`getClassification(): ?string`](../../src/Payroll/AU/Employee.php#L253)
- [`setClassification(?string $classification): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L258)
- [`getOrdinaryEarningsRateID(): ?string`](../../src/Payroll/AU/Employee.php#L264)
- [`setOrdinaryEarningsRateID(?string $ordinaryEarningsRateID): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L269)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/AU/Employee.php#L275)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L280)
- [`getEmployeeGroupName(): ?string`](../../src/Payroll/AU/Employee.php#L286)
- [`setEmployeeGroupName(?string $employeeGroupName): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L291)
- [`getTerminationDate(): ?string`](../../src/Payroll/AU/Employee.php#L297)
- [`setTerminationDate(?string $terminationDate): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L302)
- [`getTerminationReason(): ?string`](../../src/Payroll/AU/Employee.php#L308)
- [`setTerminationReason(?string $terminationReason): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L313)
- [`getBankAccounts(): array`](../../src/Payroll/AU/Employee.php#L322)
- [`setBankAccounts(array $bankAccounts): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L330)
- [`getPayTemplate(): ?\Sujip\Xero\Payroll\AU\Employee\PayTemplate`](../../src/Payroll/AU/Employee.php#L336)
- [`setPayTemplate(?\Sujip\Xero\Payroll\AU\Employee\PayTemplate $payTemplate): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L341)
- [`getOpeningBalances(): ?\Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee.php#L347)
- [`setOpeningBalances(?\Sujip\Xero\Payroll\AU\Employee\OpeningBalances $openingBalances): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L352)
- [`getTaxDeclaration(): ?\Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee.php#L358)
- [`setTaxDeclaration(?\Sujip\Xero\Payroll\AU\Employee\TaxDeclaration $taxDeclaration): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L363)
- [`getIncomeType(): ?string`](../../src/Payroll/AU/Employee.php#L369)
- [`setIncomeType(?string $incomeType): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L374)
- [`getEmploymentType(): ?string`](../../src/Payroll/AU/Employee.php#L380)
- [`setEmploymentType(?string $employmentType): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L385)
- [`getCountryOfResidence(): ?string`](../../src/Payroll/AU/Employee.php#L391)
- [`setCountryOfResidence(?string $countryOfResidence): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L396)
- [`getIsSTP2Qualified(): ?bool`](../../src/Payroll/AU/Employee.php#L402)
- [`setIsSTP2Qualified(?bool $isSTP2Qualified): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L407)
- [`getLeaveBalances(): array`](../../src/Payroll/AU/Employee.php#L416)
- [`setLeaveBalances(array $leaveBalances): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L424)
- [`getSuperMemberships(): array`](../../src/Payroll/AU/Employee.php#L433)
- [`setSuperMemberships(array $superMemberships): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L441)
- [`getStatus(): ?string`](../../src/Payroll/AU/Employee.php#L447)
- [`setStatus(?string $status): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L452)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/AU/Employee.php#L458)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L463)
- [`getValidationErrors(): array`](../../src/Payroll/AU/Employee.php#L472)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L477)
- [`save(): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employee.php#L527)
- [`createLeaveApplication(): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/Employee.php#L554)

## Payroll\AU\Employee\HomeAddress

[Source](../../src/Payroll/AU/Employee/HomeAddress.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AddressLine1` | string or null | `setAddressLine1()` |
| `AddressLine2` | string or null | `setAddressLine2()` |
| `City` | string or null | `setCity()` |
| `Region` | string or null | `setRegion()` |
| `PostalCode` | string or null | `setPostalCode()` |
| `Country` | string or null | `setCountry()` |

### Public methods

- [`__construct(?string $addressLine1 = NULL, ?string $addressLine2 = NULL, ?string $city = NULL, ?string $region = NULL, ?string $postalCode = NULL, ?string $country = NULL)`](../../src/Payroll/AU/Employee/HomeAddress.php#L12)
- [`getAddressLine1(): ?string`](../../src/Payroll/AU/Employee/HomeAddress.php#L22)
- [`setAddressLine1(?string $addressLine1): Sujip\Xero\Payroll\AU\Employee\HomeAddress`](../../src/Payroll/AU/Employee/HomeAddress.php#L27)
- [`getAddressLine2(): ?string`](../../src/Payroll/AU/Employee/HomeAddress.php#L33)
- [`setAddressLine2(?string $addressLine2): Sujip\Xero\Payroll\AU\Employee\HomeAddress`](../../src/Payroll/AU/Employee/HomeAddress.php#L38)
- [`getCity(): ?string`](../../src/Payroll/AU/Employee/HomeAddress.php#L44)
- [`setCity(?string $city): Sujip\Xero\Payroll\AU\Employee\HomeAddress`](../../src/Payroll/AU/Employee/HomeAddress.php#L49)
- [`getRegion(): ?string`](../../src/Payroll/AU/Employee/HomeAddress.php#L55)
- [`setRegion(?string $region): Sujip\Xero\Payroll\AU\Employee\HomeAddress`](../../src/Payroll/AU/Employee/HomeAddress.php#L60)
- [`getPostalCode(): ?string`](../../src/Payroll/AU/Employee/HomeAddress.php#L66)
- [`setPostalCode(?string $postalCode): Sujip\Xero\Payroll\AU\Employee\HomeAddress`](../../src/Payroll/AU/Employee/HomeAddress.php#L71)
- [`getCountry(): ?string`](../../src/Payroll/AU/Employee/HomeAddress.php#L77)
- [`setCountry(?string $country): Sujip\Xero\Payroll\AU\Employee\HomeAddress`](../../src/Payroll/AU/Employee/HomeAddress.php#L82)

## Payroll\AU\Employee\OpeningBalances

[Source](../../src/Payroll/AU/Employee/OpeningBalances.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `OpeningBalanceDate` | string or null | `setOpeningBalanceDate()` |
| `Tax` | string or null | `setTax()` |
| `EarningsLines` | array | `setEarningsLines()` |
| `DeductionLines` | array | `setDeductionLines()` |
| `SuperLines` | array | `setSuperLines()` |
| `ReimbursementLines` | array | `setReimbursementLines()` |
| `LeaveLines` | array | `setLeaveLines()` |
| `PaidLeaveEarningsLines` | array | `setPaidLeaveEarningsLines()` |

### Public methods

- [`__construct(?string $openingBalanceDate = NULL, ?string $tax = NULL, array $earningsLines = array (
), array $deductionLines = array (
), array $superLines = array (
), array $reimbursementLines = array (
), array $leaveLines = array (
), array $paidLeaveEarningsLines = array (
))`](../../src/Payroll/AU/Employee/OpeningBalances.php#L20)
- [`getOpeningBalanceDate(): ?string`](../../src/Payroll/AU/Employee/OpeningBalances.php#L32)
- [`setOpeningBalanceDate(?string $openingBalanceDate): Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee/OpeningBalances.php#L37)
- [`getTax(): ?string`](../../src/Payroll/AU/Employee/OpeningBalances.php#L43)
- [`setTax(?string $tax): Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee/OpeningBalances.php#L48)
- [`getEarningsLines(): array`](../../src/Payroll/AU/Employee/OpeningBalances.php#L57)
- [`setEarningsLines(array $earningsLines): Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee/OpeningBalances.php#L65)
- [`getDeductionLines(): array`](../../src/Payroll/AU/Employee/OpeningBalances.php#L74)
- [`setDeductionLines(array $deductionLines): Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee/OpeningBalances.php#L82)
- [`getSuperLines(): array`](../../src/Payroll/AU/Employee/OpeningBalances.php#L91)
- [`setSuperLines(array $superLines): Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee/OpeningBalances.php#L99)
- [`getReimbursementLines(): array`](../../src/Payroll/AU/Employee/OpeningBalances.php#L108)
- [`setReimbursementLines(array $reimbursementLines): Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee/OpeningBalances.php#L116)
- [`getLeaveLines(): array`](../../src/Payroll/AU/Employee/OpeningBalances.php#L125)
- [`setLeaveLines(array $leaveLines): Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee/OpeningBalances.php#L133)
- [`getPaidLeaveEarningsLines(): array`](../../src/Payroll/AU/Employee/OpeningBalances.php#L142)
- [`setPaidLeaveEarningsLines(array $paidLeaveEarningsLines): Sujip\Xero\Payroll\AU\Employee\OpeningBalances`](../../src/Payroll/AU/Employee/OpeningBalances.php#L150)

## Payroll\AU\Employee\PayTemplate

[Source](../../src/Payroll/AU/Employee/PayTemplate.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `EarningsLines` | array | `setEarningsLines()` |
| `DeductionLines` | array | `setDeductionLines()` |
| `SuperLines` | array | `setSuperLines()` |
| `ReimbursementLines` | array | `setReimbursementLines()` |
| `LeaveLines` | array | `setLeaveLines()` |

### Public methods

- [`__construct(array $earningsLines = array (
), array $deductionLines = array (
), array $superLines = array (
), array $reimbursementLines = array (
), array $leaveLines = array (
))`](../../src/Payroll/AU/Employee/PayTemplate.php#L19)
- [`getEarningsLines(): array`](../../src/Payroll/AU/Employee/PayTemplate.php#L31)
- [`setEarningsLines(array $earningsLines): Sujip\Xero\Payroll\AU\Employee\PayTemplate`](../../src/Payroll/AU/Employee/PayTemplate.php#L39)
- [`getDeductionLines(): array`](../../src/Payroll/AU/Employee/PayTemplate.php#L48)
- [`setDeductionLines(array $deductionLines): Sujip\Xero\Payroll\AU\Employee\PayTemplate`](../../src/Payroll/AU/Employee/PayTemplate.php#L56)
- [`getSuperLines(): array`](../../src/Payroll/AU/Employee/PayTemplate.php#L65)
- [`setSuperLines(array $superLines): Sujip\Xero\Payroll\AU\Employee\PayTemplate`](../../src/Payroll/AU/Employee/PayTemplate.php#L73)
- [`getReimbursementLines(): array`](../../src/Payroll/AU/Employee/PayTemplate.php#L82)
- [`setReimbursementLines(array $reimbursementLines): Sujip\Xero\Payroll\AU\Employee\PayTemplate`](../../src/Payroll/AU/Employee/PayTemplate.php#L90)
- [`getLeaveLines(): array`](../../src/Payroll/AU/Employee/PayTemplate.php#L99)
- [`setLeaveLines(array $leaveLines): Sujip\Xero\Payroll\AU\Employee\PayTemplate`](../../src/Payroll/AU/Employee/PayTemplate.php#L107)

## Payroll\AU\Employee\TaxDeclaration

[Source](../../src/Payroll/AU/Employee/TaxDeclaration.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `EmployeeID` | string or null | `setEmployeeID()` |
| `EmploymentBasis` | string or null | `setEmploymentBasis()` |
| `TFNExemptionType` | string or null | `setTFNExemptionType()` |
| `TaxFileNumber` | string or null | `setTaxFileNumber()` |
| `ABN` | string or null | `setABN()` |
| `AustralianResidentForTaxPurposes` | bool or null | `setAustralianResidentForTaxPurposes()` |
| `ResidencyStatus` | string or null | `setResidencyStatus()` |
| `TaxScaleType` | string or null | `setTaxScaleType()` |
| `WorkCondition` | string or null | `setWorkCondition()` |
| `SeniorMaritalStatus` | string or null | `setSeniorMaritalStatus()` |
| `TaxFreeThresholdClaimed` | bool or null | `setTaxFreeThresholdClaimed()` |
| `TaxOffsetEstimatedAmount` | int, float, or null | `setTaxOffsetEstimatedAmount()` |
| `HasHELPDebt` | bool or null | `setHasHELPDebt()` |
| `HasSFSSDebt` | bool or null | `setHasSFSSDebt()` |
| `HasTradeSupportLoanDebt` | bool or null | `setHasTradeSupportLoanDebt()` |
| `UpwardVariationTaxWithholdingAmount` | int, float, or null | `setUpwardVariationTaxWithholdingAmount()` |
| `EligibleToReceiveLeaveLoading` | bool or null | `setEligibleToReceiveLeaveLoading()` |
| `ApprovedWithholdingVariationPercentage` | int, float, or null | `setApprovedWithholdingVariationPercentage()` |
| `HasStudentStartupLoan` | bool or null | `setHasStudentStartupLoan()` |
| `HasLoanOrStudentDebt` | bool or null | `setHasLoanOrStudentDebt()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `IncludeLeaveLoadingInQualifyingEarnings` | bool or null | `setIncludeLeaveLoadingInQualifyingEarnings()` |

### Public methods

- [`__construct(?string $employeeID = NULL, ?string $employmentBasis = NULL, ?string $tFNExemptionType = NULL, ?string $taxFileNumber = NULL, ?string $aBN = NULL, ?bool $australianResidentForTaxPurposes = NULL, ?string $residencyStatus = NULL, ?string $taxScaleType = NULL, ?string $workCondition = NULL, ?string $seniorMaritalStatus = NULL, ?bool $taxFreeThresholdClaimed = NULL, ?float $taxOffsetEstimatedAmount = NULL, ?bool $hasHELPDebt = NULL, ?bool $hasSFSSDebt = NULL, ?bool $hasTradeSupportLoanDebt = NULL, ?float $upwardVariationTaxWithholdingAmount = NULL, ?bool $eligibleToReceiveLeaveLoading = NULL, ?float $approvedWithholdingVariationPercentage = NULL, ?bool $hasStudentStartupLoan = NULL, ?bool $hasLoanOrStudentDebt = NULL, ?string $updatedDateUTC = NULL, ?bool $includeLeaveLoadingInQualifyingEarnings = NULL)`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L12)
- [`getEmployeeID(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L38)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L43)
- [`getEmploymentBasis(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L49)
- [`setEmploymentBasis(?string $employmentBasis): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L54)
- [`getTFNExemptionType(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L60)
- [`setTFNExemptionType(?string $tFNExemptionType): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L65)
- [`getTaxFileNumber(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L71)
- [`setTaxFileNumber(?string $taxFileNumber): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L76)
- [`getABN(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L82)
- [`setABN(?string $aBN): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L87)
- [`getAustralianResidentForTaxPurposes(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L93)
- [`setAustralianResidentForTaxPurposes(?bool $australianResidentForTaxPurposes): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L98)
- [`getResidencyStatus(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L104)
- [`setResidencyStatus(?string $residencyStatus): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L109)
- [`getTaxScaleType(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L115)
- [`setTaxScaleType(?string $taxScaleType): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L120)
- [`getWorkCondition(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L126)
- [`setWorkCondition(?string $workCondition): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L131)
- [`getSeniorMaritalStatus(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L137)
- [`setSeniorMaritalStatus(?string $seniorMaritalStatus): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L142)
- [`getTaxFreeThresholdClaimed(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L148)
- [`setTaxFreeThresholdClaimed(?bool $taxFreeThresholdClaimed): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L153)
- [`getTaxOffsetEstimatedAmount(): ?float`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L159)
- [`setTaxOffsetEstimatedAmount(?float $taxOffsetEstimatedAmount): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L164)
- [`getHasHELPDebt(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L170)
- [`setHasHELPDebt(?bool $hasHELPDebt): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L175)
- [`getHasSFSSDebt(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L181)
- [`setHasSFSSDebt(?bool $hasSFSSDebt): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L186)
- [`getHasTradeSupportLoanDebt(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L192)
- [`setHasTradeSupportLoanDebt(?bool $hasTradeSupportLoanDebt): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L197)
- [`getUpwardVariationTaxWithholdingAmount(): ?float`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L203)
- [`setUpwardVariationTaxWithholdingAmount(?float $upwardVariationTaxWithholdingAmount): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L208)
- [`getEligibleToReceiveLeaveLoading(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L214)
- [`setEligibleToReceiveLeaveLoading(?bool $eligibleToReceiveLeaveLoading): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L219)
- [`getApprovedWithholdingVariationPercentage(): ?float`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L225)
- [`setApprovedWithholdingVariationPercentage(?float $approvedWithholdingVariationPercentage): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L230)
- [`getHasStudentStartupLoan(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L236)
- [`setHasStudentStartupLoan(?bool $hasStudentStartupLoan): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L241)
- [`getHasLoanOrStudentDebt(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L247)
- [`setHasLoanOrStudentDebt(?bool $hasLoanOrStudentDebt): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L252)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L258)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L263)
- [`getIncludeLeaveLoadingInQualifyingEarnings(): ?bool`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L269)
- [`setIncludeLeaveLoadingInQualifyingEarnings(?bool $includeLeaveLoadingInQualifyingEarnings): Sujip\Xero\Payroll\AU\Employee\TaxDeclaration`](../../src/Payroll/AU/Employee/TaxDeclaration.php#L274)

## Payroll\AU\Employees

[Source](../../src/Payroll/AU/Employees.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/AU/Employees.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/AU/Employees.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/Employees.php#L27)
- [`modifiedSince(\DateTimeInterface $date): Sujip\Xero\Payroll\AU\Employees`](../../src/Payroll/AU/Employees.php#L32)
- [`where(string $where): Sujip\Xero\Payroll\AU\Employees`](../../src/Payroll/AU/Employees.php#L40)
- [`orderBy(string $order): Sujip\Xero\Payroll\AU\Employees`](../../src/Payroll/AU/Employees.php#L48)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/Employees.php#L59)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/AU/Employees.php#L76)
- [`find(string $employeeId): ?\Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employees.php#L100)
- [`create(): Sujip\Xero\Payroll\AU\Payload`](../../src/Payroll/AU/Employees.php#L112)
- [`update(string $employeeId): Sujip\Xero\Payroll\AU\Payload`](../../src/Payroll/AU/Employees.php#L117)
- [`mapEmployee(array $employee): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Employees.php#L125)

## Payroll\AU\LeaveApplication\LeaveApplication

[Source](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `LeaveApplicationID` | string or null | `setLeaveApplicationID()` |
| `EmployeeID` | string or null | `setEmployeeID()` |
| `LeaveTypeID` | string or null | `setLeaveTypeID()` |
| `Title` | string or null | `setTitle()` |
| `StartDate` | string or null | `setStartDate()` |
| `EndDate` | string or null | `setEndDate()` |
| `Description` | string or null | `setDescription()` |
| `PayOutType` | string or null | `setPayOutType()` |
| `LeavePeriods` | array | `setLeavePeriods()` |
| `Status` | string or null | `setStatus()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L36)
- [`getLeaveApplicationID(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L41)
- [`setLeaveApplicationID(?string $leaveApplicationID): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L45)
- [`getEmployeeID(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L50)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L54)
- [`getLeaveTypeID(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L59)
- [`setLeaveTypeID(?string $leaveTypeID): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L63)
- [`getTitle(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L68)
- [`setTitle(?string $title): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L72)
- [`getStartDate(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L77)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L81)
- [`getEndDate(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L86)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L90)
- [`getDescription(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L95)
- [`setDescription(?string $description): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L99)
- [`getPayOutType(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L104)
- [`setPayOutType(?string $payOutType): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L108)
- [`getLeavePeriods(): array`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L117)
- [`setLeavePeriods(array $leavePeriods): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L125)
- [`getStatus(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L130)
- [`setStatus(?string $status): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L134)
- [`status(string $status): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L139)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L145)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L149)
- [`getValidationErrors(): array`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L158)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L163)
- [`save(): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L190)
- [`approve(): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L225)
- [`reject(): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplication.php#L234)

## Payroll\AU\LeaveApplication\LeaveApplications

[Source](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L29)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L34)
- [`modifiedSince(\DateTimeInterface $date): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplications`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L42)
- [`where(string $where): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplications`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L50)
- [`orderBy(string $order): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplications`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L58)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L69)
- [`v2(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L91)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L111)
- [`find(string $leaveApplicationId): ?\Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L126)
- [`create(): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L138)
- [`update(string $leaveApplicationId): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L143)
- [`approve(string $leaveApplicationId): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L148)
- [`reject(string $leaveApplicationId): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L160)
- [`mapLeaveApplication(array $leaveApplication): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/LeaveApplications.php#L175)

## Payroll\AU\LeaveApplication\Payload

[Source](../../src/Payroll/AU/LeaveApplication/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/LeaveApplication/Payload.php#L21)
- [`id(string $leaveApplicationId): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/Payload.php#L26)
- [`employee(string $employeeId): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/Payload.php#L34)
- [`leaveType(string $leaveTypeId): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/Payload.php#L42)
- [`title(string $title): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/Payload.php#L50)
- [`startDate(string $startDate): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/Payload.php#L58)
- [`endDate(string $endDate): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/Payload.php#L66)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\AU\LeaveApplication\Payload`](../../src/Payroll/AU/LeaveApplication/Payload.php#L74)
- [`save(): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication`](../../src/Payroll/AU/LeaveApplication/Payload.php#L82)

## Payroll\AU\PayItem\PayItem

[Source](../../src/Payroll/AU/PayItem/PayItem.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `EarningsRates` | array | `setEarningsRates()` |
| `DeductionTypes` | array | `setDeductionTypes()` |
| `LeaveTypes` | array | `setLeaveTypes()` |
| `ReimbursementTypes` | array | `setReimbursementTypes()` |

### Public methods

- [`__construct(array $earningsRates = array (
), array $deductionTypes = array (
), array $leaveTypes = array (
), array $reimbursementTypes = array (
))`](../../src/Payroll/AU/PayItem/PayItem.php#L18)
- [`getEarningsRates(): array`](../../src/Payroll/AU/PayItem/PayItem.php#L29)
- [`setEarningsRates(array $earningsRates): Sujip\Xero\Payroll\AU\PayItem\PayItem`](../../src/Payroll/AU/PayItem/PayItem.php#L36)
- [`getDeductionTypes(): array`](../../src/Payroll/AU/PayItem/PayItem.php#L44)
- [`setDeductionTypes(array $deductionTypes): Sujip\Xero\Payroll\AU\PayItem\PayItem`](../../src/Payroll/AU/PayItem/PayItem.php#L51)
- [`getLeaveTypes(): array`](../../src/Payroll/AU/PayItem/PayItem.php#L59)
- [`setLeaveTypes(array $leaveTypes): Sujip\Xero\Payroll\AU\PayItem\PayItem`](../../src/Payroll/AU/PayItem/PayItem.php#L66)
- [`getReimbursementTypes(): array`](../../src/Payroll/AU/PayItem/PayItem.php#L74)
- [`setReimbursementTypes(array $reimbursementTypes): Sujip\Xero\Payroll\AU\PayItem\PayItem`](../../src/Payroll/AU/PayItem/PayItem.php#L81)

## Payroll\AU\PayItem\PayItems

[Source](../../src/Payroll/AU/PayItem/PayItems.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/AU/PayItem/PayItems.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/AU/PayItem/PayItems.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/PayItem/PayItems.php#L29)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/AU/PayItem/PayItems.php#L34)
- [`modifiedSince(\DateTimeInterface $date): Sujip\Xero\Payroll\AU\PayItem\PayItems`](../../src/Payroll/AU/PayItem/PayItems.php#L42)
- [`where(string $where): Sujip\Xero\Payroll\AU\PayItem\PayItems`](../../src/Payroll/AU/PayItem/PayItems.php#L50)
- [`orderBy(string $order): Sujip\Xero\Payroll\AU\PayItem\PayItems`](../../src/Payroll/AU/PayItem/PayItems.php#L58)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/PayItem/PayItems.php#L69)
- [`create(): Sujip\Xero\Payroll\AU\PayItem\Payload`](../../src/Payroll/AU/PayItem/PayItems.php#L84)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/AU/PayItem/PayItems.php#L92)
- [`mapPayItem(array $payItem): Sujip\Xero\Payroll\AU\PayItem\PayItem`](../../src/Payroll/AU/PayItem/PayItems.php#L110)

## Payroll\AU\PayItem\Payload

[Source](../../src/Payroll/AU/PayItem/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/PayItem/Payload.php#L18)
- [`earningsRates(array $rates): Sujip\Xero\Payroll\AU\PayItem\Payload`](../../src/Payroll/AU/PayItem/Payload.php#L23)
- [`deductionTypes(array $types): Sujip\Xero\Payroll\AU\PayItem\Payload`](../../src/Payroll/AU/PayItem/Payload.php#L32)
- [`leaveTypes(array $types): Sujip\Xero\Payroll\AU\PayItem\Payload`](../../src/Payroll/AU/PayItem/Payload.php#L41)
- [`reimbursementTypes(array $types): Sujip\Xero\Payroll\AU\PayItem\Payload`](../../src/Payroll/AU/PayItem/Payload.php#L50)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\AU\PayItem\Payload`](../../src/Payroll/AU/PayItem/Payload.php#L58)
- [`save(): Sujip\Xero\Payroll\AU\PayItem\PayItem`](../../src/Payroll/AU/PayItem/Payload.php#L66)

## Payroll\AU\PayRun\PayRun

[Source](../../src/Payroll/AU/PayRun/PayRun.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PayRunID` | string or null | `setPayRunID()` |
| `PayrollCalendarID` | string or null | `setPayrollCalendarID()` |
| `PayRunPeriodStartDate` | string or null | `setPayRunPeriodStartDate()` |
| `PayRunPeriodEndDate` | string or null | `setPayRunPeriodEndDate()` |
| `PayRunStatus` | string or null | `setPayRunStatus()` |
| `PaymentDate` | string or null | `setPaymentDate()` |
| `PayslipMessage` | string or null | `setPayslipMessage()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `Payslips` | list of objects ([Payroll\AU\PayRun\PayslipSummary](payroll-au.md#payrollaupayrunpayslipsummary)) | `addPayslipSummary()` |
| `Wages` | int, float, or null | `setWages()` |
| `Deductions` | int, float, or null | `setDeductions()` |
| `Tax` | int, float, or null | `setTax()` |
| `Super` | int, float, or null | `setSuper()` |
| `Reimbursement` | int, float, or null | `setReimbursement()` |
| `NetPay` | int, float, or null | `setNetPay()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/AU/PayRun/PayRun.php#L39)
- [`getPayRunID(): ?string`](../../src/Payroll/AU/PayRun/PayRun.php#L44)
- [`setPayRunID(?string $payRunID): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L49)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/AU/PayRun/PayRun.php#L56)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L61)
- [`getPayRunPeriodStartDate(): ?string`](../../src/Payroll/AU/PayRun/PayRun.php#L68)
- [`setPayRunPeriodStartDate(?string $payRunPeriodStartDate): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L73)
- [`getPayRunPeriodEndDate(): ?string`](../../src/Payroll/AU/PayRun/PayRun.php#L80)
- [`setPayRunPeriodEndDate(?string $payRunPeriodEndDate): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L85)
- [`getPayRunStatus(): ?string`](../../src/Payroll/AU/PayRun/PayRun.php#L92)
- [`setPayRunStatus(?string $payRunStatus): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L97)
- [`getPaymentDate(): ?string`](../../src/Payroll/AU/PayRun/PayRun.php#L104)
- [`setPaymentDate(?string $paymentDate): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L109)
- [`getPayslipMessage(): ?string`](../../src/Payroll/AU/PayRun/PayRun.php#L116)
- [`setPayslipMessage(?string $payslipMessage): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L121)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/AU/PayRun/PayRun.php#L128)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L133)
- [`getWages(): ?float`](../../src/Payroll/AU/PayRun/PayRun.php#L140)
- [`setWages(?float $wages): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L145)
- [`getDeductions(): ?float`](../../src/Payroll/AU/PayRun/PayRun.php#L152)
- [`setDeductions(?float $deductions): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L157)
- [`getTax(): ?float`](../../src/Payroll/AU/PayRun/PayRun.php#L164)
- [`setTax(?float $tax): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L169)
- [`getSuper(): ?float`](../../src/Payroll/AU/PayRun/PayRun.php#L176)
- [`setSuper(?float $super): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L181)
- [`getReimbursement(): ?float`](../../src/Payroll/AU/PayRun/PayRun.php#L188)
- [`setReimbursement(?float $reimbursement): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L193)
- [`getNetPay(): ?float`](../../src/Payroll/AU/PayRun/PayRun.php#L200)
- [`setNetPay(?float $netPay): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L205)
- [`getValidationErrors(): array`](../../src/Payroll/AU/PayRun/PayRun.php#L215)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L220)
- [`addPayslipSummary(\Sujip\Xero\Payroll\AU\PayRun\PayslipSummary $payslip): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L227)
- [`payslips(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/PayRun/PayRun.php#L262)
- [`save(): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRun.php#L267)

## Payroll\AU\PayRun\PayRuns

[Source](../../src/Payroll/AU/PayRun/PayRuns.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/AU/PayRun/PayRuns.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/AU/PayRun/PayRuns.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/PayRun/PayRuns.php#L29)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/AU/PayRun/PayRuns.php#L34)
- [`modifiedSince(\DateTimeInterface $date): Sujip\Xero\Payroll\AU\PayRun\PayRuns`](../../src/Payroll/AU/PayRun/PayRuns.php#L42)
- [`where(string $where): Sujip\Xero\Payroll\AU\PayRun\PayRuns`](../../src/Payroll/AU/PayRun/PayRuns.php#L50)
- [`orderBy(string $order): Sujip\Xero\Payroll\AU\PayRun\PayRuns`](../../src/Payroll/AU/PayRun/PayRuns.php#L58)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/PayRun/PayRuns.php#L69)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/AU/PayRun/PayRuns.php#L89)
- [`find(string $payRunId): ?\Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRuns.php#L104)
- [`create(): Sujip\Xero\Payroll\AU\PayRun\Payload`](../../src/Payroll/AU/PayRun/PayRuns.php#L116)
- [`update(string $payRunId): Sujip\Xero\Payroll\AU\PayRun\Payload`](../../src/Payroll/AU/PayRun/PayRuns.php#L121)
- [`payslip(string $payslipId): ?\Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/PayRuns.php#L126)
- [`updatePayslip(string $payslipId, array $payslipLines, ?string $idempotencyKey = NULL): ?\Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/PayRuns.php#L141)
- [`mapPayRun(array $payRun): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/PayRuns.php#L159)

## Payroll\AU\PayRun\Payload

[Source](../../src/Payroll/AU/PayRun/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/PayRun/Payload.php#L21)
- [`id(string $payRunId): Sujip\Xero\Payroll\AU\PayRun\Payload`](../../src/Payroll/AU/PayRun/Payload.php#L26)
- [`payrollCalendar(string $payrollCalendarId): Sujip\Xero\Payroll\AU\PayRun\Payload`](../../src/Payroll/AU/PayRun/Payload.php#L34)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\AU\PayRun\Payload`](../../src/Payroll/AU/PayRun/Payload.php#L42)
- [`save(): Sujip\Xero\Payroll\AU\PayRun\PayRun`](../../src/Payroll/AU/PayRun/Payload.php#L50)

## Payroll\AU\PayRun\Payslip

[Source](../../src/Payroll/AU/PayRun/Payslip.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PayslipID` | string or null | `setPayslipID()` |
| `EmployeeID` | string or null | `setEmployeeID()` |
| `FirstName` | string or null | `setFirstName()` |
| `LastName` | string or null | `setLastName()` |
| `Wages` | int, float, or null | `setWages()` |
| `Deductions` | int, float, or null | `setDeductions()` |
| `Tax` | int, float, or null | `setTax()` |
| `Super` | int, float, or null | `setSuper()` |
| `Reimbursements` | int, float, or null | `setReimbursements()` |
| `NetPay` | int, float, or null | `setNetPay()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `EarningsLines` | array | `setEarningsLines()` |
| `LeaveEarningsLines` | array | `setLeaveEarningsLines()` |
| `TimesheetEarningsLines` | array | `setTimesheetEarningsLines()` |
| `DeductionLines` | array | `setDeductionLines()` |
| `LeaveAccrualLines` | array | `setLeaveAccrualLines()` |
| `ReimbursementLines` | array | `setReimbursementLines()` |
| `SuperannuationLines` | array | `setSuperannuationLines()` |
| `TaxLines` | array | `setTaxLines()` |

### Public methods

- [`getPayslipID(): ?string`](../../src/Payroll/AU/PayRun/Payslip.php#L48)
- [`setPayslipID(?string $payslipID): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L53)
- [`getEmployeeID(): ?string`](../../src/Payroll/AU/PayRun/Payslip.php#L60)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L65)
- [`getFirstName(): ?string`](../../src/Payroll/AU/PayRun/Payslip.php#L72)
- [`setFirstName(?string $firstName): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L77)
- [`getLastName(): ?string`](../../src/Payroll/AU/PayRun/Payslip.php#L84)
- [`setLastName(?string $lastName): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L89)
- [`getWages(): ?float`](../../src/Payroll/AU/PayRun/Payslip.php#L96)
- [`setWages(?float $wages): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L101)
- [`getDeductions(): ?float`](../../src/Payroll/AU/PayRun/Payslip.php#L108)
- [`setDeductions(?float $deductions): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L113)
- [`getTax(): ?float`](../../src/Payroll/AU/PayRun/Payslip.php#L120)
- [`setTax(?float $tax): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L125)
- [`getSuper(): ?float`](../../src/Payroll/AU/PayRun/Payslip.php#L132)
- [`setSuper(?float $super): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L137)
- [`getReimbursements(): ?float`](../../src/Payroll/AU/PayRun/Payslip.php#L144)
- [`setReimbursements(?float $reimbursements): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L149)
- [`getNetPay(): ?float`](../../src/Payroll/AU/PayRun/Payslip.php#L156)
- [`setNetPay(?float $netPay): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L161)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/AU/PayRun/Payslip.php#L168)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L173)
- [`getEarningsLines(): array`](../../src/Payroll/AU/PayRun/Payslip.php#L181)
- [`setEarningsLines(array $earningsLines): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L187)
- [`getLeaveEarningsLines(): array`](../../src/Payroll/AU/PayRun/Payslip.php#L195)
- [`setLeaveEarningsLines(array $leaveEarningsLines): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L201)
- [`getTimesheetEarningsLines(): array`](../../src/Payroll/AU/PayRun/Payslip.php#L209)
- [`setTimesheetEarningsLines(array $timesheetEarningsLines): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L215)
- [`getDeductionLines(): array`](../../src/Payroll/AU/PayRun/Payslip.php#L223)
- [`setDeductionLines(array $deductionLines): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L229)
- [`getLeaveAccrualLines(): array`](../../src/Payroll/AU/PayRun/Payslip.php#L237)
- [`setLeaveAccrualLines(array $leaveAccrualLines): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L243)
- [`getReimbursementLines(): array`](../../src/Payroll/AU/PayRun/Payslip.php#L251)
- [`setReimbursementLines(array $reimbursementLines): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L257)
- [`getSuperannuationLines(): array`](../../src/Payroll/AU/PayRun/Payslip.php#L265)
- [`setSuperannuationLines(array $superannuationLines): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L271)
- [`getTaxLines(): array`](../../src/Payroll/AU/PayRun/Payslip.php#L279)
- [`setTaxLines(array $taxLines): Sujip\Xero\Payroll\AU\PayRun\Payslip`](../../src/Payroll/AU/PayRun/Payslip.php#L285)

## Payroll\AU\PayRun\PayslipSummary

[Source](../../src/Payroll/AU/PayRun/PayslipSummary.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PayslipID` | string or null | `setPayslipID()` |
| `EmployeeID` | string or null | `setEmployeeID()` |
| `FirstName` | string or null | `setFirstName()` |
| `LastName` | string or null | `setLastName()` |
| `EmployeeGroup` | string or null | `setEmployeeGroup()` |
| `Wages` | int, float, or null | `setWages()` |
| `Deductions` | int, float, or null | `setDeductions()` |
| `Tax` | int, float, or null | `setTax()` |
| `Super` | int, float, or null | `setSuper()` |
| `Reimbursements` | int, float, or null | `setReimbursements()` |
| `NetPay` | int, float, or null | `setNetPay()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUTC()` |

### Public methods

- [`getPayslipID(): ?string`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L25)
- [`setPayslipID(?string $payslipID): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L30)
- [`getEmployeeID(): ?string`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L37)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L42)
- [`getFirstName(): ?string`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L49)
- [`setFirstName(?string $firstName): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L54)
- [`getLastName(): ?string`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L61)
- [`setLastName(?string $lastName): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L66)
- [`getEmployeeGroup(): ?string`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L73)
- [`setEmployeeGroup(?string $employeeGroup): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L78)
- [`getWages(): ?float`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L85)
- [`setWages(?float $wages): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L90)
- [`getDeductions(): ?float`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L97)
- [`setDeductions(?float $deductions): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L102)
- [`getTax(): ?float`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L109)
- [`setTax(?float $tax): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L114)
- [`getSuper(): ?float`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L121)
- [`setSuper(?float $super): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L126)
- [`getReimbursements(): ?float`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L133)
- [`setReimbursements(?float $reimbursements): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L138)
- [`getNetPay(): ?float`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L145)
- [`setNetPay(?float $netPay): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L150)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L157)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\AU\PayRun\PayslipSummary`](../../src/Payroll/AU/PayRun/PayslipSummary.php#L162)

## Payroll\AU\Payload

[Source](../../src/Payroll/AU/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/Payload.php#L21)
- [`id(string $employeeId): Sujip\Xero\Payroll\AU\Payload`](../../src/Payroll/AU/Payload.php#L26)
- [`firstName(string $firstName): Sujip\Xero\Payroll\AU\Payload`](../../src/Payroll/AU/Payload.php#L34)
- [`lastName(string $lastName): Sujip\Xero\Payroll\AU\Payload`](../../src/Payroll/AU/Payload.php#L42)
- [`email(string $email): Sujip\Xero\Payroll\AU\Payload`](../../src/Payroll/AU/Payload.php#L50)
- [`dateOfBirth(string $dateOfBirth): Sujip\Xero\Payroll\AU\Payload`](../../src/Payroll/AU/Payload.php#L58)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\AU\Payload`](../../src/Payroll/AU/Payload.php#L66)
- [`save(): Sujip\Xero\Payroll\AU\Employee`](../../src/Payroll/AU/Payload.php#L74)

## Payroll\AU\PayrollAU

[Source](../../src/Payroll/AU/PayrollAU.php)

Extends [Payroll\Shared\PayrollRegion](payroll.md#payrollsharedpayrollregion). Inherited methods are documented on the parent type.

### Public methods

- [`payrollCalendars(): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendars`](../../src/Payroll/AU/PayrollAU.php#L11)
- [`employees(): Sujip\Xero\Payroll\AU\Employees`](../../src/Payroll/AU/PayrollAU.php#L16)
- [`leaveApplications(): Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplications`](../../src/Payroll/AU/PayrollAU.php#L21)
- [`payItems(): Sujip\Xero\Payroll\AU\PayItem\PayItems`](../../src/Payroll/AU/PayrollAU.php#L26)
- [`payRuns(): Sujip\Xero\Payroll\AU\PayRun\PayRuns`](../../src/Payroll/AU/PayrollAU.php#L31)
- [`timesheets(): Sujip\Xero\Payroll\AU\Timesheet\Timesheets`](../../src/Payroll/AU/PayrollAU.php#L36)
- [`settings(): Sujip\Xero\Payroll\AU\Settings\Settings`](../../src/Payroll/AU/PayrollAU.php#L41)
- [`superFunds(): Sujip\Xero\Payroll\AU\SuperFund\SuperFunds`](../../src/Payroll/AU/PayrollAU.php#L46)
- [`superFundProducts(): Sujip\Xero\Payroll\AU\SuperFund\Products`](../../src/Payroll/AU/PayrollAU.php#L51)

## Payroll\AU\PayrollCalendar\Payload

[Source](../../src/Payroll/AU/PayrollCalendar/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/PayrollCalendar/Payload.php#L19)
- [`name(string $name): Sujip\Xero\Payroll\AU\PayrollCalendar\Payload`](../../src/Payroll/AU/PayrollCalendar/Payload.php#L24)
- [`calendarType(string $calendarType): Sujip\Xero\Payroll\AU\PayrollCalendar\Payload`](../../src/Payroll/AU/PayrollCalendar/Payload.php#L32)
- [`startDate(string $startDate): Sujip\Xero\Payroll\AU\PayrollCalendar\Payload`](../../src/Payroll/AU/PayrollCalendar/Payload.php#L40)
- [`paymentDate(string $paymentDate): Sujip\Xero\Payroll\AU\PayrollCalendar\Payload`](../../src/Payroll/AU/PayrollCalendar/Payload.php#L48)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\AU\PayrollCalendar\Payload`](../../src/Payroll/AU/PayrollCalendar/Payload.php#L56)
- [`save(): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/Payload.php#L64)

## Payroll\AU\PayrollCalendar\PayrollCalendar

[Source](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PayrollCalendarID` | string or null | `setPayrollCalendarID()` |
| `Name` | string or null | `setName()` |
| `CalendarType` | string or null | `setCalendarType()` |
| `StartDate` | string or null | `setStartDate()` |
| `PaymentDate` | string or null | `setPaymentDate()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUtc()` |
| `ReferenceDate` | string or null | `setReferenceDate()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?string $payrollCalendarID = NULL, ?string $name = NULL, ?string $calendarType = NULL, ?string $startDate = NULL, ?string $paymentDate = NULL, ?string $updatedDateUtc = NULL, ?string $referenceDate = NULL)`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L18)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L29)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L33)
- [`getName(): ?string`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L38)
- [`setName(?string $name): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L42)
- [`getCalendarType(): ?string`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L47)
- [`setCalendarType(?string $calendarType): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L51)
- [`getStartDate(): ?string`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L56)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L60)
- [`getPaymentDate(): ?string`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L65)
- [`setPaymentDate(?string $paymentDate): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L69)
- [`getUpdatedDateUtc(): ?string`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L75)
- [`setUpdatedDateUtc(?string $updatedDateUtc): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L79)
- [`getReferenceDate(): ?string`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L85)
- [`setReferenceDate(?string $referenceDate): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L89)
- [`getValidationErrors(): array`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L98)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendar.php#L103)

## Payroll\AU\PayrollCalendar\PayrollCalendars

[Source](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L55)
- [`find(string $payrollCalendarId): ?\Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L70)
- [`create(): Sujip\Xero\Payroll\AU\PayrollCalendar\Payload`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L82)
- [`mapPayrollCalendar(array $calendar): Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar`](../../src/Payroll/AU/PayrollCalendar/PayrollCalendars.php#L90)

## Payroll\AU\Settings\Settings

[Source](../../src/Payroll/AU/Settings/Settings.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/Settings/Settings.php#L13)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/AU/Settings/Settings.php#L18)
- [`get(): array`](../../src/Payroll/AU/Settings/Settings.php#L29)

## Payroll\AU\SuperFund\Payload

[Source](../../src/Payroll/AU/SuperFund/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/SuperFund/Payload.php#L21)
- [`id(string $superFundId): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L26)
- [`type(string $type): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L34)
- [`name(string $name): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L42)
- [`uSI(string $usi): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L50)
- [`abn(string $abn): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L58)
- [`bsb(string $bsb): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L66)
- [`accountNumber(string $accountNumber): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L74)
- [`accountName(string $accountName): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L82)
- [`electronicServiceAddress(string $electronicServiceAddress): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L90)
- [`employerNumber(string $employerNumber): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L98)
- [`spin(string $spin): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L106)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/Payload.php#L114)
- [`save(): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/Payload.php#L122)

## Payroll\AU\SuperFund\Product

[Source](../../src/Payroll/AU/SuperFund/Product.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `ABN` | string or null | `setAbn()` |
| `USI` | string or null | `setUsi()` |
| `SPIN` | string or null | `setSpin()` |
| `ProductName` | string or null | `setProductName()` |

### Public methods

- [`__construct(?string $abn = NULL, ?string $usi = NULL, ?string $spin = NULL, ?string $productName = NULL)`](../../src/Payroll/AU/SuperFund/Product.php#L12)
- [`getAbn(): ?string`](../../src/Payroll/AU/SuperFund/Product.php#L20)
- [`setAbn(?string $abn): Sujip\Xero\Payroll\AU\SuperFund\Product`](../../src/Payroll/AU/SuperFund/Product.php#L25)
- [`getUsi(): ?string`](../../src/Payroll/AU/SuperFund/Product.php#L32)
- [`setUsi(?string $usi): Sujip\Xero\Payroll\AU\SuperFund\Product`](../../src/Payroll/AU/SuperFund/Product.php#L37)
- [`getSpin(): ?string`](../../src/Payroll/AU/SuperFund/Product.php#L44)
- [`setSpin(?string $spin): Sujip\Xero\Payroll\AU\SuperFund\Product`](../../src/Payroll/AU/SuperFund/Product.php#L49)
- [`getProductName(): ?string`](../../src/Payroll/AU/SuperFund/Product.php#L56)
- [`setProductName(?string $productName): Sujip\Xero\Payroll\AU\SuperFund\Product`](../../src/Payroll/AU/SuperFund/Product.php#L61)

## Payroll\AU\SuperFund\Products

[Source](../../src/Payroll/AU/SuperFund/Products.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/SuperFund/Products.php#L20)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/AU/SuperFund/Products.php#L25)
- [`abn(string $abn): Sujip\Xero\Payroll\AU\SuperFund\Products`](../../src/Payroll/AU/SuperFund/Products.php#L33)
- [`usi(string $usi): Sujip\Xero\Payroll\AU\SuperFund\Products`](../../src/Payroll/AU/SuperFund/Products.php#L41)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/SuperFund/Products.php#L52)
- [`mapProduct(array $product): Sujip\Xero\Payroll\AU\SuperFund\Product`](../../src/Payroll/AU/SuperFund/Products.php#L71)

## Payroll\AU\SuperFund\SuperFund

[Source](../../src/Payroll/AU/SuperFund/SuperFund.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `SuperFundID` | string or null | `setSuperFundID()` |
| `Type` | string or null | `setType()` |
| `Name` | string or null | `setName()` |
| `ABN` | string or null | `setAbn()` |
| `BSB` | string or null | `setBsb()` |
| `AccountNumber` | string or null | `setAccountNumber()` |
| `AccountName` | string or null | `setAccountName()` |
| `ElectronicServiceAddress` | string or null | `setElectronicServiceAddress()` |
| `EmployerNumber` | string or null | `setEmployerNumber()` |
| `SPIN` | string or null | `setSpin()` |
| `USI` | string or null | `setUsi()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUtc()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?string $superFundID = NULL, ?string $type = NULL, ?string $name = NULL, ?string $abn = NULL, ?string $bsb = NULL, ?string $accountNumber = NULL, ?string $accountName = NULL, ?string $electronicServiceAddress = NULL, ?string $employerNumber = NULL, ?string $spin = NULL, ?string $usi = NULL, ?string $updatedDateUtc = NULL)`](../../src/Payroll/AU/SuperFund/SuperFund.php#L18)
- [`getSuperFundID(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L34)
- [`setSuperFundID(?string $superFundID): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L39)
- [`getType(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L46)
- [`setType(?string $type): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L51)
- [`getName(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L58)
- [`setName(?string $name): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L63)
- [`getAbn(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L70)
- [`setAbn(?string $abn): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L75)
- [`getBsb(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L82)
- [`setBsb(?string $bsb): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L87)
- [`getAccountNumber(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L94)
- [`setAccountNumber(?string $accountNumber): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L99)
- [`getAccountName(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L106)
- [`setAccountName(?string $accountName): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L111)
- [`getElectronicServiceAddress(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L118)
- [`setElectronicServiceAddress(?string $electronicServiceAddress): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L123)
- [`getEmployerNumber(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L130)
- [`setEmployerNumber(?string $employerNumber): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L135)
- [`getSpin(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L142)
- [`setSpin(?string $spin): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L147)
- [`getUsi(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L154)
- [`setUsi(?string $usi): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L159)
- [`getUpdatedDateUtc(): ?string`](../../src/Payroll/AU/SuperFund/SuperFund.php#L166)
- [`setUpdatedDateUtc(?string $updatedDateUtc): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L171)
- [`getValidationErrors(): array`](../../src/Payroll/AU/SuperFund/SuperFund.php#L181)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFund.php#L186)

## Payroll\AU\SuperFund\SuperFunds

[Source](../../src/Payroll/AU/SuperFund/SuperFunds.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/SuperFund/SuperFunds.php#L15)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/AU/SuperFund/SuperFunds.php#L20)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/SuperFund/SuperFunds.php#L31)
- [`find(string $superFundId): ?\Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFunds.php#L46)
- [`create(): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/SuperFunds.php#L58)
- [`update(string $superFundId): Sujip\Xero\Payroll\AU\SuperFund\Payload`](../../src/Payroll/AU/SuperFund/SuperFunds.php#L63)
- [`mapSuperFund(array $fund): Sujip\Xero\Payroll\AU\SuperFund\SuperFund`](../../src/Payroll/AU/SuperFund/SuperFunds.php#L71)

## Payroll\AU\Timesheet\Payload

[Source](../../src/Payroll/AU/Timesheet/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/Timesheet/Payload.php#L21)
- [`id(string $timesheetId): Sujip\Xero\Payroll\AU\Timesheet\Payload`](../../src/Payroll/AU/Timesheet/Payload.php#L26)
- [`employee(string $employeeId): Sujip\Xero\Payroll\AU\Timesheet\Payload`](../../src/Payroll/AU/Timesheet/Payload.php#L34)
- [`startDate(string $startDate): Sujip\Xero\Payroll\AU\Timesheet\Payload`](../../src/Payroll/AU/Timesheet/Payload.php#L42)
- [`endDate(string $endDate): Sujip\Xero\Payroll\AU\Timesheet\Payload`](../../src/Payroll/AU/Timesheet/Payload.php#L50)
- [`status(string $status): Sujip\Xero\Payroll\AU\Timesheet\Payload`](../../src/Payroll/AU/Timesheet/Payload.php#L58)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\AU\Timesheet\Payload`](../../src/Payroll/AU/Timesheet/Payload.php#L66)
- [`save(): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Payload.php#L74)

## Payroll\AU\Timesheet\Timesheet

[Source](../../src/Payroll/AU/Timesheet/Timesheet.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `TimesheetID` | string or null | `setTimesheetID()` |
| `EmployeeID` | string or null | `setEmployeeID()` |
| `StartDate` | string or null | `setStartDate()` |
| `EndDate` | string or null | `setEndDate()` |
| `Status` | string or null | `setStatus()` |
| `Hours` | int, float, or null | `setHours()` |
| `TimesheetLines` | array | `setTimesheetLines()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/AU/Timesheet/Timesheet.php#L33)
- [`getTimesheetID(): ?string`](../../src/Payroll/AU/Timesheet/Timesheet.php#L38)
- [`setTimesheetID(?string $timesheetID): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L43)
- [`getEmployeeID(): ?string`](../../src/Payroll/AU/Timesheet/Timesheet.php#L50)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L55)
- [`getStartDate(): ?string`](../../src/Payroll/AU/Timesheet/Timesheet.php#L62)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L67)
- [`getEndDate(): ?string`](../../src/Payroll/AU/Timesheet/Timesheet.php#L74)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L79)
- [`getStatus(): ?string`](../../src/Payroll/AU/Timesheet/Timesheet.php#L86)
- [`setStatus(?string $status): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L91)
- [`getHours(): ?float`](../../src/Payroll/AU/Timesheet/Timesheet.php#L98)
- [`setHours(?float $hours): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L103)
- [`getTimesheetLines(): array`](../../src/Payroll/AU/Timesheet/Timesheet.php#L113)
- [`setTimesheetLines(array $timesheetLines): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L121)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/AU/Timesheet/Timesheet.php#L128)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L133)
- [`getValidationErrors(): array`](../../src/Payroll/AU/Timesheet/Timesheet.php#L143)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L148)
- [`save(): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheet.php#L173)

## Payroll\AU\Timesheet\Timesheets

[Source](../../src/Payroll/AU/Timesheet/Timesheets.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/AU/Timesheet/Timesheets.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/AU/Timesheet/Timesheets.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/AU/Timesheet/Timesheets.php#L29)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/AU/Timesheet/Timesheets.php#L34)
- [`modifiedSince(\DateTimeInterface $date): Sujip\Xero\Payroll\AU\Timesheet\Timesheets`](../../src/Payroll/AU/Timesheet/Timesheets.php#L42)
- [`where(string $where): Sujip\Xero\Payroll\AU\Timesheet\Timesheets`](../../src/Payroll/AU/Timesheet/Timesheets.php#L50)
- [`orderBy(string $order): Sujip\Xero\Payroll\AU\Timesheet\Timesheets`](../../src/Payroll/AU/Timesheet/Timesheets.php#L58)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/AU/Timesheet/Timesheets.php#L69)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/AU/Timesheet/Timesheets.php#L89)
- [`find(string $timesheetId): ?\Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheets.php#L104)
- [`create(): Sujip\Xero\Payroll\AU\Timesheet\Payload`](../../src/Payroll/AU/Timesheet/Timesheets.php#L116)
- [`update(string $timesheetId): Sujip\Xero\Payroll\AU\Timesheet\Payload`](../../src/Payroll/AU/Timesheet/Timesheets.php#L121)
- [`mapTimesheet(array $timesheet): Sujip\Xero\Payroll\AU\Timesheet\Timesheet`](../../src/Payroll/AU/Timesheet/Timesheets.php#L129)
