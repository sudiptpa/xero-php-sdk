# Upgrade Guide

## Upgrading To The Next Release (Wire-Contract Fixes)

This release fixes a set of endpoints, request bodies, and response shapes
that did not match the official Xero OpenAPI specs. Most of the affected
calls previously 404'd, returned no data, or sent a payload Xero ignores, so
these are bug fixes — but the corrected method signatures and serialized
payloads are breaking changes for any code relying on the old (incorrect)
behaviour.

### AppStore

- All `appStore()->subscriptions()` calls now target
  `https://api.xero.com/appstore/2.0/...`. Previously every call went to
  `https://api.xero.com/subscriptions/...` and returned 404 — no behavioural
  migration needed beyond the calls now working.

### Finance

- `finance()->bankStatementAccounting()` now calls
  `/finance.xro/1.0/BankStatementsPlus/statements`. The query parameters are
  now `BankAccountID`, `FromDate`, `ToDate` (required) and `SummaryOnly`
  (optional) — `balanceDate`/`asAtSystemDate` are no longer accepted. The
  response is read from the `statements` key.

### Payroll NZ and Payroll UK — Timesheets

- `Timesheets::revert($id)` now calls `RevertToDraft` (was `Revert`, which
  404'd).
- `Timesheets::update()` has been **removed** — there is no update endpoint.
  Manage timesheet contents via the `Lines` sub-resource instead.
- UK `Timesheets` gained `delete($id)` for `DELETE /Timesheets/{id}`.
- Request bodies are now bare camelCase objects (previously wrapped in a
  PascalCase `Timesheet` key). Responses unwrap from `timesheets`/`timesheet`.
- Model fields are now camelCase: `timesheetID`, `payrollCalendarID`,
  `employeeID`, `startDate`, `endDate`, `status`, plus new `totalHours` and
  `updatedDateUTC`. The `status` filter/enum values keep their Xero
  PascalCase casing (e.g. `Draft`, `Approved`).

### Payroll NZ and Payroll UK — Employees

- `Employees::update($id)` now sends `PUT` (was `POST`).
- Request and response bodies are bare camelCase objects (previously
  wrapped in a PascalCase `Employee` key).
- `email` replaces `EmailAddress` on the `Employee` model.
- The `Status` field has been removed — it does not exist on the NZ/UK
  `Employee` schema.
- `Employee::employment()` / `Employees::employment($id)` have been
  **removed** — the API only supports `POST .../Employment` (create), there
  is no `GET`. `createEmployment()` is unaffected.

### Payroll UK — Employees (additional)

- `Employees::paymentMethod($id)` now calls `/Employees/{id}/PaymentMethods`
  (plural) and reads the `paymentMethod` wrapper.
- `Employees::leaveTypes($id)` now returns `EmployeeLeaveType` models
  (`leaveTypeID`, `scheduleOfAccrual`, `hoursAccruedAnnually`,
  `maximumToAccrue`, `openingBalance`, `rateAccruedHourly`,
  `scheduleOfAccrualDate`) instead of the old `LeaveType` model, which
  exposed `name`/`isActive` fields that do not exist on this endpoint.
  `LeaveTypePayload` now sends a bare camelCase body.

### Payroll NZ — LeaveTypes

- `LeaveTypes::get()`/`find()` unwrap from camelCase `leaveTypes`/`leaveType`
  and now expose the full schema: `isPaidLeave`, `showOnPayslip`,
  `updatedDateUTC`, `isActive`, `typeOfUnits`, `typeOfUnitsToAccrue`. The
  `ActiveOnly` query parameter keeps its spec PascalCase casing.
- `Employees::leaveTypes($id)` now returns `EmployeeLeaveType` models (same
  shape as the UK equivalent above) instead of `LeaveType`.

### Payroll NZ and Payroll UK — PayRuns

- Request bodies are bare camelCase objects (previously wrapped in a
  PascalCase `PayRun` key). Responses unwrap from `payRuns`/`payRun`.
- Model fields are camelCase and the full schema is now exposed:
  `periodStartDate`, `periodEndDate`, `totalCost`, `totalPay`, `payRunType`,
  `calendarType`, `postedDateTime`. The phantom `Status` alias and PascalCase
  fallbacks have been removed.
- `Payload` gained `paymentDate()` so `create()` can send the required
  payment date.
- The `status` filter/enum keeps its Xero PascalCase casing (was previously
  upper-cased by the SDK).

### Payroll NZ and Payroll UK — PayRunCalendars

- Responses unwrap from camelCase `payRunCalendars`/`payRunCalendar` (was a
  mix of `PayrollCalendars`/`PayRunCalendars` fallbacks).
- Model fields are camelCase and the full schema is now exposed:
  `periodEndDate`, `paymentDate`, `updatedDateUTC` were previously missing.

### Payroll NZ — Settings and StatutoryDeductions

- `Settings::get()` unwraps from the camelCase `settings` key; its
  `accounts` array is read correctly (was reading a PascalCase
  `Settings/Accounts` shape that does not exist).
- `trackingCategories()` is now its own call to
  `GET /Settings/TrackingCategories` returning the `trackingCategories`
  object — it is no longer read from the `/Settings` payload (where it does
  not exist).
- `StatutoryDeduction` is modelled against the real schema: the identifier
  is `id` (was the non-existent `statutoryDeductionID`), plus
  `statutoryDeductionCategory`, `liabilityAccountId`, `currentRecord`.
  Responses unwrap from `statutoryDeductions`/`statutoryDeduction`.

### Payroll UK — Settings, Reimbursements and Statutory Leave

- `trackingCategories()` now returns a single `trackingCategories` object
  (`employeeGroupsTrackingCategoryID`, `timesheetTrackingCategoryID`) from
  `GET /Settings/trackingCategories`. The old `TrackingCategory` model
  (which invented `trackingCategoryID`/`name`) has been removed.
- `Reimbursement` unwraps from `reimbursements`/`reimbursement` and exposes
  `accountID`/`currentRecord` (the non-existent `accountCode` field has been
  removed). `ReimbursementPayload::create()` sends a bare camelCase body
  with `name`/`accountID`.
- `statutoryLeaveSummary($id)` now returns a **collection** of
  `EmployeeStatutoryLeaveSummary` (`statutoryLeaveID`, `employeeID`, `type`,
  `startDate`, `endDate`, `isEntitled`, `status`) from
  `GET /StatutoryLeaves/Summary/{id}` — it previously returned a single
  object reading a non-existent `units` field from a PascalCase
  `StatutoryLeaveSummary` key.

### Payroll UK — Payslips

- `Payslips` unwrap from camelCase `paySlips`/`paySlip`. The model is
  corrected to the real schema: `paySlipID`, `employeeID`, `payRunID`,
  `lastEdited`, `firstName`, `lastName`, and the `total*` money fields. The
  previous model's `NetPay` and `PaymentDate` fields did not exist on this
  endpoint and have been removed.

### Payroll AU — PayrollCalendars

- `PayrollCalendars::update()` and the `Payload` PUT-by-id branch have been
  **removed**. AU `/PayrollCalendars/{id}` only supports `GET`; the
  collection only supports `GET` (list) and `POST` (create).

### Payroll AU — Payslips

- `PayRun::payslips()` no longer makes an HTTP call. It now returns the
  `PayslipSummary[]` embedded directly in the pay run response (fields:
  `employeeID`, `payslipID`, `firstName`, `lastName`, `lastEdited`, `wages`,
  `deductions`, `tax`, `super`, `reimbursements`, `netPay`,
  `updatedDateUTC`).
- New `PayRuns::payslip($payslipId)` calls `GET /Payslip/{id}` and returns
  the full `Payslip` model with all line-item collections
  (`earningsLines`, `leaveEarningsLines`, `timesheetEarningsLines`,
  `deductionLines`, `leaveAccrualLines`, `reimbursementLines`,
  `superannuationLines`, `taxLines`).
- The old `PayRuns::payslips($payRunId)` collection (which called the
  non-existent `/PayRuns/{id}/Payslips(/{id})` endpoints) has been
  **removed**.
- `Employee::leaveBalances()` and `Employees::leaveBalances($id)` have been
  **removed** — `/Employees/{id}/LeaveBalances` does not exist; leave
  balances are embedded on the `Employee` resource itself.

### Accounting — Create Verbs

- `BankTransfers`, `Currencies`, `ExpenseClaims` (create only),
  `LinkedTransactions`, `PaymentServices`, and
  `ContactGroups::contacts($id)->save()` (assigning contacts to a group) now
  send `PUT` to the collection endpoint instead of `POST`. `ExpenseClaims`
  update remains `POST /ExpenseClaims/{id}`.

## Upgrading To 2.0

Version `2.0` keeps the fluent SDK style, but includes a few intentional breaking changes.

## Type Renames

Update these imports and type references:

- `Sujip\Xero\Support\Contracts\SerializesForRequest`
  - is now `Sujip\Xero\Support\Contracts\SerializesRequest`
- `Sujip\Xero\Support\PaginatedResult`
  - is now `Sujip\Xero\Support\PaginatedCollection`

## Projects Payload Changes

Projects request payloads now follow the official Xero Projects schema more closely.

### Project Create/Update

Projects now use documented request keys such as:

- `name`
- `contactId`
- `estimateAmount`
- `deadlineUtc`

This means project write helpers now align with the official schema instead of the older package-side payload shape.

### Task Create/Update

Tasks now use documented request keys such as:

- `name`
- `chargeType`
- `estimateMinutes`
- `rate`

`rate` is now serialized as the documented amount-object shape.

### Time Entry Create/Update

Time entries now use documented request keys such as:

- `taskId`
- `userId`
- `dateUtc`
- `duration`
- `description`

## What Does Not Intend To Change

The normal fluent SDK usage is intended to remain stable.

Examples:

- `$xero->accounting()->contacts()->get()`
- `$xero->accounting()->invoices()->create()->using(...)->save()`
- `$xero->projects()->tasks('project-id')->create()->name(...)->save()`

Most applications should only need to update:

- direct imports of the renamed support types
- any code that depended on the old serialized Projects payload arrays

## Official Source

Projects payload decisions in this release follow the official Xero OpenAPI source:

- `https://github.com/XeroAPI/Xero-OpenAPI/blob/master/xero-projects.yaml`
