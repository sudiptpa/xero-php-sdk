# Projects reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Projects\ProjectUser\ProjectUser](#projectsprojectuserprojectuser)
- [Projects\ProjectUser\ProjectUsers](#projectsprojectuserprojectusers)
- [Projects\Project\Amount](#projectsprojectamount)
- [Projects\Project\Patch](#projectsprojectpatch)
- [Projects\Project\Payload](#projectsprojectpayload)
- [Projects\Project\Project](#projectsprojectproject)
- [Projects\Project\Projects](#projectsprojectprojects)
- [Projects\Projects](#projectsprojects)
- [Projects\Task\Payload](#projectstaskpayload)
- [Projects\Task\Task](#projectstasktask)
- [Projects\Task\Tasks](#projectstasktasks)
- [Projects\TimeEntry\Payload](#projectstimeentrypayload)
- [Projects\TimeEntry\TimeEntries](#projectstimeentrytimeentries)
- [Projects\TimeEntry\TimeEntry](#projectstimeentrytimeentry)

## Projects\ProjectUser\ProjectUser

[Source](../../src/Projects/ProjectUser/ProjectUser.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `userId` | string or null | `()` |
| `name` | string or null | `()` |
| `email` | string or null | `()` |

### Public methods

- [`getUserId(): ?string`](../../src/Projects/ProjectUser/ProjectUser.php#L18)
- [`setUserId(?string $userId): Sujip\Xero\Projects\ProjectUser\ProjectUser`](../../src/Projects/ProjectUser/ProjectUser.php#L23)
- [`getName(): ?string`](../../src/Projects/ProjectUser/ProjectUser.php#L30)
- [`setName(?string $name): Sujip\Xero\Projects\ProjectUser\ProjectUser`](../../src/Projects/ProjectUser/ProjectUser.php#L35)
- [`getEmail(): ?string`](../../src/Projects/ProjectUser/ProjectUser.php#L42)
- [`setEmail(?string $email): Sujip\Xero\Projects\ProjectUser\ProjectUser`](../../src/Projects/ProjectUser/ProjectUser.php#L47)

## Projects\ProjectUser\ProjectUsers

[Source](../../src/Projects/ProjectUser/ProjectUsers.php)

### Public methods

- [`page(int $page): static`](../../src/Projects/ProjectUser/ProjectUsers.php#L13)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Projects/ProjectUser/ProjectUsers.php#L20)
- [`perPage(int $perPage): static`](../../src/Projects/ProjectUser/ProjectUsers.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Projects/ProjectUser/ProjectUsers.php#L25)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Projects/ProjectUser/ProjectUsers.php#L36)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Projects/ProjectUser/ProjectUsers.php#L55)
- [`mapProjectUser(array $user): Sujip\Xero\Projects\ProjectUser\ProjectUser`](../../src/Projects/ProjectUser/ProjectUsers.php#L73)

## Projects\Project\Amount

[Source](../../src/Projects/Project/Amount.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `currency` | string or null | `()` |
| `value` | int, float, or null | `()` |

### Public methods

- [`getCurrency(): ?string`](../../src/Projects/Project/Amount.php#L16)
- [`setCurrency(?string $currency): Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Amount.php#L21)
- [`getValue(): int\|float\|null`](../../src/Projects/Project/Amount.php#L28)
- [`setValue(int\|float\|null $value): Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Amount.php#L33)

## Projects\Project\Patch

[Source](../../src/Projects/Project/Patch.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $projectId)`](../../src/Projects/Project/Patch.php#L18)
- [`state(string $state): Sujip\Xero\Projects\Project\Patch`](../../src/Projects/Project/Patch.php#L24)
- [`close(): Sujip\Xero\Projects\Project\Patch`](../../src/Projects/Project/Patch.php#L32)
- [`reopen(): Sujip\Xero\Projects\Project\Patch`](../../src/Projects/Project/Patch.php#L37)
- [`idempotencyKey(string $key): Sujip\Xero\Projects\Project\Patch`](../../src/Projects/Project/Patch.php#L42)
- [`save(): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Patch.php#L50)

## Projects\Project\Payload

[Source](../../src/Projects/Project/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Projects/Project/Payload.php#L21)
- [`id(string $projectId): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Project/Payload.php#L26)
- [`title(string $title): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Project/Payload.php#L34)
- [`contact(string $contactId): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Project/Payload.php#L42)
- [`estimateAmount(int\|float $amount): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Project/Payload.php#L50)
- [`deadline(\DateTimeInterface\|string $deadlineUtc): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Project/Payload.php#L58)
- [`idempotencyKey(string $key): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Project/Payload.php#L68)
- [`save(): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Payload.php#L76)

## Projects\Project\Project

[Source](../../src/Projects/Project/Project.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `projectId` | string or null | `()` |
| `contactId` | string or null | `()` |
| `name` | string or null | `()` |
| `currencyCode` | string or null | `()` |
| `minutesLogged` | int, float, or null | `()` |
| `totalTaskAmount` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `totalExpenseAmount` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `estimateAmount` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `minutesToBeInvoiced` | int, float, or null | `()` |
| `taskAmountToBeInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `taskAmountInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `expenseAmountToBeInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `expenseAmountInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `projectAmountInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `deposit` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `depositApplied` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `creditNoteAmount` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `deadlineUtc` | string or null | `()` |
| `totalInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `totalToBeInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `estimate` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `status` | string or null | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Projects/Project/Project.php#L60)
- [`getProjectId(): ?string`](../../src/Projects/Project/Project.php#L65)
- [`setProjectId(?string $projectId): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L70)
- [`getContactId(): ?string`](../../src/Projects/Project/Project.php#L77)
- [`setContactId(?string $contactId): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L82)
- [`getName(): ?string`](../../src/Projects/Project/Project.php#L89)
- [`setName(?string $name): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L94)
- [`getCurrencyCode(): ?string`](../../src/Projects/Project/Project.php#L101)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L106)
- [`getMinutesLogged(): ?int`](../../src/Projects/Project/Project.php#L113)
- [`setMinutesLogged(?int $minutesLogged): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L118)
- [`getTotalTaskAmount(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L125)
- [`setTotalTaskAmount(?\Sujip\Xero\Projects\Project\Amount $totalTaskAmount): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L130)
- [`getTotalExpenseAmount(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L137)
- [`setTotalExpenseAmount(?\Sujip\Xero\Projects\Project\Amount $totalExpenseAmount): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L142)
- [`getEstimateAmount(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L149)
- [`setEstimateAmount(?\Sujip\Xero\Projects\Project\Amount $estimateAmount): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L154)
- [`getMinutesToBeInvoiced(): ?int`](../../src/Projects/Project/Project.php#L161)
- [`setMinutesToBeInvoiced(?int $minutesToBeInvoiced): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L166)
- [`getTaskAmountToBeInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L173)
- [`setTaskAmountToBeInvoiced(?\Sujip\Xero\Projects\Project\Amount $taskAmountToBeInvoiced): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L178)
- [`getTaskAmountInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L185)
- [`setTaskAmountInvoiced(?\Sujip\Xero\Projects\Project\Amount $taskAmountInvoiced): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L190)
- [`getExpenseAmountToBeInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L197)
- [`setExpenseAmountToBeInvoiced(?\Sujip\Xero\Projects\Project\Amount $expenseAmountToBeInvoiced): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L202)
- [`getExpenseAmountInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L209)
- [`setExpenseAmountInvoiced(?\Sujip\Xero\Projects\Project\Amount $expenseAmountInvoiced): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L214)
- [`getProjectAmountInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L221)
- [`setProjectAmountInvoiced(?\Sujip\Xero\Projects\Project\Amount $projectAmountInvoiced): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L226)
- [`getDeposit(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L233)
- [`setDeposit(?\Sujip\Xero\Projects\Project\Amount $deposit): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L238)
- [`getDepositApplied(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L245)
- [`setDepositApplied(?\Sujip\Xero\Projects\Project\Amount $depositApplied): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L250)
- [`getCreditNoteAmount(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L257)
- [`setCreditNoteAmount(?\Sujip\Xero\Projects\Project\Amount $creditNoteAmount): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L262)
- [`getDeadlineUtc(): ?string`](../../src/Projects/Project/Project.php#L269)
- [`setDeadlineUtc(?string $deadlineUtc): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L274)
- [`getTotalInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L281)
- [`setTotalInvoiced(?\Sujip\Xero\Projects\Project\Amount $totalInvoiced): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L286)
- [`getTotalToBeInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L293)
- [`setTotalToBeInvoiced(?\Sujip\Xero\Projects\Project\Amount $totalToBeInvoiced): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L298)
- [`getEstimate(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Project/Project.php#L305)
- [`setEstimate(?\Sujip\Xero\Projects\Project\Amount $estimate): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L310)
- [`getStatus(): ?string`](../../src/Projects/Project/Project.php#L317)
- [`setStatus(?string $status): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L322)
- [`name(string $name): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L360)
- [`status(string $status): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L365)
- [`deadline(string $deadlineUtc): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L370)
- [`save(): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L375)
- [`tasks(): Sujip\Xero\Projects\Task\Tasks`](../../src/Projects/Project/Project.php#L402)
- [`timeEntries(): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/Project/Project.php#L411)
- [`close(): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L420)
- [`reopen(): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Project.php#L429)

## Projects\Project\Projects

[Source](../../src/Projects/Project/Projects.php)

### Public methods

- [`page(int $page): static`](../../src/Projects/Project/Projects.php#L13)
- [`perPage(int $perPage): static`](../../src/Projects/Project/Projects.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Projects/Project/Projects.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Projects/Project/Projects.php#L30)
- [`ids(string ...$projectIds): Sujip\Xero\Projects\Project\Projects`](../../src/Projects/Project/Projects.php#L38)
- [`contact(string $contactId): Sujip\Xero\Projects\Project\Projects`](../../src/Projects/Project/Projects.php#L46)
- [`states(string ...$states): Sujip\Xero\Projects\Project\Projects`](../../src/Projects/Project/Projects.php#L54)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Projects/Project/Projects.php#L65)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Projects/Project/Projects.php#L81)
- [`find(string $projectId): ?\Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Projects.php#L96)
- [`create(): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Project/Projects.php#L108)
- [`update(string $projectId): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Project/Projects.php#L113)
- [`patch(string $projectId): Sujip\Xero\Projects\Project\Patch`](../../src/Projects/Project/Projects.php#L118)
- [`many(array $payload): array`](../../src/Projects/Project/Projects.php#L127)
- [`single(array $payload): ?array`](../../src/Projects/Project/Projects.php#L139)
- [`mapProject(array $project): Sujip\Xero\Projects\Project\Project`](../../src/Projects/Project/Projects.php#L154)

## Projects\Projects

[Source](../../src/Projects/Projects.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Projects/Projects.php#L24)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Projects/Projects.php#L30)
- [`page(int $page): Sujip\Xero\Projects\Projects`](../../src/Projects/Projects.php#L35)
- [`perPage(int $perPage): Sujip\Xero\Projects\Projects`](../../src/Projects/Projects.php#L43)
- [`ids(string ...$projectIds): Sujip\Xero\Projects\Projects`](../../src/Projects/Projects.php#L51)
- [`contact(string $contactId): Sujip\Xero\Projects\Projects`](../../src/Projects/Projects.php#L59)
- [`states(string ...$states): Sujip\Xero\Projects\Projects`](../../src/Projects/Projects.php#L67)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Projects/Projects.php#L78)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Projects/Projects.php#L86)
- [`find(string $projectId): ?\Sujip\Xero\Projects\Project\Project`](../../src/Projects/Projects.php#L91)
- [`create(): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Projects.php#L96)
- [`update(string $projectId): Sujip\Xero\Projects\Project\Payload`](../../src/Projects/Projects.php#L101)
- [`patch(string $projectId): Sujip\Xero\Projects\Project\Patch`](../../src/Projects/Projects.php#L106)
- [`users(): Sujip\Xero\Projects\ProjectUser\ProjectUsers`](../../src/Projects/Projects.php#L111)
- [`tasks(string $projectId): Sujip\Xero\Projects\Task\Tasks`](../../src/Projects/Projects.php#L116)
- [`timeEntries(string $projectId): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/Projects.php#L121)
- [`projects(): Sujip\Xero\Projects\Project\Projects`](../../src/Projects/Projects.php#L126)
- [`client(): Sujip\Xero\Client`](../../src/Projects/Projects.php#L131)

## Projects\Task\Payload

[Source](../../src/Projects/Task/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $projectId)`](../../src/Projects/Task/Payload.php#L20)
- [`id(string $taskId): Sujip\Xero\Projects\Task\Payload`](../../src/Projects/Task/Payload.php#L26)
- [`name(string $name): Sujip\Xero\Projects\Task\Payload`](../../src/Projects/Task/Payload.php#L34)
- [`chargeType(string $chargeType): Sujip\Xero\Projects\Task\Payload`](../../src/Projects/Task/Payload.php#L42)
- [`rate(int\|float $value, ?string $currency = NULL): Sujip\Xero\Projects\Task\Payload`](../../src/Projects/Task/Payload.php#L50)
- [`estimateMinutes(int $minutes): Sujip\Xero\Projects\Task\Payload`](../../src/Projects/Task/Payload.php#L60)
- [`idempotencyKey(string $key): Sujip\Xero\Projects\Task\Payload`](../../src/Projects/Task/Payload.php#L68)
- [`save(): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Payload.php#L76)

## Projects\Task\Task

[Source](../../src/Projects/Task/Task.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `taskId` | string or null | `()` |
| `name` | string or null | `()` |
| `rate` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `chargeType` | string or null | `()` |
| `estimateMinutes` | int, float, or null | `()` |
| `projectId` | string or null | `()` |
| `totalMinutes` | int, float, or null | `()` |
| `totalAmount` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `minutesInvoiced` | int, float, or null | `()` |
| `minutesToBeInvoiced` | int, float, or null | `()` |
| `fixedMinutes` | int, float, or null | `()` |
| `nonChargeableMinutes` | int, float, or null | `()` |
| `amountToBeInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `amountInvoiced` | object or null ([Projects\Project\Amount](projects.md#projectsprojectamount)) | `()` |
| `status` | string or null | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Projects/Task/Task.php#L45)
- [`getTaskId(): ?string`](../../src/Projects/Task/Task.php#L50)
- [`setTaskId(?string $taskId): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L55)
- [`getName(): ?string`](../../src/Projects/Task/Task.php#L62)
- [`setName(?string $name): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L67)
- [`getRate(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Task/Task.php#L74)
- [`setRate(?\Sujip\Xero\Projects\Project\Amount $rate): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L79)
- [`getChargeType(): ?string`](../../src/Projects/Task/Task.php#L86)
- [`setChargeType(?string $chargeType): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L91)
- [`getEstimateMinutes(): ?int`](../../src/Projects/Task/Task.php#L98)
- [`setEstimateMinutes(?int $estimateMinutes): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L103)
- [`getProjectId(): ?string`](../../src/Projects/Task/Task.php#L110)
- [`setProjectId(?string $projectId): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L115)
- [`getTotalMinutes(): ?int`](../../src/Projects/Task/Task.php#L122)
- [`setTotalMinutes(?int $totalMinutes): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L127)
- [`getTotalAmount(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Task/Task.php#L134)
- [`setTotalAmount(?\Sujip\Xero\Projects\Project\Amount $totalAmount): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L139)
- [`getMinutesInvoiced(): ?int`](../../src/Projects/Task/Task.php#L146)
- [`setMinutesInvoiced(?int $minutesInvoiced): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L151)
- [`getMinutesToBeInvoiced(): ?int`](../../src/Projects/Task/Task.php#L158)
- [`setMinutesToBeInvoiced(?int $minutesToBeInvoiced): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L163)
- [`getFixedMinutes(): ?int`](../../src/Projects/Task/Task.php#L170)
- [`setFixedMinutes(?int $fixedMinutes): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L175)
- [`getNonChargeableMinutes(): ?int`](../../src/Projects/Task/Task.php#L182)
- [`setNonChargeableMinutes(?int $nonChargeableMinutes): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L187)
- [`getAmountToBeInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Task/Task.php#L194)
- [`setAmountToBeInvoiced(?\Sujip\Xero\Projects\Project\Amount $amountToBeInvoiced): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L199)
- [`getAmountInvoiced(): ?\Sujip\Xero\Projects\Project\Amount`](../../src/Projects/Task/Task.php#L206)
- [`setAmountInvoiced(?\Sujip\Xero\Projects\Project\Amount $amountInvoiced): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L211)
- [`getStatus(): ?string`](../../src/Projects/Task/Task.php#L218)
- [`setStatus(?string $status): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L223)
- [`name(string $name): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L254)
- [`rate(int\|float $value, ?string $currency = NULL): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L259)
- [`save(): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Task.php#L264)
- [`delete(): void`](../../src/Projects/Task/Task.php#L295)

## Projects\Task\Tasks

[Source](../../src/Projects/Task/Tasks.php)

### Public methods

- [`page(int $page): static`](../../src/Projects/Task/Tasks.php#L13)
- [`perPage(int $perPage): static`](../../src/Projects/Task/Tasks.php#L21)
- [`__construct(\Sujip\Xero\Client $client, string $projectId)`](../../src/Projects/Task/Tasks.php#L25)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Projects/Task/Tasks.php#L31)
- [`ids(string ...$taskIds): Sujip\Xero\Projects\Task\Tasks`](../../src/Projects/Task/Tasks.php#L39)
- [`chargeType(string $chargeType): Sujip\Xero\Projects\Task\Tasks`](../../src/Projects/Task/Tasks.php#L47)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Projects/Task/Tasks.php#L58)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Projects/Task/Tasks.php#L74)
- [`find(string $taskId): ?\Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Tasks.php#L89)
- [`create(): Sujip\Xero\Projects\Task\Payload`](../../src/Projects/Task/Tasks.php#L101)
- [`update(string $taskId): Sujip\Xero\Projects\Task\Payload`](../../src/Projects/Task/Tasks.php#L106)
- [`delete(string $taskId): void`](../../src/Projects/Task/Tasks.php#L111)
- [`many(array $payload): array`](../../src/Projects/Task/Tasks.php#L122)
- [`single(array $payload): ?array`](../../src/Projects/Task/Tasks.php#L134)
- [`mapTask(array $task): Sujip\Xero\Projects\Task\Task`](../../src/Projects/Task/Tasks.php#L149)

## Projects\TimeEntry\Payload

[Source](../../src/Projects/TimeEntry/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $projectId)`](../../src/Projects/TimeEntry/Payload.php#L21)
- [`id(string $timeEntryId): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/Payload.php#L27)
- [`task(string $taskId): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/Payload.php#L35)
- [`user(string $userId): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/Payload.php#L43)
- [`date(\DateTimeInterface\|string $dateUtc): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/Payload.php#L51)
- [`durationMinutes(int $minutes): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/Payload.php#L61)
- [`description(string $description): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/Payload.php#L69)
- [`idempotencyKey(string $key): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/Payload.php#L77)
- [`save(): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/Payload.php#L85)

## Projects\TimeEntry\TimeEntries

[Source](../../src/Projects/TimeEntry/TimeEntries.php)

### Public methods

- [`page(int $page): static`](../../src/Projects/TimeEntry/TimeEntries.php#L13)
- [`perPage(int $perPage): static`](../../src/Projects/TimeEntry/TimeEntries.php#L21)
- [`__construct(\Sujip\Xero\Client $client, string $projectId)`](../../src/Projects/TimeEntry/TimeEntries.php#L26)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Projects/TimeEntry/TimeEntries.php#L32)
- [`user(string $userId): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/TimeEntry/TimeEntries.php#L40)
- [`task(string $taskId): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/TimeEntry/TimeEntries.php#L48)
- [`invoice(string $invoiceId): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/TimeEntry/TimeEntries.php#L56)
- [`contact(string $contactId): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/TimeEntry/TimeEntries.php#L64)
- [`states(string ...$states): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/TimeEntry/TimeEntries.php#L72)
- [`isChargeable(bool $chargeable = true): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/TimeEntry/TimeEntries.php#L80)
- [`dateAfterUtc(\DateTimeInterface\|string $date): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/TimeEntry/TimeEntries.php#L88)
- [`dateBeforeUtc(\DateTimeInterface\|string $date): Sujip\Xero\Projects\TimeEntry\TimeEntries`](../../src/Projects/TimeEntry/TimeEntries.php#L96)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Projects/TimeEntry/TimeEntries.php#L107)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Projects/TimeEntry/TimeEntries.php#L123)
- [`find(string $timeEntryId): ?\Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntries.php#L138)
- [`create(): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/TimeEntries.php#L150)
- [`update(string $timeEntryId): Sujip\Xero\Projects\TimeEntry\Payload`](../../src/Projects/TimeEntry/TimeEntries.php#L155)
- [`delete(string $timeEntryId): void`](../../src/Projects/TimeEntry/TimeEntries.php#L160)
- [`many(array $payload): array`](../../src/Projects/TimeEntry/TimeEntries.php#L171)
- [`single(array $payload): ?array`](../../src/Projects/TimeEntry/TimeEntries.php#L180)
- [`mapTimeEntry(array $timeEntry): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntries.php#L192)

## Projects\TimeEntry\TimeEntry

[Source](../../src/Projects/TimeEntry/TimeEntry.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `timeEntryId` | string or null | `()` |
| `userId` | string or null | `()` |
| `projectId` | string or null | `()` |
| `taskId` | string or null | `()` |
| `dateUtc` | string or null | `()` |
| `dateEnteredUtc` | string or null | `()` |
| `duration` | int, float, or null | `()` |
| `description` | string or null | `()` |
| `status` | string or null | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Projects/TimeEntry/TimeEntry.php#L32)
- [`getTimeEntryId(): ?string`](../../src/Projects/TimeEntry/TimeEntry.php#L37)
- [`setTimeEntryId(?string $timeEntryId): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L42)
- [`getUserId(): ?string`](../../src/Projects/TimeEntry/TimeEntry.php#L49)
- [`setUserId(?string $userId): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L54)
- [`getProjectId(): ?string`](../../src/Projects/TimeEntry/TimeEntry.php#L61)
- [`setProjectId(?string $projectId): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L66)
- [`getTaskId(): ?string`](../../src/Projects/TimeEntry/TimeEntry.php#L73)
- [`setTaskId(?string $taskId): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L78)
- [`getDateUtc(): ?string`](../../src/Projects/TimeEntry/TimeEntry.php#L85)
- [`setDateUtc(?string $dateUtc): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L90)
- [`getDateEnteredUtc(): ?string`](../../src/Projects/TimeEntry/TimeEntry.php#L97)
- [`setDateEnteredUtc(?string $dateEnteredUtc): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L102)
- [`getDuration(): int\|float\|null`](../../src/Projects/TimeEntry/TimeEntry.php#L109)
- [`setDuration(int\|float\|null $duration): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L114)
- [`getDescription(): ?string`](../../src/Projects/TimeEntry/TimeEntry.php#L121)
- [`setDescription(?string $description): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L126)
- [`getStatus(): ?string`](../../src/Projects/TimeEntry/TimeEntry.php#L133)
- [`setStatus(?string $status): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L138)
- [`durationMinutes(int $minutes): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L163)
- [`save(): Sujip\Xero\Projects\TimeEntry\TimeEntry`](../../src/Projects/TimeEntry/TimeEntry.php#L168)
- [`delete(): void`](../../src/Projects/TimeEntry/TimeEntry.php#L203)
