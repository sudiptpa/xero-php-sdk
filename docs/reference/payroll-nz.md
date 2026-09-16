# Payroll NZ reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Payroll\NZ\Employee\Address](#payrollnzemployeeaddress)
- [Payroll\NZ\Employee\EarningsTemplate](#payrollnzemployeeearningstemplate)
- [Payroll\NZ\Employee\Employee](#payrollnzemployeeemployee)
- [Payroll\NZ\Employee\EmployeeLeaveType](#payrollnzemployeeemployeeleavetype)
- [Payroll\NZ\Employee\Employees](#payrollnzemployeeemployees)
- [Payroll\NZ\Employee\EmploymentPayload](#payrollnzemployeeemploymentpayload)
- [Payroll\NZ\Employee\LeavePayload](#payrollnzemployeeleavepayload)
- [Payroll\NZ\Employee\LeaveSetupPayload](#payrollnzemployeeleavesetuppayload)
- [Payroll\NZ\Employee\OpeningBalancesPayload](#payrollnzemployeeopeningbalancespayload)
- [Payroll\NZ\Employee\Payload](#payrollnzemployeepayload)
- [Payroll\NZ\Employee\PaymentMethodPayload](#payrollnzemployeepaymentmethodpayload)
- [Payroll\NZ\Employee\SalaryAndWagePayload](#payrollnzemployeesalaryandwagepayload)
- [Payroll\NZ\Employee\WorkingPatternPayload](#payrollnzemployeeworkingpatternpayload)
- [Payroll\NZ\LeaveType\LeaveType](#payrollnzleavetypeleavetype)
- [Payroll\NZ\LeaveType\LeaveTypes](#payrollnzleavetypeleavetypes)
- [Payroll\NZ\PayItem\Deduction](#payrollnzpayitemdeduction)
- [Payroll\NZ\PayItem\Deductions](#payrollnzpayitemdeductions)
- [Payroll\NZ\PayItem\EarningsRate](#payrollnzpayitemearningsrate)
- [Payroll\NZ\PayItem\EarningsRates](#payrollnzpayitemearningsrates)
- [Payroll\NZ\PayItem\Superannuation](#payrollnzpayitemsuperannuation)
- [Payroll\NZ\PayItem\Superannuations](#payrollnzpayitemsuperannuations)
- [Payroll\NZ\PayRunCalendar\PayRunCalendar](#payrollnzpayruncalendarpayruncalendar)
- [Payroll\NZ\PayRunCalendar\PayRunCalendars](#payrollnzpayruncalendarpayruncalendars)
- [Payroll\NZ\PayRun\PayRun](#payrollnzpayrunpayrun)
- [Payroll\NZ\PayRun\PayRuns](#payrollnzpayrunpayruns)
- [Payroll\NZ\PayRun\Payload](#payrollnzpayrunpayload)
- [Payroll\NZ\PaySlip\PaySlip](#payrollnzpayslippayslip)
- [Payroll\NZ\PaySlip\PaySlips](#payrollnzpayslippayslips)
- [Payroll\NZ\PayrollNZ](#payrollnzpayrollnz)
- [Payroll\NZ\Settings\PayrollSettings](#payrollnzsettingspayrollsettings)
- [Payroll\NZ\Settings\Reimbursement](#payrollnzsettingsreimbursement)
- [Payroll\NZ\Settings\ReimbursementPayload](#payrollnzsettingsreimbursementpayload)
- [Payroll\NZ\Settings\Settings](#payrollnzsettingssettings)
- [Payroll\NZ\Settings\StatutoryDeduction](#payrollnzsettingsstatutorydeduction)
- [Payroll\NZ\Timesheet\Payload](#payrollnztimesheetpayload)
- [Payroll\NZ\Timesheet\Timesheet](#payrollnztimesheettimesheet)
- [Payroll\NZ\Timesheet\TimesheetLine](#payrollnztimesheettimesheetline)
- [Payroll\NZ\Timesheet\Timesheets](#payrollnztimesheettimesheets)

## Payroll\NZ\Employee\Address

[Source](../../src/Payroll/NZ/Employee/Address.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `addressLine1` | string or null | `setAddressLine1()` |
| `addressLine2` | string or null | `setAddressLine2()` |
| `city` | string or null | `setCity()` |
| `suburb` | string or null | `setSuburb()` |
| `postCode` | string or null | `setPostCode()` |
| `countryName` | string or null | `setCountryName()` |

### Public methods

- [`__construct(?string $addressLine1 = NULL, ?string $addressLine2 = NULL, ?string $city = NULL, ?string $suburb = NULL, ?string $postCode = NULL, ?string $countryName = NULL)`](../../src/Payroll/NZ/Employee/Address.php#L12)
- [`getAddressLine1(): ?string`](../../src/Payroll/NZ/Employee/Address.php#L22)
- [`setAddressLine1(?string $addressLine1): Sujip\Xero\Payroll\NZ\Employee\Address`](../../src/Payroll/NZ/Employee/Address.php#L27)
- [`getAddressLine2(): ?string`](../../src/Payroll/NZ/Employee/Address.php#L34)
- [`setAddressLine2(?string $addressLine2): Sujip\Xero\Payroll\NZ\Employee\Address`](../../src/Payroll/NZ/Employee/Address.php#L39)
- [`getCity(): ?string`](../../src/Payroll/NZ/Employee/Address.php#L46)
- [`setCity(?string $city): Sujip\Xero\Payroll\NZ\Employee\Address`](../../src/Payroll/NZ/Employee/Address.php#L51)
- [`getSuburb(): ?string`](../../src/Payroll/NZ/Employee/Address.php#L58)
- [`setSuburb(?string $suburb): Sujip\Xero\Payroll\NZ\Employee\Address`](../../src/Payroll/NZ/Employee/Address.php#L63)
- [`getPostCode(): ?string`](../../src/Payroll/NZ/Employee/Address.php#L70)
- [`setPostCode(?string $postCode): Sujip\Xero\Payroll\NZ\Employee\Address`](../../src/Payroll/NZ/Employee/Address.php#L75)
- [`getCountryName(): ?string`](../../src/Payroll/NZ/Employee/Address.php#L82)
- [`setCountryName(?string $countryName): Sujip\Xero\Payroll\NZ\Employee\Address`](../../src/Payroll/NZ/Employee/Address.php#L87)

## Payroll\NZ\Employee\EarningsTemplate

[Source](../../src/Payroll/NZ/Employee/EarningsTemplate.php)

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

- [`getPayTemplateEarningID(): ?string`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L25)
- [`setPayTemplateEarningID(?string $payTemplateEarningID): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L30)
- [`getRatePerUnit(): ?float`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L37)
- [`setRatePerUnit(?float $ratePerUnit): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L42)
- [`getNumberOfUnits(): ?float`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L49)
- [`setNumberOfUnits(?float $numberOfUnits): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L54)
- [`getFixedAmount(): ?float`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L61)
- [`setFixedAmount(?float $fixedAmount): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L66)
- [`getEarningsRateID(): ?string`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L73)
- [`setEarningsRateID(?string $earningsRateID): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L78)
- [`getName(): ?string`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L85)
- [`setName(?string $name): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L90)
- [`toRequest(): array`](../../src/Payroll/NZ/Employee/EarningsTemplate.php#L115)

## Payroll\NZ\Employee\Employee

[Source](../../src/Payroll/NZ/Employee/Employee.php)

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
| `jobTitle` | string or null | `setJobTitle()` |
| `engagementType` | string or null | `setEngagementType()` |
| `fixedTermEndDate` | string or null | `setFixedTermEndDate()` |
| `address` | object or null ([Payroll\NZ\Employee\Address](payroll-nz.md#payrollnzemployeeaddress)) | `setAddress()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/NZ/Employee/Employee.php#L34)
- [`getEmployeeID(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L39)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L43)
- [`getFirstName(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L48)
- [`setFirstName(?string $firstName): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L52)
- [`getLastName(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L57)
- [`setLastName(?string $lastName): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L61)
- [`getEmailAddress(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L66)
- [`setEmailAddress(?string $emailAddress): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L70)
- [`getTitle(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L76)
- [`setTitle(?string $title): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L80)
- [`getDateOfBirth(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L86)
- [`setDateOfBirth(?string $dateOfBirth): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L90)
- [`getGender(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L96)
- [`setGender(?string $gender): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L100)
- [`getPhoneNumber(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L106)
- [`setPhoneNumber(?string $phoneNumber): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L110)
- [`getStartDate(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L116)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L120)
- [`getEndDate(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L126)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L130)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L136)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L140)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L146)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L150)
- [`getCreatedDateUTC(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L156)
- [`setCreatedDateUTC(?string $createdDateUTC): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L160)
- [`getJobTitle(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L166)
- [`setJobTitle(?string $jobTitle): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L170)
- [`getEngagementType(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L176)
- [`setEngagementType(?string $engagementType): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L180)
- [`getFixedTermEndDate(): ?string`](../../src/Payroll/NZ/Employee/Employee.php#L186)
- [`setFixedTermEndDate(?string $fixedTermEndDate): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L190)
- [`getAddress(): ?\Sujip\Xero\Payroll\NZ\Employee\Address`](../../src/Payroll/NZ/Employee/Employee.php#L196)
- [`setAddress(?\Sujip\Xero\Payroll\NZ\Employee\Address $address): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L200)
- [`save(): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employee.php#L232)
- [`leaveTypes(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/Employee/Employee.php#L254)
- [`leavePeriods(string $startDate, string $endDate): array`](../../src/Payroll/NZ/Employee/Employee.php#L263)
- [`leaveBalances(): array`](../../src/Payroll/NZ/Employee/Employee.php#L272)
- [`leaves(): array`](../../src/Payroll/NZ/Employee/Employee.php#L281)
- [`leave(string $leaveId): array`](../../src/Payroll/NZ/Employee/Employee.php#L290)
- [`paymentMethod(): array`](../../src/Payroll/NZ/Employee/Employee.php#L299)
- [`tax(): array`](../../src/Payroll/NZ/Employee/Employee.php#L308)
- [`workingPatterns(): array`](../../src/Payroll/NZ/Employee/Employee.php#L317)
- [`workingPattern(string $workingPatternId): array`](../../src/Payroll/NZ/Employee/Employee.php#L326)
- [`leaveSetup(): Sujip\Xero\Payroll\NZ\Employee\LeaveSetupPayload`](../../src/Payroll/NZ/Employee/Employee.php#L334)
- [`openingBalances(): Sujip\Xero\Payroll\NZ\Employee\OpeningBalancesPayload`](../../src/Payroll/NZ/Employee/Employee.php#L341)
- [`createEmployment(): Sujip\Xero\Payroll\NZ\Employee\EmploymentPayload`](../../src/Payroll/NZ/Employee/Employee.php#L348)
- [`createLeave(): Sujip\Xero\Payroll\NZ\Employee\LeavePayload`](../../src/Payroll/NZ/Employee/Employee.php#L355)
- [`createPaymentMethod(): Sujip\Xero\Payroll\NZ\Employee\PaymentMethodPayload`](../../src/Payroll/NZ/Employee/Employee.php#L362)
- [`createSalaryAndWage(): Sujip\Xero\Payroll\NZ\Employee\SalaryAndWagePayload`](../../src/Payroll/NZ/Employee/Employee.php#L369)
- [`createWorkingPattern(): Sujip\Xero\Payroll\NZ\Employee\WorkingPatternPayload`](../../src/Payroll/NZ/Employee/Employee.php#L376)
- [`salaryAndWages(?int $page = NULL): array`](../../src/Payroll/NZ/Employee/Employee.php#L384)
- [`salaryAndWage(string $salaryAndWagesId): array`](../../src/Payroll/NZ/Employee/Employee.php#L392)

## Payroll\NZ\Employee\EmployeeLeaveType

[Source](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `leaveTypeID` | string or null | `setLeaveTypeID()` |
| `scheduleOfAccrual` | string or null | `setScheduleOfAccrual()` |
| `unitsAccruedAnnually` | int, float, or null | `setUnitsAccruedAnnually()` |
| `typeOfUnitsToAccrue` | string or null | `setTypeOfUnitsToAccrue()` |
| `maximumToAccrue` | int, float, or null | `setMaximumToAccrue()` |
| `openingBalance` | int, float, or null | `setOpeningBalance()` |
| `openingBalanceTypeOfUnits` | string or null | `setOpeningBalanceTypeOfUnits()` |
| `rateAccruedHourly` | int, float, or null | `setRateAccruedHourly()` |
| `percentageOfGrossEarnings` | int, float, or null | `setPercentageOfGrossEarnings()` |
| `includeHolidayPayEveryPay` | bool or null | `setIncludeHolidayPayEveryPay()` |
| `showAnnualLeaveInAdvance` | bool or null | `setShowAnnualLeaveInAdvance()` |
| `annualLeaveTotalAmountPaid` | int, float, or null | `setAnnualLeaveTotalAmountPaid()` |
| `scheduleOfAccrualDate` | string or null | `setScheduleOfAccrualDate()` |

### Public methods

- [`__construct(?string $leaveTypeID = NULL, ?string $scheduleOfAccrual = NULL, ?float $unitsAccruedAnnually = NULL, ?string $typeOfUnitsToAccrue = NULL, ?float $maximumToAccrue = NULL, ?float $openingBalance = NULL, ?string $openingBalanceTypeOfUnits = NULL, ?float $rateAccruedHourly = NULL, ?float $percentageOfGrossEarnings = NULL, ?bool $includeHolidayPayEveryPay = NULL, ?bool $showAnnualLeaveInAdvance = NULL, ?float $annualLeaveTotalAmountPaid = NULL, ?string $scheduleOfAccrualDate = NULL)`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L12)
- [`getLeaveTypeID(): ?string`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L29)
- [`setLeaveTypeID(?string $leaveTypeID): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L34)
- [`getScheduleOfAccrual(): ?string`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L41)
- [`setScheduleOfAccrual(?string $scheduleOfAccrual): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L46)
- [`getUnitsAccruedAnnually(): ?float`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L53)
- [`setUnitsAccruedAnnually(?float $unitsAccruedAnnually): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L58)
- [`getTypeOfUnitsToAccrue(): ?string`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L65)
- [`setTypeOfUnitsToAccrue(?string $typeOfUnitsToAccrue): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L70)
- [`getMaximumToAccrue(): ?float`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L77)
- [`setMaximumToAccrue(?float $maximumToAccrue): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L82)
- [`getOpeningBalance(): ?float`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L89)
- [`setOpeningBalance(?float $openingBalance): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L94)
- [`getOpeningBalanceTypeOfUnits(): ?string`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L101)
- [`setOpeningBalanceTypeOfUnits(?string $openingBalanceTypeOfUnits): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L106)
- [`getRateAccruedHourly(): ?float`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L113)
- [`setRateAccruedHourly(?float $rateAccruedHourly): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L118)
- [`getPercentageOfGrossEarnings(): ?float`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L125)
- [`setPercentageOfGrossEarnings(?float $percentageOfGrossEarnings): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L130)
- [`getIncludeHolidayPayEveryPay(): ?bool`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L137)
- [`setIncludeHolidayPayEveryPay(?bool $includeHolidayPayEveryPay): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L142)
- [`getShowAnnualLeaveInAdvance(): ?bool`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L149)
- [`setShowAnnualLeaveInAdvance(?bool $showAnnualLeaveInAdvance): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L154)
- [`getAnnualLeaveTotalAmountPaid(): ?float`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L161)
- [`setAnnualLeaveTotalAmountPaid(?float $annualLeaveTotalAmountPaid): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L166)
- [`getScheduleOfAccrualDate(): ?string`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L173)
- [`setScheduleOfAccrualDate(?string $scheduleOfAccrualDate): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/EmployeeLeaveType.php#L178)

## Payroll\NZ\Employee\Employees

[Source](../../src/Payroll/NZ/Employee/Employees.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/Employee/Employees.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/Employee/Employees.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/Employee/Employees.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/Employee/Employees.php#L30)
- [`filter(string $filter): Sujip\Xero\Payroll\NZ\Employee\Employees`](../../src/Payroll/NZ/Employee/Employees.php#L38)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/Employee/Employees.php#L49)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/NZ/Employee/Employees.php#L65)
- [`find(string $employeeId): ?\Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employees.php#L80)
- [`create(): Sujip\Xero\Payroll\NZ\Employee\Payload`](../../src/Payroll/NZ/Employee/Employees.php#L92)
- [`update(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\Payload`](../../src/Payroll/NZ/Employee/Employees.php#L97)
- [`payTemplate(string $employeeId): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/Employee/Employees.php#L105)
- [`createEarningsTemplate(string $employeeId, \Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate $template, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/Employees.php#L120)
- [`updateEarningsTemplate(string $employeeId, string $payTemplateEarningId, \Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate $template, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/Employees.php#L132)
- [`deleteEarningsTemplate(string $employeeId, string $payTemplateEarningId): bool`](../../src/Payroll/NZ/Employee/Employees.php#L144)
- [`createEarningsTemplates(string $employeeId, array $templates, ?string $idempotencyKey = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/Employee/Employees.php#L157)
- [`leaveTypes(string $employeeId): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/Employee/Employees.php#L180)
- [`leavePeriods(string $employeeId, string $startDate, string $endDate): array`](../../src/Payroll/NZ/Employee/Employees.php#L198)
- [`leaveBalances(string $employeeId): array`](../../src/Payroll/NZ/Employee/Employees.php#L213)
- [`leaves(string $employeeId): array`](../../src/Payroll/NZ/Employee/Employees.php#L224)
- [`leave(string $employeeId, string $leaveId): array`](../../src/Payroll/NZ/Employee/Employees.php#L235)
- [`paymentMethod(string $employeeId): array`](../../src/Payroll/NZ/Employee/Employees.php#L246)
- [`tax(string $employeeId): array`](../../src/Payroll/NZ/Employee/Employees.php#L257)
- [`workingPatterns(string $employeeId): array`](../../src/Payroll/NZ/Employee/Employees.php#L268)
- [`workingPattern(string $employeeId, string $workingPatternId): array`](../../src/Payroll/NZ/Employee/Employees.php#L279)
- [`leaveSetup(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\LeaveSetupPayload`](../../src/Payroll/NZ/Employee/Employees.php#L287)
- [`openingBalances(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\OpeningBalancesPayload`](../../src/Payroll/NZ/Employee/Employees.php#L292)
- [`createEmployment(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\EmploymentPayload`](../../src/Payroll/NZ/Employee/Employees.php#L297)
- [`createLeave(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\LeavePayload`](../../src/Payroll/NZ/Employee/Employees.php#L302)
- [`createPaymentMethod(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\PaymentMethodPayload`](../../src/Payroll/NZ/Employee/Employees.php#L307)
- [`createSalaryAndWage(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\SalaryAndWagePayload`](../../src/Payroll/NZ/Employee/Employees.php#L312)
- [`createWorkingPattern(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\WorkingPatternPayload`](../../src/Payroll/NZ/Employee/Employees.php#L317)
- [`salaryAndWages(string $employeeId, int $page = 1): array`](../../src/Payroll/NZ/Employee/Employees.php#L325)
- [`salaryAndWage(string $employeeId, string $salaryAndWagesId): array`](../../src/Payroll/NZ/Employee/Employees.php#L337)
- [`updateLeave(string $employeeId, string $leaveId, array $leave, ?string $idempotencyKey = NULL): array`](../../src/Payroll/NZ/Employee/Employees.php#L349)
- [`deleteLeave(string $employeeId, string $leaveId): array`](../../src/Payroll/NZ/Employee/Employees.php#L362)
- [`updateSalaryAndWage(string $employeeId, string $salaryAndWagesId, array $salary, ?string $idempotencyKey = NULL): array`](../../src/Payroll/NZ/Employee/Employees.php#L374)
- [`deleteSalaryAndWage(string $employeeId, string $salaryAndWagesId): array`](../../src/Payroll/NZ/Employee/Employees.php#L387)
- [`updateTax(string $employeeId, array $tax, ?string $idempotencyKey = NULL): array`](../../src/Payroll/NZ/Employee/Employees.php#L399)
- [`createLeaveType(string $employeeId, array $leaveType, ?string $idempotencyKey = NULL): array`](../../src/Payroll/NZ/Employee/Employees.php#L413)
- [`getOpeningBalances(string $employeeId): array`](../../src/Payroll/NZ/Employee/Employees.php#L426)
- [`deleteWorkingPattern(string $employeeId, string $workingPatternId): array`](../../src/Payroll/NZ/Employee/Employees.php#L437)
- [`mapEmployee(array $employee): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Employees.php#L448)
- [`mapLeaveType(array $leaveType): Sujip\Xero\Payroll\NZ\Employee\EmployeeLeaveType`](../../src/Payroll/NZ/Employee/Employees.php#L456)
- [`mapEarningsTemplate(array $template): Sujip\Xero\Payroll\NZ\Employee\EarningsTemplate`](../../src/Payroll/NZ/Employee/Employees.php#L464)

## Payroll\NZ\Employee\EmploymentPayload

[Source](../../src/Payroll/NZ/Employee/EmploymentPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/NZ/Employee/EmploymentPayload.php#L18)
- [`startDate(string $startDate): Sujip\Xero\Payroll\NZ\Employee\EmploymentPayload`](../../src/Payroll/NZ/Employee/EmploymentPayload.php#L24)
- [`payrollCalendar(string $payrollCalendarId): Sujip\Xero\Payroll\NZ\Employee\EmploymentPayload`](../../src/Payroll/NZ/Employee/EmploymentPayload.php#L32)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Employee\EmploymentPayload`](../../src/Payroll/NZ/Employee/EmploymentPayload.php#L40)
- [`save(): array`](../../src/Payroll/NZ/Employee/EmploymentPayload.php#L51)

## Payroll\NZ\Employee\LeavePayload

[Source](../../src/Payroll/NZ/Employee/LeavePayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/NZ/Employee/LeavePayload.php#L18)
- [`leaveType(string $leaveTypeId): Sujip\Xero\Payroll\NZ\Employee\LeavePayload`](../../src/Payroll/NZ/Employee/LeavePayload.php#L24)
- [`startDate(string $startDate): Sujip\Xero\Payroll\NZ\Employee\LeavePayload`](../../src/Payroll/NZ/Employee/LeavePayload.php#L32)
- [`endDate(string $endDate): Sujip\Xero\Payroll\NZ\Employee\LeavePayload`](../../src/Payroll/NZ/Employee/LeavePayload.php#L40)
- [`title(string $title): Sujip\Xero\Payroll\NZ\Employee\LeavePayload`](../../src/Payroll/NZ/Employee/LeavePayload.php#L48)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Employee\LeavePayload`](../../src/Payroll/NZ/Employee/LeavePayload.php#L56)
- [`save(): array`](../../src/Payroll/NZ/Employee/LeavePayload.php#L67)

## Payroll\NZ\Employee\LeaveSetupPayload

[Source](../../src/Payroll/NZ/Employee/LeaveSetupPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/NZ/Employee/LeaveSetupPayload.php#L18)
- [`leaveType(string $leaveTypeId): Sujip\Xero\Payroll\NZ\Employee\LeaveSetupPayload`](../../src/Payroll/NZ/Employee/LeaveSetupPayload.php#L24)
- [`scheduleOfAccrual(string $scheduleOfAccrual): Sujip\Xero\Payroll\NZ\Employee\LeaveSetupPayload`](../../src/Payroll/NZ/Employee/LeaveSetupPayload.php#L32)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Employee\LeaveSetupPayload`](../../src/Payroll/NZ/Employee/LeaveSetupPayload.php#L40)
- [`save(): array`](../../src/Payroll/NZ/Employee/LeaveSetupPayload.php#L51)

## Payroll\NZ\Employee\OpeningBalancesPayload

[Source](../../src/Payroll/NZ/Employee/OpeningBalancesPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/NZ/Employee/OpeningBalancesPayload.php#L18)
- [`periodEndDate(string $periodEndDate): Sujip\Xero\Payroll\NZ\Employee\OpeningBalancesPayload`](../../src/Payroll/NZ/Employee/OpeningBalancesPayload.php#L24)
- [`daysPaid(int\|float $daysPaid): Sujip\Xero\Payroll\NZ\Employee\OpeningBalancesPayload`](../../src/Payroll/NZ/Employee/OpeningBalancesPayload.php#L32)
- [`grossEarnings(int\|float $grossEarnings): Sujip\Xero\Payroll\NZ\Employee\OpeningBalancesPayload`](../../src/Payroll/NZ/Employee/OpeningBalancesPayload.php#L40)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Employee\OpeningBalancesPayload`](../../src/Payroll/NZ/Employee/OpeningBalancesPayload.php#L48)
- [`save(): array`](../../src/Payroll/NZ/Employee/OpeningBalancesPayload.php#L59)

## Payroll\NZ\Employee\Payload

[Source](../../src/Payroll/NZ/Employee/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/Employee/Payload.php#L21)
- [`id(string $employeeId): Sujip\Xero\Payroll\NZ\Employee\Payload`](../../src/Payroll/NZ/Employee/Payload.php#L26)
- [`firstName(string $firstName): Sujip\Xero\Payroll\NZ\Employee\Payload`](../../src/Payroll/NZ/Employee/Payload.php#L34)
- [`lastName(string $lastName): Sujip\Xero\Payroll\NZ\Employee\Payload`](../../src/Payroll/NZ/Employee/Payload.php#L42)
- [`emailAddress(string $emailAddress): Sujip\Xero\Payroll\NZ\Employee\Payload`](../../src/Payroll/NZ/Employee/Payload.php#L50)
- [`dateOfBirth(string $dateOfBirth): Sujip\Xero\Payroll\NZ\Employee\Payload`](../../src/Payroll/NZ/Employee/Payload.php#L58)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Employee\Payload`](../../src/Payroll/NZ/Employee/Payload.php#L66)
- [`save(): Sujip\Xero\Payroll\NZ\Employee\Employee`](../../src/Payroll/NZ/Employee/Payload.php#L74)

## Payroll\NZ\Employee\PaymentMethodPayload

[Source](../../src/Payroll/NZ/Employee/PaymentMethodPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/NZ/Employee/PaymentMethodPayload.php#L18)
- [`bankAccountNumber(string $accountNumber): Sujip\Xero\Payroll\NZ\Employee\PaymentMethodPayload`](../../src/Payroll/NZ/Employee/PaymentMethodPayload.php#L24)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Employee\PaymentMethodPayload`](../../src/Payroll/NZ/Employee/PaymentMethodPayload.php#L34)
- [`save(): array`](../../src/Payroll/NZ/Employee/PaymentMethodPayload.php#L45)

## Payroll\NZ\Employee\SalaryAndWagePayload

[Source](../../src/Payroll/NZ/Employee/SalaryAndWagePayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/NZ/Employee/SalaryAndWagePayload.php#L18)
- [`paymentType(string $paymentType): Sujip\Xero\Payroll\NZ\Employee\SalaryAndWagePayload`](../../src/Payroll/NZ/Employee/SalaryAndWagePayload.php#L24)
- [`earningsRate(string $earningsRateId): Sujip\Xero\Payroll\NZ\Employee\SalaryAndWagePayload`](../../src/Payroll/NZ/Employee/SalaryAndWagePayload.php#L32)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Employee\SalaryAndWagePayload`](../../src/Payroll/NZ/Employee/SalaryAndWagePayload.php#L40)
- [`save(): array`](../../src/Payroll/NZ/Employee/SalaryAndWagePayload.php#L51)

## Payroll\NZ\Employee\WorkingPatternPayload

[Source](../../src/Payroll/NZ/Employee/WorkingPatternPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $employeeId)`](../../src/Payroll/NZ/Employee/WorkingPatternPayload.php#L18)
- [`effectiveFrom(string $effectiveFrom): Sujip\Xero\Payroll\NZ\Employee\WorkingPatternPayload`](../../src/Payroll/NZ/Employee/WorkingPatternPayload.php#L24)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Employee\WorkingPatternPayload`](../../src/Payroll/NZ/Employee/WorkingPatternPayload.php#L32)
- [`save(): array`](../../src/Payroll/NZ/Employee/WorkingPatternPayload.php#L43)

## Payroll\NZ\LeaveType\LeaveType

[Source](../../src/Payroll/NZ/LeaveType/LeaveType.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `leaveTypeID` | string or null | `setLeaveTypeID()` |
| `name` | string or null | `setName()` |
| `isPaidLeave` | bool or null | `setIsPaidLeave()` |
| `showOnPayslip` | bool or null | `setShowOnPayslip()` |
| `updatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `isActive` | bool or null | `setIsActive()` |
| `typeOfUnits` | string or null | `setTypeOfUnits()` |
| `typeOfUnitsToAccrue` | string or null | `setTypeOfUnitsToAccrue()` |

### Public methods

- [`__construct(?string $leaveTypeID = NULL, ?string $name = NULL, ?bool $isPaidLeave = NULL, ?bool $showOnPayslip = NULL, ?string $updatedDateUTC = NULL, ?bool $isActive = NULL, ?string $typeOfUnits = NULL, ?string $typeOfUnitsToAccrue = NULL)`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L12)
- [`getLeaveTypeID(): ?string`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L24)
- [`setLeaveTypeID(?string $leaveTypeID): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L29)
- [`getName(): ?string`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L36)
- [`setName(?string $name): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L41)
- [`getIsPaidLeave(): ?bool`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L48)
- [`setIsPaidLeave(?bool $isPaidLeave): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L53)
- [`getShowOnPayslip(): ?bool`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L60)
- [`setShowOnPayslip(?bool $showOnPayslip): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L65)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L72)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L77)
- [`getIsActive(): ?bool`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L84)
- [`setIsActive(?bool $isActive): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L89)
- [`getTypeOfUnits(): ?string`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L96)
- [`setTypeOfUnits(?string $typeOfUnits): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L101)
- [`getTypeOfUnitsToAccrue(): ?string`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L108)
- [`setTypeOfUnitsToAccrue(?string $typeOfUnitsToAccrue): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveType.php#L113)

## Payroll\NZ\LeaveType\LeaveTypes

[Source](../../src/Payroll/NZ/LeaveType/LeaveTypes.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L30)
- [`activeOnly(bool $activeOnly = true): Sujip\Xero\Payroll\NZ\LeaveType\LeaveTypes`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L38)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L49)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L68)
- [`find(string $leaveTypeId): ?\Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L83)
- [`create(array $leaveType, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L98)
- [`mapLeaveType(array $leaveType): Sujip\Xero\Payroll\NZ\LeaveType\LeaveType`](../../src/Payroll/NZ/LeaveType/LeaveTypes.php#L115)

## Payroll\NZ\PayItem\Deduction

[Source](../../src/Payroll/NZ/PayItem/Deduction.php)

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

### Public methods

- [`getDeductionId(): ?string`](../../src/Payroll/NZ/PayItem/Deduction.php#L25)
- [`setDeductionId(?string $deductionId): Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deduction.php#L30)
- [`getDeductionName(): ?string`](../../src/Payroll/NZ/PayItem/Deduction.php#L37)
- [`setDeductionName(?string $deductionName): Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deduction.php#L42)
- [`getDeductionCategory(): ?string`](../../src/Payroll/NZ/PayItem/Deduction.php#L49)
- [`setDeductionCategory(?string $deductionCategory): Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deduction.php#L54)
- [`getLiabilityAccountId(): ?string`](../../src/Payroll/NZ/PayItem/Deduction.php#L61)
- [`setLiabilityAccountId(?string $liabilityAccountId): Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deduction.php#L66)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/NZ/PayItem/Deduction.php#L73)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deduction.php#L78)
- [`getStandardAmount(): ?float`](../../src/Payroll/NZ/PayItem/Deduction.php#L85)
- [`setStandardAmount(?float $standardAmount): Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deduction.php#L90)
- [`toRequest(): array`](../../src/Payroll/NZ/PayItem/Deduction.php#L115)

## Payroll\NZ\PayItem\Deductions

[Source](../../src/Payroll/NZ/PayItem/Deductions.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/PayItem/Deductions.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/PayItem/Deductions.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/PayItem/Deductions.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/PayItem/Deductions.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/PayItem/Deductions.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/NZ/PayItem/Deductions.php#L55)
- [`find(string $deductionId): ?\Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deductions.php#L70)
- [`create(\Sujip\Xero\Payroll\NZ\PayItem\Deduction $deduction, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deductions.php#L82)
- [`mapDeduction(array $deduction): Sujip\Xero\Payroll\NZ\PayItem\Deduction`](../../src/Payroll/NZ/PayItem/Deductions.php#L99)

## Payroll\NZ\PayItem\EarningsRate

[Source](../../src/Payroll/NZ/PayItem/EarningsRate.php)

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

- [`getEarningsRateID(): ?string`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L33)
- [`setEarningsRateID(?string $earningsRateID): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L38)
- [`getName(): ?string`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L45)
- [`setName(?string $name): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L50)
- [`getEarningsType(): ?string`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L57)
- [`setEarningsType(?string $earningsType): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L62)
- [`getRateType(): ?string`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L69)
- [`setRateType(?string $rateType): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L74)
- [`getTypeOfUnits(): ?string`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L81)
- [`setTypeOfUnits(?string $typeOfUnits): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L86)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L93)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L98)
- [`getExpenseAccountID(): ?string`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L105)
- [`setExpenseAccountID(?string $expenseAccountID): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L110)
- [`getRatePerUnit(): ?float`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L117)
- [`setRatePerUnit(?float $ratePerUnit): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L122)
- [`getMultipleOfOrdinaryEarningsRate(): ?float`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L129)
- [`setMultipleOfOrdinaryEarningsRate(?float $multipleOfOrdinaryEarningsRate): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L134)
- [`getFixedAmount(): ?float`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L141)
- [`setFixedAmount(?float $fixedAmount): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L146)
- [`toRequest(): array`](../../src/Payroll/NZ/PayItem/EarningsRate.php#L175)

## Payroll\NZ\PayItem\EarningsRates

[Source](../../src/Payroll/NZ/PayItem/EarningsRates.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L55)
- [`find(string $earningsRateId): ?\Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L70)
- [`create(\Sujip\Xero\Payroll\NZ\PayItem\EarningsRate $earningsRate, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L82)
- [`mapEarningsRate(array $earningsRate): Sujip\Xero\Payroll\NZ\PayItem\EarningsRate`](../../src/Payroll/NZ/PayItem/EarningsRates.php#L99)

## Payroll\NZ\PayItem\Superannuation

[Source](../../src/Payroll/NZ/PayItem/Superannuation.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `()` |
| `name` | string or null | `()` |
| `category` | string or null | `()` |
| `liabilityAccountId` | string or null | `()` |
| `expenseAccountId` | string or null | `()` |
| `calculationTypeNZ` | string or null | `()` |
| `standardAmount` | int, float, or null | `()` |
| `percentage` | int, float, or null | `()` |
| `companyMax` | int, float, or null | `()` |

### Public methods

- [`getId(): ?string`](../../src/Payroll/NZ/PayItem/Superannuation.php#L31)
- [`setId(?string $id): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L36)
- [`getName(): ?string`](../../src/Payroll/NZ/PayItem/Superannuation.php#L43)
- [`setName(?string $name): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L48)
- [`getCategory(): ?string`](../../src/Payroll/NZ/PayItem/Superannuation.php#L55)
- [`setCategory(?string $category): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L60)
- [`getLiabilityAccountId(): ?string`](../../src/Payroll/NZ/PayItem/Superannuation.php#L67)
- [`setLiabilityAccountId(?string $liabilityAccountId): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L72)
- [`getExpenseAccountId(): ?string`](../../src/Payroll/NZ/PayItem/Superannuation.php#L79)
- [`setExpenseAccountId(?string $expenseAccountId): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L84)
- [`getCalculationTypeNZ(): ?string`](../../src/Payroll/NZ/PayItem/Superannuation.php#L91)
- [`setCalculationTypeNZ(?string $calculationTypeNZ): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L96)
- [`getStandardAmount(): ?float`](../../src/Payroll/NZ/PayItem/Superannuation.php#L103)
- [`setStandardAmount(?float $standardAmount): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L108)
- [`getPercentage(): ?float`](../../src/Payroll/NZ/PayItem/Superannuation.php#L115)
- [`setPercentage(?float $percentage): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L120)
- [`getCompanyMax(): ?float`](../../src/Payroll/NZ/PayItem/Superannuation.php#L127)
- [`setCompanyMax(?float $companyMax): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuation.php#L132)
- [`toRequest(): array`](../../src/Payroll/NZ/PayItem/Superannuation.php#L160)

## Payroll\NZ\PayItem\Superannuations

[Source](../../src/Payroll/NZ/PayItem/Superannuations.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/PayItem/Superannuations.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/PayItem/Superannuations.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/PayItem/Superannuations.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/PayItem/Superannuations.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/PayItem/Superannuations.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/NZ/PayItem/Superannuations.php#L55)
- [`find(string $superannuationId): ?\Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuations.php#L70)
- [`create(\Sujip\Xero\Payroll\NZ\PayItem\Superannuation $superannuation, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuations.php#L82)
- [`mapSuperannuation(array $superannuation): Sujip\Xero\Payroll\NZ\PayItem\Superannuation`](../../src/Payroll/NZ/PayItem/Superannuations.php#L99)

## Payroll\NZ\PayRunCalendar\PayRunCalendar

[Source](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php)

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

- [`__construct(?string $payrollCalendarID = NULL, ?string $name = NULL, ?string $calendarType = NULL, ?string $periodStartDate = NULL, ?string $periodEndDate = NULL, ?string $paymentDate = NULL, ?string $updatedDateUTC = NULL)`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L12)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L23)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L28)
- [`getName(): ?string`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L35)
- [`setName(?string $name): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L40)
- [`getCalendarType(): ?string`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L47)
- [`setCalendarType(?string $calendarType): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L52)
- [`getPeriodStartDate(): ?string`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L59)
- [`setPeriodStartDate(?string $periodStartDate): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L64)
- [`getPeriodEndDate(): ?string`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L71)
- [`setPeriodEndDate(?string $periodEndDate): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L76)
- [`getPaymentDate(): ?string`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L83)
- [`setPaymentDate(?string $paymentDate): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L88)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L95)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendar.php#L100)

## Payroll\NZ\PayRunCalendar\PayRunCalendars

[Source](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L20)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L55)
- [`find(string $payRunCalendarId): ?\Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L70)
- [`create(array $calendar, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L85)
- [`mapPayRunCalendar(array $calendar): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar`](../../src/Payroll/NZ/PayRunCalendar/PayRunCalendars.php#L102)

## Payroll\NZ\PayRun\PayRun

[Source](../../src/Payroll/NZ/PayRun/PayRun.php)

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
| `paySlips` | list of objects ([Payroll\NZ\PaySlip\PaySlip](payroll-nz.md#payrollnzpayslippayslip)) | `()` |

### Public methods

- [`__construct(?string $payRunID = NULL, ?string $payrollCalendarID = NULL, ?string $periodStartDate = NULL, ?string $periodEndDate = NULL, ?string $paymentDate = NULL, ?float $totalCost = NULL, ?float $totalPay = NULL, ?string $payRunStatus = NULL, ?string $payRunType = NULL, ?string $calendarType = NULL, ?string $postedDateTime = NULL)`](../../src/Payroll/NZ/PayRun/PayRun.php#L18)
- [`getPayRunID(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L33)
- [`setPayRunID(?string $payRunID): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L38)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L45)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L50)
- [`getPeriodStartDate(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L57)
- [`setPeriodStartDate(?string $periodStartDate): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L62)
- [`getPeriodEndDate(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L69)
- [`setPeriodEndDate(?string $periodEndDate): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L74)
- [`getPaymentDate(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L81)
- [`setPaymentDate(?string $paymentDate): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L86)
- [`getTotalCost(): ?float`](../../src/Payroll/NZ/PayRun/PayRun.php#L93)
- [`setTotalCost(?float $totalCost): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L98)
- [`getTotalPay(): ?float`](../../src/Payroll/NZ/PayRun/PayRun.php#L105)
- [`setTotalPay(?float $totalPay): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L110)
- [`getPayRunStatus(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L117)
- [`setPayRunStatus(?string $payRunStatus): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L122)
- [`getPayRunType(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L129)
- [`setPayRunType(?string $payRunType): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L134)
- [`getCalendarType(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L141)
- [`setCalendarType(?string $calendarType): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L146)
- [`getPostedDateTime(): ?string`](../../src/Payroll/NZ/PayRun/PayRun.php#L153)
- [`setPostedDateTime(?string $postedDateTime): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L158)
- [`getPaySlips(): array`](../../src/Payroll/NZ/PayRun/PayRun.php#L168)
- [`addPaySlip(\Sujip\Xero\Payroll\NZ\PaySlip\PaySlip $paySlip): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRun.php#L173)

## Payroll\NZ\PayRun\PayRuns

[Source](../../src/Payroll/NZ/PayRun/PayRuns.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/PayRun/PayRuns.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/PayRun/PayRuns.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/PayRun/PayRuns.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/PayRun/PayRuns.php#L30)
- [`status(string $status): Sujip\Xero\Payroll\NZ\PayRun\PayRuns`](../../src/Payroll/NZ/PayRun/PayRuns.php#L38)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/PayRun/PayRuns.php#L49)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/NZ/PayRun/PayRuns.php#L68)
- [`find(string $payRunId): ?\Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRuns.php#L83)
- [`create(): Sujip\Xero\Payroll\NZ\PayRun\Payload`](../../src/Payroll/NZ/PayRun/PayRuns.php#L95)
- [`mapPayRun(array $payRun): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/PayRuns.php#L103)

## Payroll\NZ\PayRun\Payload

[Source](../../src/Payroll/NZ/PayRun/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/PayRun/Payload.php#L19)
- [`payrollCalendar(string $payrollCalendarId): Sujip\Xero\Payroll\NZ\PayRun\Payload`](../../src/Payroll/NZ/PayRun/Payload.php#L24)
- [`paymentDate(string $paymentDate): Sujip\Xero\Payroll\NZ\PayRun\Payload`](../../src/Payroll/NZ/PayRun/Payload.php#L32)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\PayRun\Payload`](../../src/Payroll/NZ/PayRun/Payload.php#L40)
- [`save(): Sujip\Xero\Payroll\NZ\PayRun\PayRun`](../../src/Payroll/NZ/PayRun/Payload.php#L48)

## Payroll\NZ\PaySlip\PaySlip

[Source](../../src/Payroll/NZ/PaySlip/PaySlip.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `paySlipID` | string or null | `()` |
| `employeeID` | string or null | `()` |
| `payRunID` | string or null | `()` |
| `lastEdited` | string or null | `()` |
| `firstName` | string or null | `()` |
| `lastName` | string or null | `()` |
| `totalEarnings` | int, float, or null | `()` |
| `grossEarnings` | int, float, or null | `()` |
| `totalPay` | int, float, or null | `()` |
| `totalEmployerTaxes` | int, float, or null | `()` |
| `totalEmployeeTaxes` | int, float, or null | `()` |
| `totalDeductions` | int, float, or null | `()` |
| `totalReimbursements` | int, float, or null | `()` |
| `totalStatutoryDeductions` | int, float, or null | `()` |
| `totalSuperannuation` | int, float, or null | `()` |
| `bacsHash` | string or null | `()` |
| `paymentMethod` | string or null | `()` |
| `earningsLines` | array | `()` |
| `leaveEarningsLines` | array | `()` |
| `timesheetEarningsLines` | array | `()` |
| `deductionLines` | array | `()` |
| `reimbursementLines` | array | `()` |
| `leaveAccrualLines` | array | `()` |
| `superannuationLines` | array | `()` |
| `paymentLines` | array | `()` |
| `employeeTaxLines` | array | `()` |
| `employerTaxLines` | array | `()` |
| `statutoryDeductionLines` | array | `()` |
| `taxSettings` | array | `()` |
| `grossEarningsHistory` | array | `()` |

### Public methods

- [`getPaySlipID(): ?string`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L112)
- [`setPaySlipID(?string $paySlipID): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L117)
- [`getEmployeeID(): ?string`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L124)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L129)
- [`getPayRunID(): ?string`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L136)
- [`setPayRunID(?string $payRunID): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L141)
- [`getLastEdited(): ?string`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L148)
- [`setLastEdited(?string $lastEdited): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L153)
- [`getFirstName(): ?string`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L160)
- [`setFirstName(?string $firstName): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L165)
- [`getLastName(): ?string`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L172)
- [`setLastName(?string $lastName): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L177)
- [`getTotalEarnings(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L184)
- [`setTotalEarnings(?float $totalEarnings): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L189)
- [`getGrossEarnings(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L196)
- [`setGrossEarnings(?float $grossEarnings): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L201)
- [`getTotalPay(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L208)
- [`setTotalPay(?float $totalPay): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L213)
- [`getTotalEmployerTaxes(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L220)
- [`setTotalEmployerTaxes(?float $totalEmployerTaxes): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L225)
- [`getTotalEmployeeTaxes(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L232)
- [`setTotalEmployeeTaxes(?float $totalEmployeeTaxes): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L237)
- [`getTotalDeductions(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L244)
- [`setTotalDeductions(?float $totalDeductions): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L249)
- [`getTotalReimbursements(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L256)
- [`setTotalReimbursements(?float $totalReimbursements): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L261)
- [`getTotalStatutoryDeductions(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L268)
- [`setTotalStatutoryDeductions(?float $totalStatutoryDeductions): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L273)
- [`getTotalSuperannuation(): ?float`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L280)
- [`setTotalSuperannuation(?float $totalSuperannuation): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L285)
- [`getBacsHash(): ?string`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L292)
- [`setBacsHash(?string $bacsHash): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L297)
- [`getPaymentMethod(): ?string`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L304)
- [`setPaymentMethod(?string $paymentMethod): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L309)
- [`getEarningsLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L319)
- [`setEarningsLines(array $earningsLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L327)
- [`getLeaveEarningsLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L337)
- [`setLeaveEarningsLines(array $leaveEarningsLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L345)
- [`getTimesheetEarningsLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L355)
- [`setTimesheetEarningsLines(array $timesheetEarningsLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L363)
- [`getDeductionLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L373)
- [`setDeductionLines(array $deductionLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L381)
- [`getReimbursementLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L391)
- [`setReimbursementLines(array $reimbursementLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L399)
- [`getLeaveAccrualLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L409)
- [`setLeaveAccrualLines(array $leaveAccrualLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L417)
- [`getSuperannuationLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L427)
- [`setSuperannuationLines(array $superannuationLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L435)
- [`getPaymentLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L445)
- [`setPaymentLines(array $paymentLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L453)
- [`getEmployeeTaxLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L463)
- [`setEmployeeTaxLines(array $employeeTaxLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L471)
- [`getEmployerTaxLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L481)
- [`setEmployerTaxLines(array $employerTaxLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L489)
- [`getStatutoryDeductionLines(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L499)
- [`setStatutoryDeductionLines(array $statutoryDeductionLines): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L507)
- [`getTaxSettings(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L517)
- [`setTaxSettings(array $taxSettings): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L525)
- [`getGrossEarningsHistory(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L535)
- [`setGrossEarningsHistory(array $grossEarningsHistory): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L543)
- [`toRequest(): array`](../../src/Payroll/NZ/PaySlip/PaySlip.php#L592)

## Payroll\NZ\PaySlip\PaySlips

[Source](../../src/Payroll/NZ/PaySlip/PaySlips.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/PaySlip/PaySlips.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/PaySlip/PaySlips.php#L18)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/PaySlip/PaySlips.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/PaySlip/PaySlips.php#L23)
- [`get(string $payRunId): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/PaySlip/PaySlips.php#L36)
- [`find(string $paySlipId): ?\Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlips.php#L52)
- [`updateLineItems(string $paySlipId, \Sujip\Xero\Payroll\NZ\PaySlip\PaySlip $paySlip, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlips.php#L64)
- [`mapPaySlip(array $paySlip): Sujip\Xero\Payroll\NZ\PaySlip\PaySlip`](../../src/Payroll/NZ/PaySlip/PaySlips.php#L81)

## Payroll\NZ\PayrollNZ

[Source](../../src/Payroll/NZ/PayrollNZ.php)

Extends [Payroll\Shared\PayrollRegion](payroll.md#payrollsharedpayrollregion). Inherited methods are documented on the parent type.

### Public methods

- [`employees(): Sujip\Xero\Payroll\NZ\Employee\Employees`](../../src/Payroll/NZ/PayrollNZ.php#L21)
- [`leaveTypes(): Sujip\Xero\Payroll\NZ\LeaveType\LeaveTypes`](../../src/Payroll/NZ/PayrollNZ.php#L26)
- [`deductions(): Sujip\Xero\Payroll\NZ\PayItem\Deductions`](../../src/Payroll/NZ/PayrollNZ.php#L31)
- [`earningsRates(): Sujip\Xero\Payroll\NZ\PayItem\EarningsRates`](../../src/Payroll/NZ/PayrollNZ.php#L36)
- [`superannuations(): Sujip\Xero\Payroll\NZ\PayItem\Superannuations`](../../src/Payroll/NZ/PayrollNZ.php#L41)
- [`payRunCalendars(): Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendars`](../../src/Payroll/NZ/PayrollNZ.php#L46)
- [`payRuns(): Sujip\Xero\Payroll\NZ\PayRun\PayRuns`](../../src/Payroll/NZ/PayrollNZ.php#L51)
- [`paySlips(): Sujip\Xero\Payroll\NZ\PaySlip\PaySlips`](../../src/Payroll/NZ/PayrollNZ.php#L56)
- [`timesheets(): Sujip\Xero\Payroll\NZ\Timesheet\Timesheets`](../../src/Payroll/NZ/PayrollNZ.php#L61)
- [`settings(): Sujip\Xero\Payroll\NZ\Settings\Settings`](../../src/Payroll/NZ/PayrollNZ.php#L66)

## Payroll\NZ\Settings\PayrollSettings

[Source](../../src/Payroll/NZ/Settings/PayrollSettings.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accounts` | array | `setAccounts()` |

### Public methods

- [`__construct(array $accounts = array (
))`](../../src/Payroll/NZ/Settings/PayrollSettings.php#L15)
- [`getAccounts(): array`](../../src/Payroll/NZ/Settings/PayrollSettings.php#L23)
- [`setAccounts(array $accounts): Sujip\Xero\Payroll\NZ\Settings\PayrollSettings`](../../src/Payroll/NZ/Settings/PayrollSettings.php#L31)

## Payroll\NZ\Settings\Reimbursement

[Source](../../src/Payroll/NZ/Settings/Reimbursement.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `reimbursementID` | string or null | `setReimbursementID()` |
| `name` | string or null | `setName()` |
| `accountID` | string or null | `setAccountID()` |
| `currentRecord` | bool or null | `setCurrentRecord()` |
| `reimbursementCategory` | string or null | `setReimbursementCategory()` |
| `calculationType` | string or null | `setCalculationType()` |
| `standardAmount` | string or null | `setStandardAmount()` |
| `standardTypeOfUnits` | string or null | `setStandardTypeOfUnits()` |
| `standardRatePerUnit` | int, float, or null | `setStandardRatePerUnit()` |

### Public methods

- [`__construct(?string $reimbursementID = NULL, ?string $name = NULL, ?string $accountID = NULL, ?bool $currentRecord = NULL, ?string $reimbursementCategory = NULL, ?string $calculationType = NULL, ?string $standardAmount = NULL, ?string $standardTypeOfUnits = NULL, ?float $standardRatePerUnit = NULL)`](../../src/Payroll/NZ/Settings/Reimbursement.php#L12)
- [`getReimbursementID(): ?string`](../../src/Payroll/NZ/Settings/Reimbursement.php#L25)
- [`setReimbursementID(?string $reimbursementID): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L30)
- [`getName(): ?string`](../../src/Payroll/NZ/Settings/Reimbursement.php#L37)
- [`setName(?string $name): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L42)
- [`getAccountID(): ?string`](../../src/Payroll/NZ/Settings/Reimbursement.php#L49)
- [`setAccountID(?string $accountID): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L54)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/NZ/Settings/Reimbursement.php#L61)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L66)
- [`getReimbursementCategory(): ?string`](../../src/Payroll/NZ/Settings/Reimbursement.php#L73)
- [`setReimbursementCategory(?string $reimbursementCategory): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L78)
- [`getCalculationType(): ?string`](../../src/Payroll/NZ/Settings/Reimbursement.php#L85)
- [`setCalculationType(?string $calculationType): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L90)
- [`getStandardAmount(): ?string`](../../src/Payroll/NZ/Settings/Reimbursement.php#L97)
- [`setStandardAmount(?string $standardAmount): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L102)
- [`getStandardTypeOfUnits(): ?string`](../../src/Payroll/NZ/Settings/Reimbursement.php#L109)
- [`setStandardTypeOfUnits(?string $standardTypeOfUnits): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L114)
- [`getStandardRatePerUnit(): ?float`](../../src/Payroll/NZ/Settings/Reimbursement.php#L121)
- [`setStandardRatePerUnit(int\|float\|null $standardRatePerUnit): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Reimbursement.php#L126)

## Payroll\NZ\Settings\ReimbursementPayload

[Source](../../src/Payroll/NZ/Settings/ReimbursementPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L19)
- [`name(string $name): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L24)
- [`account(string $accountId): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L32)
- [`category(string $category): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L40)
- [`calculationType(string $calculationType): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L48)
- [`standardAmount(string $standardAmount): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L56)
- [`standardTypeOfUnits(string $standardTypeOfUnits): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L64)
- [`standardRatePerUnit(float $standardRatePerUnit): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L72)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L80)
- [`save(): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/ReimbursementPayload.php#L88)

## Payroll\NZ\Settings\Settings

[Source](../../src/Payroll/NZ/Settings/Settings.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/Settings/Settings.php#L15)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/Settings/Settings.php#L20)
- [`get(): Sujip\Xero\Payroll\NZ\Settings\PayrollSettings`](../../src/Payroll/NZ/Settings/Settings.php#L28)
- [`trackingCategories(): array`](../../src/Payroll/NZ/Settings/Settings.php#L48)
- [`statutoryDeductions(?int $page = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/Settings/Settings.php#L61)
- [`statutoryDeduction(string $id): ?\Sujip\Xero\Payroll\NZ\Settings\StatutoryDeduction`](../../src/Payroll/NZ/Settings/Settings.php#L79)
- [`reimbursements(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/Settings/Settings.php#L94)
- [`reimbursement(string $reimbursementId): ?\Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Settings.php#L109)
- [`createReimbursement(): Sujip\Xero\Payroll\NZ\Settings\ReimbursementPayload`](../../src/Payroll/NZ/Settings/Settings.php#L121)
- [`mapSettings(array $settings): Sujip\Xero\Payroll\NZ\Settings\PayrollSettings`](../../src/Payroll/NZ/Settings/Settings.php#L129)
- [`mapStatutoryDeduction(array $deduction): Sujip\Xero\Payroll\NZ\Settings\StatutoryDeduction`](../../src/Payroll/NZ/Settings/Settings.php#L137)
- [`mapReimbursement(array $reimbursement): Sujip\Xero\Payroll\NZ\Settings\Reimbursement`](../../src/Payroll/NZ/Settings/Settings.php#L145)

## Payroll\NZ\Settings\StatutoryDeduction

[Source](../../src/Payroll/NZ/Settings/StatutoryDeduction.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `setId()` |
| `name` | string or null | `setName()` |
| `statutoryDeductionCategory` | string or null | `setStatutoryDeductionCategory()` |
| `liabilityAccountId` | string or null | `setLiabilityAccountId()` |
| `currentRecord` | bool or null | `setCurrentRecord()` |

### Public methods

- [`__construct(?string $id = NULL, ?string $name = NULL, ?string $statutoryDeductionCategory = NULL, ?string $liabilityAccountId = NULL, ?bool $currentRecord = NULL)`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L12)
- [`getId(): ?string`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L21)
- [`setId(?string $id): Sujip\Xero\Payroll\NZ\Settings\StatutoryDeduction`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L26)
- [`getName(): ?string`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L33)
- [`setName(?string $name): Sujip\Xero\Payroll\NZ\Settings\StatutoryDeduction`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L38)
- [`getStatutoryDeductionCategory(): ?string`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L45)
- [`setStatutoryDeductionCategory(?string $statutoryDeductionCategory): Sujip\Xero\Payroll\NZ\Settings\StatutoryDeduction`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L50)
- [`getLiabilityAccountId(): ?string`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L57)
- [`setLiabilityAccountId(?string $liabilityAccountId): Sujip\Xero\Payroll\NZ\Settings\StatutoryDeduction`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L62)
- [`getCurrentRecord(): ?bool`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L69)
- [`setCurrentRecord(?bool $currentRecord): Sujip\Xero\Payroll\NZ\Settings\StatutoryDeduction`](../../src/Payroll/NZ/Settings/StatutoryDeduction.php#L74)

## Payroll\NZ\Timesheet\Payload

[Source](../../src/Payroll/NZ/Timesheet/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/Timesheet/Payload.php#L19)
- [`payrollCalendar(string $payrollCalendarId): Sujip\Xero\Payroll\NZ\Timesheet\Payload`](../../src/Payroll/NZ/Timesheet/Payload.php#L24)
- [`employee(string $employeeId): Sujip\Xero\Payroll\NZ\Timesheet\Payload`](../../src/Payroll/NZ/Timesheet/Payload.php#L32)
- [`startDate(string $startDate): Sujip\Xero\Payroll\NZ\Timesheet\Payload`](../../src/Payroll/NZ/Timesheet/Payload.php#L40)
- [`endDate(string $endDate): Sujip\Xero\Payroll\NZ\Timesheet\Payload`](../../src/Payroll/NZ/Timesheet/Payload.php#L48)
- [`status(string $status): Sujip\Xero\Payroll\NZ\Timesheet\Payload`](../../src/Payroll/NZ/Timesheet/Payload.php#L56)
- [`idempotencyKey(string $key): Sujip\Xero\Payroll\NZ\Timesheet\Payload`](../../src/Payroll/NZ/Timesheet/Payload.php#L64)
- [`save(): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Payload.php#L72)

## Payroll\NZ\Timesheet\Timesheet

[Source](../../src/Payroll/NZ/Timesheet/Timesheet.php)

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
| `timesheetLines` | list of objects ([Payroll\NZ\Timesheet\TimesheetLine](payroll-nz.md#payrollnztimesheettimesheetline)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L28)
- [`getTimesheetID(): ?string`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L33)
- [`setTimesheetID(?string $timesheetID): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L38)
- [`getPayrollCalendarID(): ?string`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L45)
- [`setPayrollCalendarID(?string $payrollCalendarID): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L50)
- [`getEmployeeID(): ?string`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L57)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L62)
- [`getStartDate(): ?string`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L69)
- [`setStartDate(?string $startDate): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L74)
- [`getEndDate(): ?string`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L81)
- [`setEndDate(?string $endDate): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L86)
- [`getStatus(): ?string`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L93)
- [`setStatus(?string $status): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L98)
- [`getTotalHours(): ?float`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L105)
- [`setTotalHours(?float $totalHours): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L110)
- [`getUpdatedDateUTC(): ?string`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L117)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L122)
- [`getTimesheetLines(): array`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L132)
- [`addTimesheetLine(\Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine $timesheetLine): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L137)
- [`save(): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L162)
- [`approve(): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L193)
- [`revert(): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L202)
- [`delete(): bool`](../../src/Payroll/NZ/Timesheet/Timesheet.php#L211)

## Payroll\NZ\Timesheet\TimesheetLine

[Source](../../src/Payroll/NZ/Timesheet/TimesheetLine.php)

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

- [`getTimesheetLineID(): ?string`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L23)
- [`setTimesheetLineID(?string $timesheetLineID): Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L28)
- [`getDate(): ?string`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L35)
- [`setDate(?string $date): Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L40)
- [`getEarningsRateID(): ?string`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L47)
- [`setEarningsRateID(?string $earningsRateID): Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L52)
- [`getTrackingItemID(): ?string`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L59)
- [`setTrackingItemID(?string $trackingItemID): Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L64)
- [`getNumberOfUnits(): ?float`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L71)
- [`setNumberOfUnits(?float $numberOfUnits): Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L76)
- [`toRequest(): array`](../../src/Payroll/NZ/Timesheet/TimesheetLine.php#L100)

## Payroll\NZ\Timesheet\Timesheets

[Source](../../src/Payroll/NZ/Timesheet/Timesheets.php)

### Public methods

- [`page(int $page): static`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L13)
- [`perPage(int $perPage): static`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L30)
- [`status(string $status): Sujip\Xero\Payroll\NZ\Timesheet\Timesheets`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L38)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L49)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L68)
- [`find(string $timesheetId): ?\Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L83)
- [`create(): Sujip\Xero\Payroll\NZ\Timesheet\Payload`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L95)
- [`approve(string $timesheetId): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L100)
- [`revert(string $timesheetId): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L112)
- [`delete(string $timesheetId): bool`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L124)
- [`createLine(string $timesheetId, \Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine $line, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L133)
- [`updateLine(string $timesheetId, string $timesheetLineId, \Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine $line, ?string $idempotencyKey = NULL): Sujip\Xero\Payroll\NZ\Timesheet\TimesheetLine`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L145)
- [`deleteLine(string $timesheetId, string $timesheetLineId): bool`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L157)
- [`mapTimesheet(array $timesheet): Sujip\Xero\Payroll\NZ\Timesheet\Timesheet`](../../src/Payroll/NZ/Timesheet/Timesheets.php#L169)
