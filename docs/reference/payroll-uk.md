# Payroll UK reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Payroll\UK\Employee\Address](#payrollukemployeeaddress)
- [Payroll\UK\Employee\Contract](#payrollukemployeecontract)
- [Payroll\UK\Employee\DevelopmentalRoleDetails](#payrollukemployeedevelopmentalroledetails)
- [Payroll\UK\Employee\EarningsTemplate](#payrollukemployeeearningstemplate)
- [Payroll\UK\Employee\Employee](#payrollukemployeeemployee)
- [Payroll\UK\Employee\EmployeeLeaveType](#payrollukemployeeemployeeleavetype)
- [Payroll\UK\Employee\EmployeeOpeningBalances](#payrollukemployeeemployeeopeningbalances)
- [Payroll\UK\Employee\Employees](#payrollukemployeeemployees)
- [Payroll\UK\Employee\LeavePayload](#payrollukemployeeleavepayload)
- [Payroll\UK\Employee\LeaveTypePayload](#payrollukemployeeleavetypepayload)
- [Payroll\UK\Employee\NICategory](#payrollukemployeenicategory)
- [Payroll\UK\Employee\Payload](#payrollukemployeepayload)
- [Payroll\UK\LeaveType\LeaveType](#payrollukleavetypeleavetype)
- [Payroll\UK\LeaveType\LeaveTypes](#payrollukleavetypeleavetypes)
- [Payroll\UK\PayItem\Benefit](#payrollukpayitembenefit)
- [Payroll\UK\PayItem\Benefits](#payrollukpayitembenefits)
- [Payroll\UK\PayItem\Deduction](#payrollukpayitemdeduction)
- [Payroll\UK\PayItem\Deductions](#payrollukpayitemdeductions)
- [Payroll\UK\PayItem\EarningsOrder](#payrollukpayitemearningsorder)
- [Payroll\UK\PayItem\EarningsOrders](#payrollukpayitemearningsorders)
- [Payroll\UK\PayItem\EarningsRate](#payrollukpayitemearningsrate)
- [Payroll\UK\PayItem\EarningsRates](#payrollukpayitemearningsrates)
- [Payroll\UK\PayRunCalendar\PayRunCalendar](#payrollukpayruncalendarpayruncalendar)
- [Payroll\UK\PayRunCalendar\PayRunCalendars](#payrollukpayruncalendarpayruncalendars)
- [Payroll\UK\PayRun\PayRun](#payrollukpayrunpayrun)
- [Payroll\UK\PayRun\PayRuns](#payrollukpayrunpayruns)
- [Payroll\UK\PayRun\Payload](#payrollukpayrunpayload)
- [Payroll\UK\PayRun\Payslip](#payrollukpayrunpayslip)
- [Payroll\UK\PayRun\Payslips](#payrollukpayrunpayslips)
- [Payroll\UK\PayrollUK](#payrollukpayrolluk)
- [Payroll\UK\Settings\PayrollSettings](#payrolluksettingspayrollsettings)
- [Payroll\UK\Settings\Reimbursement](#payrolluksettingsreimbursement)
- [Payroll\UK\Settings\ReimbursementPayload](#payrolluksettingsreimbursementpayload)
- [Payroll\UK\Settings\Settings](#payrolluksettingssettings)
- [Payroll\UK\Settings\StatutoryLeaveSummary](#payrolluksettingsstatutoryleavesummary)
- [Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave](#payrollukstatutoryleaveemployeestatutorysickleave)
- [Payroll\UK\StatutoryLeave\StatutoryLeaves](#payrollukstatutoryleavestatutoryleaves)
- [Payroll\UK\Timesheet\Payload](#payrolluktimesheetpayload)
- [Payroll\UK\Timesheet\Timesheet](#payrolluktimesheettimesheet)
- [Payroll\UK\Timesheet\TimesheetLine](#payrolluktimesheettimesheetline)
- [Payroll\UK\Timesheet\Timesheets](#payrolluktimesheettimesheets)

## Payroll\UK\Employee\Address

[Source](../../src/Payroll/UK/Employee/Address.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `addressLine1` | string or null | `setAddressLine1()` |
| `addressLine2` | string or null | `setAddressLine2()` |
| `city` | string or null | `setCity()` |
| `postCode` | string or null | `setPostCode()` |
| `countryName` | string or null | `setCountryName()` |

### Public methods

- [`__construct(?string $addressLine1 = NULL, ?string $addressLine2 = NULL, ?string $city = NULL, ?string $postCode = NULL, ?string $countryName = NULL)`](../../src/Payroll/UK/Employee/Address.php#L12)
- [`getAddressLine1(): ?string`](../../src/Payroll/UK/Employee/Address.php#L21)
- [`setAddressLine1(?string $addressLine1): Sujip\Xero\Payroll\UK\Employee\Address`](../../src/Payroll/UK/Employee/Address.php#L26)
- [`getAddressLine2(): ?string`](../../src/Payroll/UK/Employee/Address.php#L33)
- [`setAddressLine2(?string $addressLine2): Sujip\Xero\Payroll\UK\Employee\Address`](../../src/Payroll/UK/Employee/Address.php#L38)
- [`getCity(): ?string`](../../src/Payroll/UK/Employee/Address.php#L45)
- [`setCity(?string $city): Sujip\Xero\Payroll\UK\Employee\Address`](../../src/Payroll/UK/Employee/Address.php#L50)
- [`getPostCode(): ?string`](../../src/Payroll/UK/Employee/Address.php#L57)
- [`setPostCode(?string $postCode): Sujip\Xero\Payroll\UK\Employee\Address`](../../src/Payroll/UK/Employee/Address.php#L62)
- [`getCountryName(): ?string`](../../src/Payroll/UK/Employee/Address.php#L69)
- [`setCountryName(?string $countryName): Sujip\Xero\Payroll\UK\Employee\Address`](../../src/Payroll/UK/Employee/Address.php#L74)

## Payroll\UK\Employee\Contract

[Source](../../src/Payroll/UK/Employee/Contract.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `startDate` | string or null | `setStartDate()` |
| `employmentStatus` | string or null | `setEmploymentStatus()` |
| `contractType` | string or null | `setContractType()` |
| `publicKey` | string or null | `setPublicKey()` |
| `isFixedTerm` | bool or null | `setIsFixedTerm()` |
| `fixedTermEndDate` | string or null | `setFixedTermEndDate()` |
| `developmentalRoleDetails` | object or null ([Payroll\UK\Employee\DevelopmentalRoleDetails](payroll-uk.md#payrollukemployeedevelopmentalroledetails)) | `setDevelopmentalRoleDetails()` |

### Public methods

- [`__construct(?string $startDate = NULL, ?string $employmentStatus = NULL, ?string $contractType = NULL, ?string $publicKey = NULL, ?bool $isFixedTerm = NULL, ?string $fixedTermEndDate = NULL, ?\Sujip\Xero\Payroll\UK\Employee\DevelopmentalRoleDetails $developmentalRoleDetails = NULL)`](../../src/Payroll/UK/Employee/Contract.php#L12)
- [`getStartDate(): ?string`](../../src/Payroll/UK/Employee/Contract.php#L23)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\UK\Employee\Contract`](../../src/Payroll/UK/Employee/Contract.php#L28)
- [`getEmploymentStatus(): ?string`](../../src/Payroll/UK/Employee/Contract.php#L35)
- [`setEmploymentStatus(?string $employmentStatus): Sujip\Xero\Payroll\UK\Employee\Contract`](../../src/Payroll/UK/Employee/Contract.php#L40)
- [`getContractType(): ?string`](../../src/Payroll/UK/Employee/Contract.php#L47)
- [`setContractType(?string $contractType): Sujip\Xero\Payroll\UK\Employee\Contract`](../../src/Payroll/UK/Employee/Contract.php#L52)
- [`getPublicKey(): ?string`](../../src/Payroll/UK/Employee/Contract.php#L59)
- [`setPublicKey(?string $publicKey): Sujip\Xero\Payroll\UK\Employee\Contract`](../../src/Payroll/UK/Employee/Contract.php#L64)
- [`getIsFixedTerm(): ?bool`](../../src/Payroll/UK/Employee/Contract.php#L71)
- [`setIsFixedTerm(?bool $isFixedTerm): Sujip\Xero\Payroll\UK\Employee\Contract`](../../src/Payroll/UK/Employee/Contract.php#L76)
- [`getFixedTermEndDate(): ?string`](../../src/Payroll/UK/Employee/Contract.php#L83)
- [`setFixedTermEndDate(?string $fixedTermEndDate): Sujip\Xero\Payroll\UK\Employee\Contract`](../../src/Payroll/UK/Employee/Contract.php#L88)
- [`getDevelopmentalRoleDetails(): ?\Sujip\Xero\Payroll\UK\Employee\DevelopmentalRoleDetails`](../../src/Payroll/UK/Employee/Contract.php#L95)
- [`setDevelopmentalRoleDetails(?\Sujip\Xero\Payroll\UK\Employee\DevelopmentalRoleDetails $developmentalRoleDetails): Sujip\Xero\Payroll\UK\Employee\Contract`](../../src/Payroll/UK/Employee/Contract.php#L100)

## Payroll\UK\Employee\DevelopmentalRoleDetails

[Source](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `startDate` | string or null | `setStartDate()` |
| `endDate` | string or null | `setEndDate()` |
| `developmentalRole` | string or null | `setDevelopmentalRole()` |
| `publicKey` | string or null | `setPublicKey()` |

### Public methods

- [`__construct(?string $startDate = NULL, ?string $endDate = NULL, ?string $developmentalRole = NULL, ?string $publicKey = NULL)`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L12)
- [`getStartDate(): ?string`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L20)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\UK\Employee\DevelopmentalRoleDetails`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L25)
- [`getEndDate(): ?string`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L32)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\UK\Employee\DevelopmentalRoleDetails`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L37)
- [`getDevelopmentalRole(): ?string`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L44)
- [`setDevelopmentalRole(?string $developmentalRole): Sujip\Xero\Payroll\UK\Employee\DevelopmentalRoleDetails`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L49)
- [`getPublicKey(): ?string`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L56)
- [`setPublicKey(?string $publicKey): Sujip\Xero\Payroll\UK\Employee\DevelopmentalRoleDetails`](../../src/Payroll/UK/Employee/DevelopmentalRoleDetails.php#L61)

## Payroll\UK\Employee\EarningsTemplate

[Source](../../src/Payroll/UK/Employee/EarningsTemplate.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `payTemplateEarningID` | string or null | `()` |
| `ratePerUnit` | int, float, or null | `()` |
| `numberOfUnits` | int, float, or null | `()` |
| `fixedAmount` | int, float, or null | `()` |
| `earningsRateID` | string or null | `()` |
| `name` | string or null | `()` |

### Public methods

- [`getPayTemplateEarningID(): ?string`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L25)
- [`setPayTemplateEarningID(?string $payTemplateEarningID): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L30)
- [`getRatePerUnit(): ?float`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L37)
- [`setRatePerUnit(?float $ratePerUnit): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L42)
- [`getNumberOfUnits(): ?float`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L49)
- [`setNumberOfUnits(?float $numberOfUnits): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L54)
- [`getFixedAmount(): ?float`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L61)
- [`setFixedAmount(?float $fixedAmount): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L66)
- [`getEarningsRateID(): ?string`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L73)
- [`setEarningsRateID(?string $earningsRateID): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L78)
- [`getName(): ?string`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L85)
- [`setName(?string $name): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L90)
- [`toRequest(): array`](../../src/Payroll/UK/Employee/EarningsTemplate.php#L115)

## Payroll\UK\Employee\Employee

[Source](../../src/Payroll/UK/Employee/Employee.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `employeeID` | string or null | `setEmployeeID()` |
| `title` | string or null | `setTitle()` |
| `firstName` | string or null | `setFirstName()` |
| `lastName` | string or null | `setLastName()` |
| `dateOfBirth` | string or null | `setDateOfBirth()` |
| `email` | string or null | `setEmailAddress()` |
| `gender` | string or null | `setGender()` |
| `phoneNumber` | string or null | `setPhoneNumber()` |
| `startDate` | string or null | `setStartDate()` |
| `endDate` | string or null | `setEndDate()` |
| `payrollCalendarID` | string or null | `setPayrollCalendarID()` |
| `updatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `createdDateUTC` | string or null | `setCreatedDateUTC()` |
| `niCategory` | string or null | `setNiCategory()` |
| `nationalInsuranceNumber` | string or null | `setNationalInsuranceNumber()` |
| `isOffPayrollWorker` | bool or null | `setIsOffPayrollWorker()` |
| `address` | object or null ([Payroll\UK\Employee\Address](payroll-uk.md#payrollukemployeeaddress)) | `setAddress()` |
| `niCategories` | list of objects ([Payroll\UK\Employee\NICategory](payroll-uk.md#payrollukemployeenicategory)) | `()` |
| `contracts` | list of objects ([Payroll\UK\Employee\Contract](payroll-uk.md#payrollukemployeecontract)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/UK/Employee/Employee.php#L44)
- [`getEmployeeID(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L49)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L53)
- [`getFirstName(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L58)
- [`setFirstName(?string $firstName): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L62)
- [`getLastName(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L67)
- [`setLastName(?string $lastName): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L71)
- [`getEmailAddress(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L76)
- [`setEmailAddress(?string $emailAddress): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L80)
- [`getTitle(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L85)
- [`setTitle(?string $title): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L89)
- [`getDateOfBirth(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L94)
- [`setDateOfBirth(?string $dateOfBirth): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L98)
- [`getGender(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L103)
- [`setGender(?string $gender): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L107)
- [`getPhoneNumber(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L112)
- [`setPhoneNumber(?string $phoneNumber): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L116)
- [`getStartDate(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L121)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L125)
- [`getEndDate(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L130)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L134)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L139)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L143)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L148)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L152)
- [`getCreatedDateUTC(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L157)
- [`setCreatedDateUTC(?string $createdDateUTC): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L161)
- [`getNiCategory(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L166)
- [`setNiCategory(?string $niCategory): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L170)
- [`getNationalInsuranceNumber(): ?string`](../../src/Payroll/UK/Employee/Employee.php#L175)
- [`setNationalInsuranceNumber(?string $nationalInsuranceNumber): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L179)
- [`getIsOffPayrollWorker(): ?bool`](../../src/Payroll/UK/Employee/Employee.php#L184)
- [`setIsOffPayrollWorker(?bool $isOffPayrollWorker): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L188)
- [`getAddress(): ?\Sujip\Xero\Payroll\UK\Employee\Address`](../../src/Payroll/UK/Employee/Employee.php#L193)
- [`setAddress(?\Sujip\Xero\Payroll\UK\Employee\Address $address): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L197)
- [`getNiCategories(): array`](../../src/Payroll/UK/Employee/Employee.php#L205)
- [`addNiCategory(\Sujip\Xero\Payroll\UK\Employee\NICategory $niCategory): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L209)
- [`getContracts(): array`](../../src/Payroll/UK/Employee/Employee.php#L217)
- [`addContract(\Sujip\Xero\Payroll\UK\Employee\Contract $contract): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L221)
- [`save(): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employee.php#L254)
- [`leaveBalances(): array`](../../src/Payroll/UK/Employee/Employee.php#L276)
- [`statutoryLeaveBalance(?string $leaveType = NULL, ?string $asOfDate = NULL): array`](../../src/Payroll/UK/Employee/Employee.php#L284)
- [`leaves(): array`](../../src/Payroll/UK/Employee/Employee.php#L292)
- [`leave(string $leaveId): array`](../../src/Payroll/UK/Employee/Employee.php#L300)
- [`paymentMethod(): array`](../../src/Payroll/UK/Employee/Employee.php#L308)
- [`leaveTypes(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/Employee/Employee.php#L316)
- [`createLeave(): Sujip\Xero\Payroll\UK\Employee\LeavePayload`](../../src/Payroll/UK/Employee/Employee.php#L323)
- [`createLeaveType(): Sujip\Xero\Payroll\UK\Employee\LeaveTypePayload`](../../src/Payroll/UK/Employee/Employee.php#L330)

## Payroll\UK\Employee\EmployeeLeaveType

[Source](../../src/Payroll/UK/Employee/EmployeeLeaveType.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `leaveTypeID` | string or null | `setLeaveTypeID()` |
| `scheduleOfAccrual` | string or null | `setScheduleOfAccrual()` |
| `hoursAccruedAnnually` | int, float, or null | `setHoursAccruedAnnually()` |
| `maximumToAccrue` | int, float, or null | `setMaximumToAccrue()` |
| `openingBalance` | int, float, or null | `setOpeningBalance()` |
| `rateAccruedHourly` | int, float, or null | `setRateAccruedHourly()` |
| `scheduleOfAccrualDate` | string or null | `setScheduleOfAccrualDate()` |

### Public methods

- [`__construct(?string $leaveTypeID = NULL, ?string $scheduleOfAccrual = NULL, ?float $hoursAccruedAnnually = NULL, ?float $maximumToAccrue = NULL, ?float $openingBalance = NULL, ?float $rateAccruedHourly = NULL, ?string $scheduleOfAccrualDate = NULL)`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L12)
- [`getLeaveTypeID(): ?string`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L23)
- [`setLeaveTypeID(?string $leaveTypeID): Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L28)
- [`getScheduleOfAccrual(): ?string`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L35)
- [`setScheduleOfAccrual(?string $scheduleOfAccrual): Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L40)
- [`getHoursAccruedAnnually(): ?float`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L47)
- [`setHoursAccruedAnnually(?float $hoursAccruedAnnually): Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L52)
- [`getMaximumToAccrue(): ?float`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L59)
- [`setMaximumToAccrue(?float $maximumToAccrue): Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L64)
- [`getOpeningBalance(): ?float`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L71)
- [`setOpeningBalance(?float $openingBalance): Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L76)
- [`getRateAccruedHourly(): ?float`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L83)
- [`setRateAccruedHourly(?float $rateAccruedHourly): Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L88)
- [`getScheduleOfAccrualDate(): ?string`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L95)
- [`setScheduleOfAccrualDate(?string $scheduleOfAccrualDate): Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType`](../../src/Payroll/UK/Employee/EmployeeLeaveType.php#L100)

## Payroll\UK\Employee\EmployeeOpeningBalances

[Source](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `statutoryAdoptionPay` | int, float, or null | `()` |
| `statutoryMaternityPay` | int, float, or null | `()` |
| `statutoryPaternityPay` | int, float, or null | `()` |
| `statutorySharedParentalPay` | int, float, or null | `()` |
| `statutorySickPay` | int, float, or null | `()` |
| `priorEmployeeNumber` | int, float, or null | `()` |

### Public methods

- [`getStatutoryAdoptionPay(): ?float`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L25)
- [`setStatutoryAdoptionPay(?float $statutoryAdoptionPay): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L30)
- [`getStatutoryMaternityPay(): ?float`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L37)
- [`setStatutoryMaternityPay(?float $statutoryMaternityPay): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L42)
- [`getStatutoryPaternityPay(): ?float`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L49)
- [`setStatutoryPaternityPay(?float $statutoryPaternityPay): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L54)
- [`getStatutorySharedParentalPay(): ?float`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L61)
- [`setStatutorySharedParentalPay(?float $statutorySharedParentalPay): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L66)
- [`getStatutorySickPay(): ?float`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L73)
- [`setStatutorySickPay(?float $statutorySickPay): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L78)
- [`getPriorEmployeeNumber(): ?float`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L85)
- [`setPriorEmployeeNumber(?float $priorEmployeeNumber): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L90)
- [`toRequest(): array`](../../src/Payroll/UK/Employee/EmployeeOpeningBalances.php#L115)

## Payroll\UK\Employee\Employees

[Source](../../src/Payroll/UK/Employee/Employees.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/Employee/Employees.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/Employee/Employees.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/Employee/Employees.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/Employee/Employees.php#L30)
- [`filter(string $filter): Sujip\Xero\Payroll\UK\Employee\Employees`](../../src/Payroll/UK/Employee/Employees.php#L38)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/Employee/Employees.php#L49)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/Employee/Employees.php#L65)
- [`find(string $employeeId): ?\Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employees.php#L80)
- [`create(): Sujip\Xero\Payroll\UK\Employee\Payload`](../../src/Payroll/UK/Employee/Employees.php#L92)
- [`update(string $employeeId): Sujip\Xero\Payroll\UK\Employee\Payload`](../../src/Payroll/UK/Employee/Employees.php#L97)
- [`payTemplate(string $employeeId): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/Employee/Employees.php#L105)
- [`createEarningsTemplate(string $employeeId, \Sujip\Xero\Payroll\UK\Employee\EarningsTemplate $template, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/Employees.php#L120)
- [`updateEarningsTemplate(string $employeeId, string $payTemplateEarningId, \Sujip\Xero\Payroll\UK\Employee\EarningsTemplate $template, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/Employees.php#L132)
- [`deleteEarningsTemplate(string $employeeId, string $payTemplateEarningId): bool`](../../src/Payroll/UK/Employee/Employees.php#L144)
- [`createEarningsTemplates(string $employeeId, array $templates, ?string $idempotencyKey = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/Employee/Employees.php#L157)
- [`openingBalances(string $employeeId): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/Employees.php#L177)
- [`createOpeningBalances(string $employeeId, \Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances $balances, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/Employees.php#L187)
- [`updateOpeningBalances(string $employeeId, \Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances $balances, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/Employees.php#L199)
- [`leaveBalances(string $employeeId): array`](../../src/Payroll/UK/Employee/Employees.php#L214)
- [`statutoryLeaveBalance(string $employeeId, ?string $leaveType = NULL, ?string $asOfDate = NULL): array`](../../src/Payroll/UK/Employee/Employees.php#L225)
- [`leaves(string $employeeId): array`](../../src/Payroll/UK/Employee/Employees.php#L247)
- [`leave(string $employeeId, string $leaveId): array`](../../src/Payroll/UK/Employee/Employees.php#L258)
- [`paymentMethod(string $employeeId): array`](../../src/Payroll/UK/Employee/Employees.php#L269)
- [`leaveTypes(string $employeeId): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/Employee/Employees.php#L280)
- [`createLeave(string $employeeId): Sujip\Xero\Payroll\UK\Employee\LeavePayload`](../../src/Payroll/UK/Employee/Employees.php#L295)
- [`createLeaveType(string $employeeId): Sujip\Xero\Payroll\UK\Employee\LeaveTypePayload`](../../src/Payroll/UK/Employee/Employees.php#L300)
- [`updateLeave(string $employeeId, string $leaveId, array $leave, ?string $idempotencyKey = NULL): array`](../../src/Payroll/UK/Employee/Employees.php#L309)
- [`deleteLeave(string $employeeId, string $leaveId): array`](../../src/Payroll/UK/Employee/Employees.php#L322)
- [`updateSalaryAndWage(string $employeeId, string $salaryAndWagesId, array $salary, ?string $idempotencyKey = NULL): array`](../../src/Payroll/UK/Employee/Employees.php#L334)
- [`deleteSalaryAndWage(string $employeeId, string $salaryAndWagesId): bool`](../../src/Payroll/UK/Employee/Employees.php#L344)
- [`createEmployment(string $employeeId, array $employment, ?string $idempotencyKey = NULL): array`](../../src/Payroll/UK/Employee/Employees.php#L357)
- [`createPaymentMethod(string $employeeId, array $paymentMethod, ?string $idempotencyKey = NULL): array`](../../src/Payroll/UK/Employee/Employees.php#L371)
- [`createSalaryAndWage(string $employeeId, array $salary, ?string $idempotencyKey = NULL): array`](../../src/Payroll/UK/Employee/Employees.php#L385)
- [`tax(string $employeeId): array`](../../src/Payroll/UK/Employee/Employees.php#L398)
- [`leavePeriods(string $employeeId, string $startDate, string $endDate): array`](../../src/Payroll/UK/Employee/Employees.php#L409)
- [`salaryAndWages(string $employeeId, int $page = 1): array`](../../src/Payroll/UK/Employee/Employees.php#L421)
- [`salaryAndWage(string $employeeId, string $salaryAndWagesId): array`](../../src/Payroll/UK/Employee/Employees.php#L433)
- [`mapEmployee(array $employee): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Employees.php#L444)
- [`mapLeaveType(array $leaveType): Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType`](../../src/Payroll/UK/Employee/Employees.php#L452)
- [`mapEarningsTemplate(array $template): Sujip\Xero\Payroll\UK\Employee\EarningsTemplate`](../../src/Payroll/UK/Employee/Employees.php#L460)
- [`mapOpeningBalances(array $balances): Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances`](../../src/Payroll/UK/Employee/Employees.php#L468)

## Payroll\UK\Employee\LeavePayload

[Source](../../src/Payroll/UK/Employee/LeavePayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/UK/Employee/LeavePayload.php#L18)
- [`leaveType(string $leaveTypeId): Sujip\Xero\Payroll\UK\Employee\LeavePayload`](../../src/Payroll/UK/Employee/LeavePayload.php#L24)
- [`startDate(string $startDate): Sujip\Xero\Payroll\UK\Employee\LeavePayload`](../../src/Payroll/UK/Employee/LeavePayload.php#L32)
- [`endDate(string $endDate): Sujip\Xero\Payroll\UK\Employee\LeavePayload`](../../src/Payroll/UK/Employee/LeavePayload.php#L40)
- [`title(string $title): Sujip\Xero\Payroll\UK\Employee\LeavePayload`](../../src/Payroll/UK/Employee/LeavePayload.php#L48)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\UK\Employee\LeavePayload`](../../src/Payroll/UK/Employee/LeavePayload.php#L56)
- [`save(): array`](../../src/Payroll/UK/Employee/LeavePayload.php#L67)

## Payroll\UK\Employee\LeaveTypePayload

[Source](../../src/Payroll/UK/Employee/LeaveTypePayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/UK/Employee/LeaveTypePayload.php#L18)
- [`leaveType(string $leaveTypeId): Sujip\Xero\Payroll\UK\Employee\LeaveTypePayload`](../../src/Payroll/UK/Employee/LeaveTypePayload.php#L24)
- [`scheduleOfAccrual(string $schedule): Sujip\Xero\Payroll\UK\Employee\LeaveTypePayload`](../../src/Payroll/UK/Employee/LeaveTypePayload.php#L32)
- [`openingBalance(float $openingBalance): Sujip\Xero\Payroll\UK\Employee\LeaveTypePayload`](../../src/Payroll/UK/Employee/LeaveTypePayload.php#L40)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\UK\Employee\LeaveTypePayload`](../../src/Payroll/UK/Employee/LeaveTypePayload.php#L48)
- [`save(): array`](../../src/Payroll/UK/Employee/LeaveTypePayload.php#L59)

## Payroll\UK\Employee\NICategory

[Source](../../src/Payroll/UK/Employee/NICategory.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `startDate` | string or null | `setStartDate()` |
| `niCategory` | string or null | `setNiCategory()` |
| `niCategoryID` | int, float, or null | `setNiCategoryID()` |
| `dateFirstEmployedAsCivilian` | string or null | `setDateFirstEmployedAsCivilian()` |
| `workplacePostcode` | string or null | `setWorkplacePostcode()` |

### Public methods

- [`__construct(?string $startDate = NULL, ?string $niCategory = NULL, ?float $niCategoryID = NULL, ?string $dateFirstEmployedAsCivilian = NULL, ?string $workplacePostcode = NULL)`](../../src/Payroll/UK/Employee/NICategory.php#L12)
- [`getStartDate(): ?string`](../../src/Payroll/UK/Employee/NICategory.php#L21)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\UK\Employee\NICategory`](../../src/Payroll/UK/Employee/NICategory.php#L26)
- [`getNiCategory(): ?string`](../../src/Payroll/UK/Employee/NICategory.php#L33)
- [`setNiCategory(?string $niCategory): Sujip\Xero\Payroll\UK\Employee\NICategory`](../../src/Payroll/UK/Employee/NICategory.php#L38)
- [`getNiCategoryID(): ?float`](../../src/Payroll/UK/Employee/NICategory.php#L45)
- [`setNiCategoryID(?float $niCategoryID): Sujip\Xero\Payroll\UK\Employee\NICategory`](../../src/Payroll/UK/Employee/NICategory.php#L50)
- [`getDateFirstEmployedAsCivilian(): ?string`](../../src/Payroll/UK/Employee/NICategory.php#L57)
- [`setDateFirstEmployedAsCivilian(?string $dateFirstEmployedAsCivilian): Sujip\Xero\Payroll\UK\Employee\NICategory`](../../src/Payroll/UK/Employee/NICategory.php#L62)
- [`getWorkplacePostcode(): ?string`](../../src/Payroll/UK/Employee/NICategory.php#L69)
- [`setWorkplacePostcode(?string $workplacePostcode): Sujip\Xero\Payroll\UK\Employee\NICategory`](../../src/Payroll/UK/Employee/NICategory.php#L74)

## Payroll\UK\Employee\Payload

[Source](../../src/Payroll/UK/Employee/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/Employee/Payload.php#L21)
- [`id(string $employeeId): Sujip\Xero\Payroll\UK\Employee\Payload`](../../src/Payroll/UK/Employee/Payload.php#L26)
- [`firstName(string $firstName): Sujip\Xero\Payroll\UK\Employee\Payload`](../../src/Payroll/UK/Employee/Payload.php#L34)
- [`lastName(string $lastName): Sujip\Xero\Payroll\UK\Employee\Payload`](../../src/Payroll/UK/Employee/Payload.php#L42)
- [`emailAddress(string $emailAddress): Sujip\Xero\Payroll\UK\Employee\Payload`](../../src/Payroll/UK/Employee/Payload.php#L50)
- [`dateOfBirth(string $dateOfBirth): Sujip\Xero\Payroll\UK\Employee\Payload`](../../src/Payroll/UK/Employee/Payload.php#L58)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\UK\Employee\Payload`](../../src/Payroll/UK/Employee/Payload.php#L66)
- [`save(): Sujip\Xero\Payroll\UK\Employee\Employee`](../../src/Payroll/UK/Employee/Payload.php#L74)

## Payroll\UK\LeaveType\LeaveType

[Source](../../src/Payroll/UK/LeaveType/LeaveType.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `leaveID` | string or null | `setLeaveID()` |
| `leaveTypeID` | string or null | `setLeaveTypeID()` |
| `name` | string or null | `setName()` |
| `isPaidLeave` | bool or null | `setIsPaidLeave()` |
| `showOnPayslip` | bool or null | `setShowOnPayslip()` |
| `updatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `isActive` | bool or null | `setIsActive()` |
| `isStatutoryLeave` | bool or null | `setIsStatutoryLeave()` |

### Public methods

- [`__construct(?string $leaveID = NULL, ?string $leaveTypeID = NULL, ?string $name = NULL, ?bool $isPaidLeave = NULL, ?bool $showOnPayslip = NULL, ?string $updatedDateUTC = NULL, ?bool $isActive = NULL, ?bool $isStatutoryLeave = NULL)`](../../src/Payroll/UK/LeaveType/LeaveType.php#L12)
- [`getLeaveID(): ?string`](../../src/Payroll/UK/LeaveType/LeaveType.php#L24)
- [`setLeaveID(?string $leaveID): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveType.php#L29)
- [`getLeaveTypeID(): ?string`](../../src/Payroll/UK/LeaveType/LeaveType.php#L36)
- [`setLeaveTypeID(?string $leaveTypeID): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveType.php#L41)
- [`getName(): ?string`](../../src/Payroll/UK/LeaveType/LeaveType.php#L48)
- [`setName(?string $name): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveType.php#L53)
- [`getIsPaidLeave(): ?bool`](../../src/Payroll/UK/LeaveType/LeaveType.php#L60)
- [`setIsPaidLeave(?bool $isPaidLeave): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveType.php#L65)
- [`getShowOnPayslip(): ?bool`](../../src/Payroll/UK/LeaveType/LeaveType.php#L72)
- [`setShowOnPayslip(?bool $showOnPayslip): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveType.php#L77)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/UK/LeaveType/LeaveType.php#L84)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveType.php#L89)
- [`getIsActive(): ?bool`](../../src/Payroll/UK/LeaveType/LeaveType.php#L96)
- [`setIsActive(?bool $isActive): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveType.php#L101)
- [`getIsStatutoryLeave(): ?bool`](../../src/Payroll/UK/LeaveType/LeaveType.php#L108)
- [`setIsStatutoryLeave(?bool $isStatutoryLeave): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveType.php#L113)

## Payroll\UK\LeaveType\LeaveTypes

[Source](../../src/Payroll/UK/LeaveType/LeaveTypes.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/LeaveType/LeaveTypes.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/LeaveType/LeaveTypes.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/LeaveType/LeaveTypes.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/LeaveType/LeaveTypes.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/LeaveType/LeaveTypes.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/LeaveType/LeaveTypes.php#L55)
- [`create(array $leaveType, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveTypes.php#L73)
- [`mapLeaveType(array $leaveType): Sujip\Xero\Payroll\UK\LeaveType\LeaveType`](../../src/Payroll/UK/LeaveType/LeaveTypes.php#L90)

## Payroll\UK\PayItem\Benefit

[Source](../../src/Payroll/UK/PayItem/Benefit.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `()` |
| `name` | string or null | `()` |
| `category` | string or null | `()` |
| `liabilityAccountId` | string or null | `()` |
| `expenseAccountId` | string or null | `()` |
| `standardAmount` | int, float, or null | `()` |
| `percentage` | int, float, or null | `()` |
| `calculationType` | string or null | `()` |
| `currentRecord` | bool or null | `()` |
| `subjectToNIC` | bool or null | `()` |
| `subjectToPension` | bool or null | `()` |
| `subjectToTax` | bool or null | `()` |
| `isCalculatingOnQualifyingEarnings` | bool or null | `()` |
| `showBalanceToEmployee` | bool or null | `()` |

### Public methods

- [`getId(): ?string`](../../src/Payroll/UK/PayItem/Benefit.php#L41)
- [`setId(?string $id): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L46)
- [`getName(): ?string`](../../src/Payroll/UK/PayItem/Benefit.php#L53)
- [`setName(?string $name): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L58)
- [`getCategory(): ?string`](../../src/Payroll/UK/PayItem/Benefit.php#L65)
- [`setCategory(?string $category): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L70)
- [`getLiabilityAccountId(): ?string`](../../src/Payroll/UK/PayItem/Benefit.php#L77)
- [`setLiabilityAccountId(?string $liabilityAccountId): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L82)
- [`getExpenseAccountId(): ?string`](../../src/Payroll/UK/PayItem/Benefit.php#L89)
- [`setExpenseAccountId(?string $expenseAccountId): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L94)
- [`getStandardAmount(): ?float`](../../src/Payroll/UK/PayItem/Benefit.php#L101)
- [`setStandardAmount(?float $standardAmount): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L106)
- [`getPercentage(): ?float`](../../src/Payroll/UK/PayItem/Benefit.php#L113)
- [`setPercentage(?float $percentage): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L118)
- [`getCalculationType(): ?string`](../../src/Payroll/UK/PayItem/Benefit.php#L125)
- [`setCalculationType(?string $calculationType): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L130)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/UK/PayItem/Benefit.php#L137)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L142)
- [`getSubjectToNIC(): ?bool`](../../src/Payroll/UK/PayItem/Benefit.php#L149)
- [`setSubjectToNIC(?bool $subjectToNIC): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L154)
- [`getSubjectToPension(): ?bool`](../../src/Payroll/UK/PayItem/Benefit.php#L161)
- [`setSubjectToPension(?bool $subjectToPension): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L166)
- [`getSubjectToTax(): ?bool`](../../src/Payroll/UK/PayItem/Benefit.php#L173)
- [`setSubjectToTax(?bool $subjectToTax): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L178)
- [`getIsCalculatingOnQualifyingEarnings(): ?bool`](../../src/Payroll/UK/PayItem/Benefit.php#L185)
- [`setIsCalculatingOnQualifyingEarnings(?bool $isCalculatingOnQualifyingEarnings): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L190)
- [`getShowBalanceToEmployee(): ?bool`](../../src/Payroll/UK/PayItem/Benefit.php#L197)
- [`setShowBalanceToEmployee(?bool $showBalanceToEmployee): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefit.php#L202)
- [`toRequest(): array`](../../src/Payroll/UK/PayItem/Benefit.php#L235)

## Payroll\UK\PayItem\Benefits

[Source](../../src/Payroll/UK/PayItem/Benefits.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/PayItem/Benefits.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/PayItem/Benefits.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/PayItem/Benefits.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/PayItem/Benefits.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/PayItem/Benefits.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/PayItem/Benefits.php#L55)
- [`find(string $benefitId): ?\Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefits.php#L70)
- [`create(\Sujip\Xero\Payroll\UK\PayItem\Benefit $benefit, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefits.php#L82)
- [`mapBenefit(array $benefit): Sujip\Xero\Payroll\UK\PayItem\Benefit`](../../src/Payroll/UK/PayItem/Benefits.php#L99)

## Payroll\UK\PayItem\Deduction

[Source](../../src/Payroll/UK/PayItem/Deduction.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `deductionId` | string or null | `()` |
| `deductionName` | string or null | `()` |
| `deductionCategory` | string or null | `()` |
| `liabilityAccountId` | string or null | `()` |
| `currentRecord` | bool or null | `()` |
| `standardAmount` | int, float, or null | `()` |
| `reducesSuperLiability` | bool or null | `()` |
| `reducesTaxLiability` | bool or null | `()` |
| `calculationType` | string or null | `()` |
| `percentage` | int, float, or null | `()` |
| `subjectToNIC` | bool or null | `()` |
| `subjectToTax` | bool or null | `()` |
| `isReducedByBasicRate` | bool or null | `()` |
| `applyToPensionCalculations` | bool or null | `()` |
| `isCalculatingOnQualifyingEarnings` | bool or null | `()` |
| `isPension` | bool or null | `()` |

### Public methods

- [`getDeductionId(): ?string`](../../src/Payroll/UK/PayItem/Deduction.php#L45)
- [`setDeductionId(?string $deductionId): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L50)
- [`getDeductionName(): ?string`](../../src/Payroll/UK/PayItem/Deduction.php#L57)
- [`setDeductionName(?string $deductionName): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L62)
- [`getDeductionCategory(): ?string`](../../src/Payroll/UK/PayItem/Deduction.php#L69)
- [`setDeductionCategory(?string $deductionCategory): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L74)
- [`getLiabilityAccountId(): ?string`](../../src/Payroll/UK/PayItem/Deduction.php#L81)
- [`setLiabilityAccountId(?string $liabilityAccountId): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L86)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L93)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L98)
- [`getStandardAmount(): ?float`](../../src/Payroll/UK/PayItem/Deduction.php#L105)
- [`setStandardAmount(?float $standardAmount): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L110)
- [`getReducesSuperLiability(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L117)
- [`setReducesSuperLiability(?bool $reducesSuperLiability): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L122)
- [`getReducesTaxLiability(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L129)
- [`setReducesTaxLiability(?bool $reducesTaxLiability): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L134)
- [`getCalculationType(): ?string`](../../src/Payroll/UK/PayItem/Deduction.php#L141)
- [`setCalculationType(?string $calculationType): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L146)
- [`getPercentage(): ?float`](../../src/Payroll/UK/PayItem/Deduction.php#L153)
- [`setPercentage(?float $percentage): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L158)
- [`getSubjectToNIC(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L165)
- [`setSubjectToNIC(?bool $subjectToNIC): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L170)
- [`getSubjectToTax(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L177)
- [`setSubjectToTax(?bool $subjectToTax): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L182)
- [`getIsReducedByBasicRate(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L189)
- [`setIsReducedByBasicRate(?bool $isReducedByBasicRate): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L194)
- [`getApplyToPensionCalculations(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L201)
- [`setApplyToPensionCalculations(?bool $applyToPensionCalculations): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L206)
- [`getIsCalculatingOnQualifyingEarnings(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L213)
- [`setIsCalculatingOnQualifyingEarnings(?bool $isCalculatingOnQualifyingEarnings): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L218)
- [`getIsPension(): ?bool`](../../src/Payroll/UK/PayItem/Deduction.php#L225)
- [`setIsPension(?bool $isPension): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deduction.php#L230)
- [`toRequest(): array`](../../src/Payroll/UK/PayItem/Deduction.php#L265)

## Payroll\UK\PayItem\Deductions

[Source](../../src/Payroll/UK/PayItem/Deductions.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/PayItem/Deductions.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/PayItem/Deductions.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/PayItem/Deductions.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/PayItem/Deductions.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/PayItem/Deductions.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/PayItem/Deductions.php#L55)
- [`find(string $deductionId): ?\Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deductions.php#L70)
- [`create(\Sujip\Xero\Payroll\UK\PayItem\Deduction $deduction, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deductions.php#L82)
- [`mapDeduction(array $deduction): Sujip\Xero\Payroll\UK\PayItem\Deduction`](../../src/Payroll/UK/PayItem/Deductions.php#L99)

## Payroll\UK\PayItem\EarningsOrder

[Source](../../src/Payroll/UK/PayItem/EarningsOrder.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `()` |
| `name` | string or null | `()` |
| `statutoryDeductionCategory` | string or null | `()` |
| `liabilityAccountId` | string or null | `()` |
| `currentRecord` | bool or null | `()` |

### Public methods

- [`getId(): ?string`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L22)
- [`setId(?string $id): Sujip\Xero\Payroll\UK\PayItem\EarningsOrder`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L27)
- [`getName(): ?string`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L34)
- [`setName(?string $name): Sujip\Xero\Payroll\UK\PayItem\EarningsOrder`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L39)
- [`getStatutoryDeductionCategory(): ?string`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L46)
- [`setStatutoryDeductionCategory(?string $statutoryDeductionCategory): Sujip\Xero\Payroll\UK\PayItem\EarningsOrder`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L51)
- [`getLiabilityAccountId(): ?string`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L58)
- [`setLiabilityAccountId(?string $liabilityAccountId): Sujip\Xero\Payroll\UK\PayItem\EarningsOrder`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L63)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L70)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\UK\PayItem\EarningsOrder`](../../src/Payroll/UK/PayItem/EarningsOrder.php#L75)

## Payroll\UK\PayItem\EarningsOrders

[Source](../../src/Payroll/UK/PayItem/EarningsOrders.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/PayItem/EarningsOrders.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/PayItem/EarningsOrders.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/PayItem/EarningsOrders.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/PayItem/EarningsOrders.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/PayItem/EarningsOrders.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/PayItem/EarningsOrders.php#L55)
- [`find(string $earningsOrderId): ?\Sujip\Xero\Payroll\UK\PayItem\EarningsOrder`](../../src/Payroll/UK/PayItem/EarningsOrders.php#L70)
- [`mapEarningsOrder(array $earningsOrder): Sujip\Xero\Payroll\UK\PayItem\EarningsOrder`](../../src/Payroll/UK/PayItem/EarningsOrders.php#L85)

## Payroll\UK\PayItem\EarningsRate

[Source](../../src/Payroll/UK/PayItem/EarningsRate.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `earningsRateID` | string or null | `()` |
| `name` | string or null | `()` |
| `earningsType` | string or null | `()` |
| `rateType` | string or null | `()` |
| `typeOfUnits` | string or null | `()` |
| `currentRecord` | bool or null | `()` |
| `expenseAccountID` | string or null | `()` |
| `ratePerUnit` | int, float, or null | `()` |
| `multipleOfOrdinaryEarningsRate` | int, float, or null | `()` |
| `fixedAmount` | int, float, or null | `()` |

### Public methods

- [`getEarningsRateID(): ?string`](../../src/Payroll/UK/PayItem/EarningsRate.php#L33)
- [`setEarningsRateID(?string $earningsRateID): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L38)
- [`getName(): ?string`](../../src/Payroll/UK/PayItem/EarningsRate.php#L45)
- [`setName(?string $name): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L50)
- [`getEarningsType(): ?string`](../../src/Payroll/UK/PayItem/EarningsRate.php#L57)
- [`setEarningsType(?string $earningsType): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L62)
- [`getRateType(): ?string`](../../src/Payroll/UK/PayItem/EarningsRate.php#L69)
- [`setRateType(?string $rateType): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L74)
- [`getTypeOfUnits(): ?string`](../../src/Payroll/UK/PayItem/EarningsRate.php#L81)
- [`setTypeOfUnits(?string $typeOfUnits): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L86)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/UK/PayItem/EarningsRate.php#L93)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L98)
- [`getExpenseAccountID(): ?string`](../../src/Payroll/UK/PayItem/EarningsRate.php#L105)
- [`setExpenseAccountID(?string $expenseAccountID): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L110)
- [`getRatePerUnit(): ?float`](../../src/Payroll/UK/PayItem/EarningsRate.php#L117)
- [`setRatePerUnit(?float $ratePerUnit): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L122)
- [`getMultipleOfOrdinaryEarningsRate(): ?float`](../../src/Payroll/UK/PayItem/EarningsRate.php#L129)
- [`setMultipleOfOrdinaryEarningsRate(?float $multipleOfOrdinaryEarningsRate): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L134)
- [`getFixedAmount(): ?float`](../../src/Payroll/UK/PayItem/EarningsRate.php#L141)
- [`setFixedAmount(?float $fixedAmount): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRate.php#L146)
- [`toRequest(): array`](../../src/Payroll/UK/PayItem/EarningsRate.php#L175)

## Payroll\UK\PayItem\EarningsRates

[Source](../../src/Payroll/UK/PayItem/EarningsRates.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/PayItem/EarningsRates.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/PayItem/EarningsRates.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/PayItem/EarningsRates.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/PayItem/EarningsRates.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/PayItem/EarningsRates.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/PayItem/EarningsRates.php#L55)
- [`find(string $earningsRateId): ?\Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRates.php#L70)
- [`create(\Sujip\Xero\Payroll\UK\PayItem\EarningsRate $earningsRate, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRates.php#L82)
- [`mapEarningsRate(array $earningsRate): Sujip\Xero\Payroll\UK\PayItem\EarningsRate`](../../src/Payroll/UK/PayItem/EarningsRates.php#L99)

## Payroll\UK\PayRunCalendar\PayRunCalendar

[Source](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `payrollCalendarID` | string or null | `setPayrollCalendarID()` |
| `name` | string or null | `setName()` |
| `calendarType` | string or null | `setCalendarType()` |
| `periodStartDate` | string or null | `setPeriodStartDate()` |
| `periodEndDate` | string or null | `setPeriodEndDate()` |
| `paymentDate` | string or null | `setPaymentDate()` |
| `updatedDateUTC` | string or null | `setUpdatedDateUTC()` |

### Public methods

- [`__construct(?string $payrollCalendarID = NULL, ?string $name = NULL, ?string $calendarType = NULL, ?string $periodStartDate = NULL, ?string $periodEndDate = NULL, ?string $paymentDate = NULL, ?string $updatedDateUTC = NULL)`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L12)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L23)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L28)
- [`getName(): ?string`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L35)
- [`setName(?string $name): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L40)
- [`getCalendarType(): ?string`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L47)
- [`setCalendarType(?string $calendarType): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L52)
- [`getPeriodStartDate(): ?string`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L59)
- [`setPeriodStartDate(?string $periodStartDate): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L64)
- [`getPeriodEndDate(): ?string`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L71)
- [`setPeriodEndDate(?string $periodEndDate): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L76)
- [`getPaymentDate(): ?string`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L83)
- [`setPaymentDate(?string $paymentDate): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L88)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L95)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendar.php#L100)

## Payroll\UK\PayRunCalendar\PayRunCalendars

[Source](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L55)
- [`find(string $payRunCalendarId): ?\Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L70)
- [`create(array $calendar, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L85)
- [`mapPayRunCalendar(array $calendar): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar`](../../src/Payroll/UK/PayRunCalendar/PayRunCalendars.php#L102)

## Payroll\UK\PayRun\PayRun

[Source](../../src/Payroll/UK/PayRun/PayRun.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `payRunID` | string or null | `setPayRunID()` |
| `payrollCalendarID` | string or null | `setPayrollCalendarID()` |
| `periodStartDate` | string or null | `setPeriodStartDate()` |
| `periodEndDate` | string or null | `setPeriodEndDate()` |
| `paymentDate` | string or null | `setPaymentDate()` |
| `totalCost` | int, float, or null | `setTotalCost()` |
| `totalPay` | int, float, or null | `setTotalPay()` |
| `payRunStatus` | string or null | `setPayRunStatus()` |
| `payRunType` | string or null | `setPayRunType()` |
| `calendarType` | string or null | `setCalendarType()` |
| `postedDateTime` | string or null | `setPostedDateTime()` |
| `paySlips` | list of objects ([Payroll\UK\PayRun\Payslip](payroll-uk.md#payrollukpayrunpayslip)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/UK/PayRun/PayRun.php#L31)
- [`getPayRunID(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L36)
- [`setPayRunID(?string $payRunID): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L41)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L48)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L53)
- [`getPayRunStatus(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L60)
- [`setPayRunStatus(?string $payRunStatus): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L65)
- [`getPaymentDate(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L72)
- [`setPaymentDate(?string $paymentDate): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L77)
- [`getPeriodStartDate(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L84)
- [`setPeriodStartDate(?string $periodStartDate): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L89)
- [`getPeriodEndDate(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L96)
- [`setPeriodEndDate(?string $periodEndDate): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L101)
- [`getTotalCost(): int\|float\|null`](../../src/Payroll/UK/PayRun/PayRun.php#L108)
- [`setTotalCost(int\|float\|null $totalCost): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L113)
- [`getTotalPay(): int\|float\|null`](../../src/Payroll/UK/PayRun/PayRun.php#L120)
- [`setTotalPay(int\|float\|null $totalPay): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L125)
- [`getPayRunType(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L132)
- [`setPayRunType(?string $payRunType): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L137)
- [`getCalendarType(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L144)
- [`setCalendarType(?string $calendarType): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L149)
- [`getPostedDateTime(): ?string`](../../src/Payroll/UK/PayRun/PayRun.php#L156)
- [`setPostedDateTime(?string $postedDateTime): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L161)
- [`getPaySlips(): array`](../../src/Payroll/UK/PayRun/PayRun.php#L171)
- [`addPaySlip(\Sujip\Xero\Payroll\UK\PayRun\Payslip $paySlip): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRun.php#L176)
- [`payslips(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/PayRun/PayRun.php#L207)

## Payroll\UK\PayRun\PayRuns

[Source](../../src/Payroll/UK/PayRun/PayRuns.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/PayRun/PayRuns.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/PayRun/PayRuns.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/PayRun/PayRuns.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/PayRun/PayRuns.php#L30)
- [`status(string $status): Sujip\Xero\Payroll\UK\PayRun\PayRuns`](../../src/Payroll/UK/PayRun/PayRuns.php#L38)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/PayRun/PayRuns.php#L49)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/PayRun/PayRuns.php#L68)
- [`find(string $payRunId): ?\Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRuns.php#L83)
- [`create(): Sujip\Xero\Payroll\UK\PayRun\Payload`](../../src/Payroll/UK/PayRun/PayRuns.php#L95)
- [`payslips(string $payRunId): Sujip\Xero\Payroll\UK\PayRun\Payslips`](../../src/Payroll/UK/PayRun/PayRuns.php#L100)
- [`mapPayRun(array $payRun): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/PayRuns.php#L108)

## Payroll\UK\PayRun\Payload

[Source](../../src/Payroll/UK/PayRun/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/PayRun/Payload.php#L19)
- [`payrollCalendar(string $payrollCalendarId): Sujip\Xero\Payroll\UK\PayRun\Payload`](../../src/Payroll/UK/PayRun/Payload.php#L24)
- [`paymentDate(string $paymentDate): Sujip\Xero\Payroll\UK\PayRun\Payload`](../../src/Payroll/UK/PayRun/Payload.php#L32)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\UK\PayRun\Payload`](../../src/Payroll/UK/PayRun/Payload.php#L40)
- [`save(): Sujip\Xero\Payroll\UK\PayRun\PayRun`](../../src/Payroll/UK/PayRun/Payload.php#L48)

## Payroll\UK\PayRun\Payslip

[Source](../../src/Payroll/UK/PayRun/Payslip.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `paySlipID` | string or null | `setPayslipID()` |
| `employeeID` | string or null | `setEmployeeID()` |
| `payRunID` | string or null | `setPayRunID()` |
| `lastEdited` | string or null | `setLastEdited()` |
| `firstName` | string or null | `setFirstName()` |
| `lastName` | string or null | `setLastName()` |
| `totalEarnings` | int, float, or null | `setTotalEarnings()` |
| `grossEarnings` | int, float, or null | `setGrossEarnings()` |
| `totalPay` | int, float, or null | `setTotalPay()` |
| `totalEmployerTaxes` | int, float, or null | `setTotalEmployerTaxes()` |
| `totalEmployeeTaxes` | int, float, or null | `setTotalEmployeeTaxes()` |
| `totalDeductions` | int, float, or null | `setTotalDeductions()` |
| `totalReimbursements` | int, float, or null | `setTotalReimbursements()` |
| `totalCourtOrders` | int, float, or null | `setTotalCourtOrders()` |
| `totalBenefits` | int, float, or null | `setTotalBenefits()` |
| `bacsHash` | string or null | `setBacsHash()` |
| `paymentMethod` | string or null | `setPaymentMethod()` |
| `earningsLines` | array | `setEarningsLines()` |
| `leaveEarningsLines` | array | `setLeaveEarningsLines()` |
| `timesheetEarningsLines` | array | `setTimesheetEarningsLines()` |
| `deductionLines` | array | `setDeductionLines()` |
| `reimbursementLines` | array | `setReimbursementLines()` |
| `leaveAccrualLines` | array | `setLeaveAccrualLines()` |
| `benefitLines` | array | `setBenefitLines()` |
| `paymentLines` | array | `setPaymentLines()` |
| `employeeTaxLines` | array | `setEmployeeTaxLines()` |
| `employerTaxLines` | array | `setEmployerTaxLines()` |
| `courtOrderLines` | array | `setCourtOrderLines()` |

### Public methods

- [`__construct(?string $paySlipID = NULL, ?string $employeeID = NULL, ?string $payRunID = NULL, ?string $lastEdited = NULL, ?string $firstName = NULL, ?string $lastName = NULL, ?float $totalEarnings = NULL, ?float $grossEarnings = NULL, ?float $totalPay = NULL, ?float $totalEmployerTaxes = NULL, ?float $totalEmployeeTaxes = NULL, ?float $totalDeductions = NULL, ?float $totalReimbursements = NULL, ?float $totalCourtOrders = NULL, ?float $totalBenefits = NULL, ?string $bacsHash = NULL, ?string $paymentMethod = NULL)`](../../src/Payroll/UK/PayRun/Payslip.php#L12)
- [`getPayslipID(): ?string`](../../src/Payroll/UK/PayRun/Payslip.php#L66)
- [`setPayslipID(?string $paySlipID): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L71)
- [`getEmployeeID(): ?string`](../../src/Payroll/UK/PayRun/Payslip.php#L78)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L83)
- [`getPayRunID(): ?string`](../../src/Payroll/UK/PayRun/Payslip.php#L90)
- [`setPayRunID(?string $payRunID): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L95)
- [`getLastEdited(): ?string`](../../src/Payroll/UK/PayRun/Payslip.php#L102)
- [`setLastEdited(?string $lastEdited): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L107)
- [`getFirstName(): ?string`](../../src/Payroll/UK/PayRun/Payslip.php#L114)
- [`setFirstName(?string $firstName): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L119)
- [`getLastName(): ?string`](../../src/Payroll/UK/PayRun/Payslip.php#L126)
- [`setLastName(?string $lastName): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L131)
- [`getTotalEarnings(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L138)
- [`setTotalEarnings(?float $totalEarnings): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L143)
- [`getGrossEarnings(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L150)
- [`setGrossEarnings(?float $grossEarnings): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L155)
- [`getTotalPay(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L162)
- [`setTotalPay(?float $totalPay): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L167)
- [`getTotalEmployerTaxes(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L174)
- [`setTotalEmployerTaxes(?float $totalEmployerTaxes): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L179)
- [`getTotalEmployeeTaxes(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L186)
- [`setTotalEmployeeTaxes(?float $totalEmployeeTaxes): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L191)
- [`getTotalDeductions(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L198)
- [`setTotalDeductions(?float $totalDeductions): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L203)
- [`getTotalReimbursements(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L210)
- [`setTotalReimbursements(?float $totalReimbursements): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L215)
- [`getTotalCourtOrders(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L222)
- [`setTotalCourtOrders(?float $totalCourtOrders): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L227)
- [`getTotalBenefits(): ?float`](../../src/Payroll/UK/PayRun/Payslip.php#L234)
- [`setTotalBenefits(?float $totalBenefits): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L239)
- [`getBacsHash(): ?string`](../../src/Payroll/UK/PayRun/Payslip.php#L246)
- [`setBacsHash(?string $bacsHash): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L251)
- [`getPaymentMethod(): ?string`](../../src/Payroll/UK/PayRun/Payslip.php#L258)
- [`setPaymentMethod(?string $paymentMethod): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L263)
- [`getEarningsLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L271)
- [`setEarningsLines(array $earningsLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L277)
- [`getLeaveEarningsLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L285)
- [`setLeaveEarningsLines(array $leaveEarningsLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L291)
- [`getTimesheetEarningsLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L299)
- [`setTimesheetEarningsLines(array $timesheetEarningsLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L305)
- [`getDeductionLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L313)
- [`setDeductionLines(array $deductionLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L319)
- [`getReimbursementLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L327)
- [`setReimbursementLines(array $reimbursementLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L333)
- [`getLeaveAccrualLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L341)
- [`setLeaveAccrualLines(array $leaveAccrualLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L347)
- [`getBenefitLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L355)
- [`setBenefitLines(array $benefitLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L361)
- [`getPaymentLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L369)
- [`setPaymentLines(array $paymentLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L375)
- [`getEmployeeTaxLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L383)
- [`setEmployeeTaxLines(array $employeeTaxLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L389)
- [`getEmployerTaxLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L397)
- [`setEmployerTaxLines(array $employerTaxLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L403)
- [`getCourtOrderLines(): array`](../../src/Payroll/UK/PayRun/Payslip.php#L411)
- [`setCourtOrderLines(array $courtOrderLines): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslip.php#L417)

## Payroll\UK\PayRun\Payslips

[Source](../../src/Payroll/UK/PayRun/Payslips.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $payRunId)`](../../src/Payroll/UK/PayRun/Payslips.php#L15)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/PayRun/Payslips.php#L21)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/PayRun/Payslips.php#L32)
- [`find(string $payslipId): ?\Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslips.php#L48)
- [`mapPayslip(array $payslip): Sujip\Xero\Payroll\UK\PayRun\Payslip`](../../src/Payroll/UK/PayRun/Payslips.php#L63)

## Payroll\UK\PayrollUK

[Source](../../src/Payroll/UK/PayrollUK.php)

Extends [Payroll\Shared\PayrollRegion](payroll.md#payrollsharedpayrollregion). Inherited methods are documented on the parent type.

### Public methods

- [`employees(): Sujip\Xero\Payroll\UK\Employee\Employees`](../../src/Payroll/UK/PayrollUK.php#L22)
- [`leaveTypes(): Sujip\Xero\Payroll\UK\LeaveType\LeaveTypes`](../../src/Payroll/UK/PayrollUK.php#L27)
- [`benefits(): Sujip\Xero\Payroll\UK\PayItem\Benefits`](../../src/Payroll/UK/PayrollUK.php#L32)
- [`deductions(): Sujip\Xero\Payroll\UK\PayItem\Deductions`](../../src/Payroll/UK/PayrollUK.php#L37)
- [`earningsOrders(): Sujip\Xero\Payroll\UK\PayItem\EarningsOrders`](../../src/Payroll/UK/PayrollUK.php#L42)
- [`earningsRates(): Sujip\Xero\Payroll\UK\PayItem\EarningsRates`](../../src/Payroll/UK/PayrollUK.php#L47)
- [`payRunCalendars(): Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendars`](../../src/Payroll/UK/PayrollUK.php#L52)
- [`payRuns(): Sujip\Xero\Payroll\UK\PayRun\PayRuns`](../../src/Payroll/UK/PayrollUK.php#L57)
- [`timesheets(): Sujip\Xero\Payroll\UK\Timesheet\Timesheets`](../../src/Payroll/UK/PayrollUK.php#L62)
- [`settings(): Sujip\Xero\Payroll\UK\Settings\Settings`](../../src/Payroll/UK/PayrollUK.php#L67)
- [`statutoryLeaves(): Sujip\Xero\Payroll\UK\StatutoryLeave\StatutoryLeaves`](../../src/Payroll/UK/PayrollUK.php#L72)

## Payroll\UK\Settings\PayrollSettings

[Source](../../src/Payroll/UK/Settings/PayrollSettings.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accounts` | array | `setAccounts()` |

### Public methods

- [`__construct(array $accounts = array (
))`](../../src/Payroll/UK/Settings/PayrollSettings.php#L15)
- [`getAccounts(): array`](../../src/Payroll/UK/Settings/PayrollSettings.php#L23)
- [`setAccounts(array $accounts): Sujip\Xero\Payroll\UK\Settings\PayrollSettings`](../../src/Payroll/UK/Settings/PayrollSettings.php#L31)

## Payroll\UK\Settings\Reimbursement

[Source](../../src/Payroll/UK/Settings/Reimbursement.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `reimbursementID` | string or null | `setReimbursementID()` |
| `name` | string or null | `setName()` |
| `accountID` | string or null | `setAccountID()` |
| `currentRecord` | bool or null | `setCurrentRecord()` |

### Public methods

- [`__construct(?string $reimbursementID = NULL, ?string $name = NULL, ?string $accountID = NULL, ?bool $currentRecord = NULL)`](../../src/Payroll/UK/Settings/Reimbursement.php#L12)
- [`getReimbursementID(): ?string`](../../src/Payroll/UK/Settings/Reimbursement.php#L20)
- [`setReimbursementID(?string $reimbursementID): Sujip\Xero\Payroll\UK\Settings\Reimbursement`](../../src/Payroll/UK/Settings/Reimbursement.php#L25)
- [`getName(): ?string`](../../src/Payroll/UK/Settings/Reimbursement.php#L32)
- [`setName(?string $name): Sujip\Xero\Payroll\UK\Settings\Reimbursement`](../../src/Payroll/UK/Settings/Reimbursement.php#L37)
- [`getAccountID(): ?string`](../../src/Payroll/UK/Settings/Reimbursement.php#L44)
- [`setAccountID(?string $accountID): Sujip\Xero\Payroll\UK\Settings\Reimbursement`](../../src/Payroll/UK/Settings/Reimbursement.php#L49)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/UK/Settings/Reimbursement.php#L56)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\UK\Settings\Reimbursement`](../../src/Payroll/UK/Settings/Reimbursement.php#L61)

## Payroll\UK\Settings\ReimbursementPayload

[Source](../../src/Payroll/UK/Settings/ReimbursementPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/Settings/ReimbursementPayload.php#L19)
- [`name(string $name): Sujip\Xero\Payroll\UK\Settings\ReimbursementPayload`](../../src/Payroll/UK/Settings/ReimbursementPayload.php#L24)
- [`account(string $accountId): Sujip\Xero\Payroll\UK\Settings\ReimbursementPayload`](../../src/Payroll/UK/Settings/ReimbursementPayload.php#L32)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\UK\Settings\ReimbursementPayload`](../../src/Payroll/UK/Settings/ReimbursementPayload.php#L40)
- [`save(): Sujip\Xero\Payroll\UK\Settings\Reimbursement`](../../src/Payroll/UK/Settings/ReimbursementPayload.php#L48)

## Payroll\UK\Settings\Settings

[Source](../../src/Payroll/UK/Settings/Settings.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/Settings/Settings.php#L15)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/Settings/Settings.php#L20)
- [`get(): Sujip\Xero\Payroll\UK\Settings\PayrollSettings`](../../src/Payroll/UK/Settings/Settings.php#L28)
- [`trackingCategories(): array`](../../src/Payroll/UK/Settings/Settings.php#L48)
- [`reimbursements(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/Settings/Settings.php#L61)
- [`reimbursement(string $reimbursementId): ?\Sujip\Xero\Payroll\UK\Settings\Reimbursement`](../../src/Payroll/UK/Settings/Settings.php#L76)
- [`createReimbursement(): Sujip\Xero\Payroll\UK\Settings\ReimbursementPayload`](../../src/Payroll/UK/Settings/Settings.php#L88)
- [`statutoryLeaveSummary(string $employeeId): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/Settings/Settings.php#L96)
- [`mapSettings(array $settings): Sujip\Xero\Payroll\UK\Settings\PayrollSettings`](../../src/Payroll/UK/Settings/Settings.php#L114)
- [`mapReimbursement(array $reimbursement): Sujip\Xero\Payroll\UK\Settings\Reimbursement`](../../src/Payroll/UK/Settings/Settings.php#L122)
- [`mapStatutoryLeaveSummary(array $summary): Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary`](../../src/Payroll/UK/Settings/Settings.php#L130)

## Payroll\UK\Settings\StatutoryLeaveSummary

[Source](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `statutoryLeaveID` | string or null | `setStatutoryLeaveID()` |
| `employeeID` | string or null | `setEmployeeID()` |
| `type` | string or null | `setType()` |
| `startDate` | string or null | `setStartDate()` |
| `endDate` | string or null | `setEndDate()` |
| `isEntitled` | bool or null | `setIsEntitled()` |
| `status` | string or null | `setStatus()` |

### Public methods

- [`__construct(?string $statutoryLeaveID = NULL, ?string $employeeID = NULL, ?string $type = NULL, ?string $startDate = NULL, ?string $endDate = NULL, ?bool $isEntitled = NULL, ?string $status = NULL)`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L12)
- [`getStatutoryLeaveID(): ?string`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L23)
- [`setStatutoryLeaveID(?string $statutoryLeaveID): Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L28)
- [`getEmployeeID(): ?string`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L35)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L40)
- [`getType(): ?string`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L47)
- [`setType(?string $type): Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L52)
- [`getStartDate(): ?string`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L59)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L64)
- [`getEndDate(): ?string`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L71)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L76)
- [`getIsEntitled(): ?bool`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L83)
- [`setIsEntitled(?bool $isEntitled): Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L88)
- [`getStatus(): ?string`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L95)
- [`setStatus(?string $status): Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary`](../../src/Payroll/UK/Settings/StatutoryLeaveSummary.php#L100)

## Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave

[Source](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `statutoryLeaveID` | string or null | `()` |
| `employeeID` | string or null | `()` |
| `leaveTypeID` | string or null | `()` |
| `startDate` | string or null | `()` |
| `endDate` | string or null | `()` |
| `type` | string or null | `()` |
| `status` | string or null | `()` |
| `workPattern` | array | `()` |
| `isPregnancyRelated` | bool or null | `()` |
| `sufficientNotice` | bool or null | `()` |
| `isEntitled` | bool or null | `()` |
| `entitlementWeeksRequested` | int, float, or null | `()` |
| `entitlementWeeksQualified` | int, float, or null | `()` |
| `entitlementWeeksRemaining` | int, float, or null | `()` |
| `overlapsWithOtherLeave` | bool or null | `()` |
| `entitlementFailureReasons` | array | `()` |

### Public methods

- [`getStatutoryLeaveID(): ?string`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L51)
- [`setStatutoryLeaveID(?string $statutoryLeaveID): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L56)
- [`getEmployeeID(): ?string`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L63)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L68)
- [`getLeaveTypeID(): ?string`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L75)
- [`setLeaveTypeID(?string $leaveTypeID): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L80)
- [`getStartDate(): ?string`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L87)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L92)
- [`getEndDate(): ?string`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L99)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L104)
- [`getType(): ?string`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L111)
- [`setType(?string $type): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L116)
- [`getStatus(): ?string`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L123)
- [`setStatus(?string $status): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L128)
- [`getWorkPattern(): array`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L138)
- [`setWorkPattern(array $workPattern): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L146)
- [`getIsPregnancyRelated(): ?bool`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L153)
- [`setIsPregnancyRelated(?bool $isPregnancyRelated): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L158)
- [`getSufficientNotice(): ?bool`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L165)
- [`setSufficientNotice(?bool $sufficientNotice): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L170)
- [`getIsEntitled(): ?bool`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L177)
- [`setIsEntitled(?bool $isEntitled): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L182)
- [`getEntitlementWeeksRequested(): ?float`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L189)
- [`setEntitlementWeeksRequested(?float $entitlementWeeksRequested): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L194)
- [`getEntitlementWeeksQualified(): ?float`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L201)
- [`setEntitlementWeeksQualified(?float $entitlementWeeksQualified): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L206)
- [`getEntitlementWeeksRemaining(): ?float`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L213)
- [`setEntitlementWeeksRemaining(?float $entitlementWeeksRemaining): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L218)
- [`getOverlapsWithOtherLeave(): ?bool`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L225)
- [`setOverlapsWithOtherLeave(?bool $overlapsWithOtherLeave): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L230)
- [`getEntitlementFailureReasons(): array`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L240)
- [`setEntitlementFailureReasons(array $entitlementFailureReasons): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L248)
- [`toRequest(): array`](../../src/Payroll/UK/StatutoryLeave/EmployeeStatutorySickLeave.php#L283)

## Payroll\UK\StatutoryLeave\StatutoryLeaves

[Source](../../src/Payroll/UK/StatutoryLeave/StatutoryLeaves.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/StatutoryLeave/StatutoryLeaves.php#L14)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/StatutoryLeave/StatutoryLeaves.php#L19)
- [`findSick(string $statutorySickLeaveId): ?\Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/StatutoryLeaves.php#L27)
- [`createSick(\Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave $leave, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/StatutoryLeaves.php#L39)
- [`mapSick(array $leave): Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave`](../../src/Payroll/UK/StatutoryLeave/StatutoryLeaves.php#L54)

## Payroll\UK\Timesheet\Payload

[Source](../../src/Payroll/UK/Timesheet/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/Timesheet/Payload.php#L19)
- [`payrollCalendar(string $payrollCalendarId): Sujip\Xero\Payroll\UK\Timesheet\Payload`](../../src/Payroll/UK/Timesheet/Payload.php#L24)
- [`employee(string $employeeId): Sujip\Xero\Payroll\UK\Timesheet\Payload`](../../src/Payroll/UK/Timesheet/Payload.php#L32)
- [`startDate(string $startDate): Sujip\Xero\Payroll\UK\Timesheet\Payload`](../../src/Payroll/UK/Timesheet/Payload.php#L40)
- [`endDate(string $endDate): Sujip\Xero\Payroll\UK\Timesheet\Payload`](../../src/Payroll/UK/Timesheet/Payload.php#L48)
- [`status(string $status): Sujip\Xero\Payroll\UK\Timesheet\Payload`](../../src/Payroll/UK/Timesheet/Payload.php#L56)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\UK\Timesheet\Payload`](../../src/Payroll/UK/Timesheet/Payload.php#L64)
- [`save(): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Payload.php#L72)

## Payroll\UK\Timesheet\Timesheet

[Source](../../src/Payroll/UK/Timesheet/Timesheet.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `timesheetID` | string or null | `setTimesheetID()` |
| `payrollCalendarID` | string or null | `setPayrollCalendarID()` |
| `employeeID` | string or null | `setEmployeeID()` |
| `startDate` | string or null | `setStartDate()` |
| `endDate` | string or null | `setEndDate()` |
| `status` | string or null | `setStatus()` |
| `totalHours` | int, float, or null | `setTotalHours()` |
| `updatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `timesheetLines` | list of objects ([Payroll\UK\Timesheet\TimesheetLine](payroll-uk.md#payrolluktimesheettimesheetline)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/UK/Timesheet/Timesheet.php#L28)
- [`getTimesheetID(): ?string`](../../src/Payroll/UK/Timesheet/Timesheet.php#L33)
- [`setTimesheetID(?string $timesheetID): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L38)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/UK/Timesheet/Timesheet.php#L45)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L50)
- [`getEmployeeID(): ?string`](../../src/Payroll/UK/Timesheet/Timesheet.php#L57)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L62)
- [`getStartDate(): ?string`](../../src/Payroll/UK/Timesheet/Timesheet.php#L69)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L74)
- [`getEndDate(): ?string`](../../src/Payroll/UK/Timesheet/Timesheet.php#L81)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L86)
- [`getStatus(): ?string`](../../src/Payroll/UK/Timesheet/Timesheet.php#L93)
- [`setStatus(?string $status): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L98)
- [`getTotalHours(): ?float`](../../src/Payroll/UK/Timesheet/Timesheet.php#L105)
- [`setTotalHours(?float $totalHours): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L110)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/UK/Timesheet/Timesheet.php#L117)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L122)
- [`getTimesheetLines(): array`](../../src/Payroll/UK/Timesheet/Timesheet.php#L132)
- [`addTimesheetLine(\Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine $timesheetLine): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L137)
- [`save(): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L162)
- [`approve(): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L193)
- [`revert(): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheet.php#L202)
- [`delete(): bool`](../../src/Payroll/UK/Timesheet/Timesheet.php#L211)

## Payroll\UK\Timesheet\TimesheetLine

[Source](../../src/Payroll/UK/Timesheet/TimesheetLine.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `timesheetLineID` | string or null | `()` |
| `date` | string or null | `()` |
| `earningsRateID` | string or null | `()` |
| `trackingItemID` | string or null | `()` |
| `numberOfUnits` | int, float, or null | `()` |

### Public methods

- [`getTimesheetLineID(): ?string`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L23)
- [`setTimesheetLineID(?string $timesheetLineID): Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L28)
- [`getDate(): ?string`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L35)
- [`setDate(?string $date): Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L40)
- [`getEarningsRateID(): ?string`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L47)
- [`setEarningsRateID(?string $earningsRateID): Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L52)
- [`getTrackingItemID(): ?string`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L59)
- [`setTrackingItemID(?string $trackingItemID): Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L64)
- [`getNumberOfUnits(): ?float`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L71)
- [`setNumberOfUnits(?float $numberOfUnits): Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L76)
- [`toRequest(): array`](../../src/Payroll/UK/Timesheet/TimesheetLine.php#L100)

## Payroll\UK\Timesheet\Timesheets

[Source](../../src/Payroll/UK/Timesheet/Timesheets.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/UK/Timesheet/Timesheets.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/UK/Timesheet/Timesheets.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/UK/Timesheet/Timesheets.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/UK/Timesheet/Timesheets.php#L30)
- [`status(string $status): Sujip\Xero\Payroll\UK\Timesheet\Timesheets`](../../src/Payroll/UK/Timesheet/Timesheets.php#L38)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/UK/Timesheet/Timesheets.php#L49)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/UK/Timesheet/Timesheets.php#L68)
- [`find(string $timesheetId): ?\Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheets.php#L83)
- [`create(): Sujip\Xero\Payroll\UK\Timesheet\Payload`](../../src/Payroll/UK/Timesheet/Timesheets.php#L95)
- [`approve(string $timesheetId): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheets.php#L100)
- [`revert(string $timesheetId): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheets.php#L112)
- [`delete(string $timesheetId): bool`](../../src/Payroll/UK/Timesheet/Timesheets.php#L124)
- [`createLine(string $timesheetId, \Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine $line, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine`](../../src/Payroll/UK/Timesheet/Timesheets.php#L133)
- [`updateLine(string $timesheetId, string $timesheetLineId, \Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine $line, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine`](../../src/Payroll/UK/Timesheet/Timesheets.php#L145)
- [`deleteLine(string $timesheetId, string $timesheetLineId): bool`](../../src/Payroll/UK/Timesheet/Timesheets.php#L157)
- [`mapTimesheet(array $timesheet): Sujip\Xero\Payroll\UK\Timesheet\Timesheet`](../../src/Payroll/UK/Timesheet/Timesheets.php#L169)
