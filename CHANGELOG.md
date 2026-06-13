# Changelog

All notable changes to this package should be documented here.

## Unreleased

### Added

New endpoints and resources that fill gaps against the Xero API. These are
additive and do not change the signatures of existing methods.

- `Accounting`:
  - `Budgets`: `budgets()` with `get()`, `find()`, and `dateFrom`/`dateTo`
    filters, under the `accounting.budgets.read` scope
  - `Invoices`: `email()` to send an invoice to the contact and
    `onlineInvoiceUrl()` for the shareable link, on both the `Invoices`
    resource and a bound `Invoice`
  - `Allocations` on credit notes, overpayments, and prepayments (create
    with `PUT`, remove with `DELETE`)
  - `attachments()` on accounts, bank transactions, bank transfers,
    contacts, quotes, and repeating invoices (list, download by file name
    or attachment id, create, update)
  - `history()` on contacts, bank transfers, expense claims, quotes,
    overpayments, prepayments, and repeating invoices
  - `LinkedTransactions`: `find()`, `update()`, and `delete()` by id
  - `TrackingCategories`: add, rename, and delete options
  - `Users::find()` by id, `Organisations::actions()`, and the contact and
    organisation CIS settings reads
  - `BrandingThemes`: list and add payment services
  - `Accounting::setup()` to post the conversion date and opening balances
- `Payroll AU`:
  - `LeaveApplications::v2()`, which also returns pending leave requests
- `Payroll NZ`:
  - `Deductions`, `EarningsRates`, and `Superannuations` pay items (list,
    find, create)
  - `PaySlips`: list by pay run, find by id, and update line items
- `Payroll UK`:
  - `Deductions`, `EarningsRates`, `Benefits`, and `EarningsOrders` pay
    items (`EarningsOrders` is read only)
  - employee opening balances: `openingBalances()`,
    `createOpeningBalances()`, `updateOpeningBalances()`
  - statutory sick leave: `statutoryLeaves()->findSick()` and `createSick()`
- `Payroll NZ` and `Payroll UK`:
  - timesheet lines: create, update, and delete a line on a timesheet
  - employee pay template earnings: list, create, update, delete, and bulk
    create

### Fixed (breaking wire-contract corrections, see UPGRADE.md)

An audit against the official Xero OpenAPI specs found that a number of
endpoints, request bodies, and response shapes did not match the documented
contracts. These are bug fixes (the affected calls would 404, return empty
data, or send a payload Xero ignores), but they change method signatures and
serialized payloads, so they are listed as breaking. See `UPGRADE.md` for the
full list of affected methods.

- `AppStore`: every call now goes to `https://api.xero.com/appstore/2.0/...`
  (was `https://api.xero.com/subscriptions/...`, a 404 for every request)
- `Finance`: `bankStatementAccounting()` now calls
  `/finance.xro/1.0/BankStatementsPlus/statements` with the documented
  `BankAccountID`/`FromDate`/`ToDate`/`SummaryOnly` parameters
- `Payroll NZ` and `Payroll UK`:
  - `Timesheets`: revert now calls `RevertToDraft` (was `Revert`, a 404);
    removed the phantom `update()` (no such endpoint); UK gained `delete()`
  - `Employees`: update is now `PUT` (was `POST`), request/response bodies
    are bare camelCase, `email` replaces `EmailAddress`, removed the
    non-existent `Status` field
  - `Employees`: removed the phantom `employment()` reader (the API only
    supports `POST .../Employment` to create, no `GET`)
  - `PayRuns`: request/response bodies are bare camelCase, full schema
    exposed (`periodStartDate`, `periodEndDate`, `totalCost`, `totalPay`,
    `payRunType`, `calendarType`, `postedDateTime`), added `paymentDate()`
    builder for create
  - `PayRunCalendars`: response unwraps from camelCase
    `payRunCalendars`/`payRunCalendar`, full schema exposed
    (`periodEndDate`, `paymentDate`, `updatedDateUTC`)
- `Payroll UK`:
  - `Employees`: payment methods endpoint is `/PaymentMethods` (plural, was
    singular)
  - `Employees`: leave types now return `EmployeeLeaveType` (was
    incorrectly mapped to a generic `LeaveType`)
  - `Settings`: `trackingCategories()` now returns the single
    `trackingCategories` object (was modelled as a list with invented
    fields); `Reimbursement` corrected to `accountID`/`currentRecord`;
    `statutoryLeaveSummary()` now returns a collection of
    `EmployeeStatutoryLeaveSummary`
  - `Payslips`: unwrap from `paySlips`/`paySlip`, corrected to the real
    schema (`paySlipID`, `employeeID`, `payRunID`, `lastEdited`,
    `firstName`, `lastName`, total* money fields); payslip access now hits
    the real `GET /Payslips?PayRunID=` and `GET /Payslips/{id}` endpoints
    (the `/PayRuns/{id}/Payslips` path does not exist), with no change to
    the public API
- `Payroll NZ`:
  - `LeaveTypes`: standalone resource unwraps from camelCase
    `leaveTypes`/`leaveType` with the full schema; employee leave types now
    return a dedicated `EmployeeLeaveType`
  - `Settings`: `GET /Settings` unwraps from camelCase `settings`;
    `trackingCategories()` moved to its own
    `GET /Settings/TrackingCategories` call; `StatutoryDeduction` corrected
    to `id`/`statutoryDeductionCategory`/`liabilityAccountId`/`currentRecord`
- `Payroll AU`:
  - removed the phantom `PayrollCalendars` `update()` (only `GET`/`POST`
    exist)
  - `PayRun.payslips()` now returns embedded `PayslipSummary[]` from the
    pay run response; added `PayRuns.payslip($id)` for the full `Payslip`
    via `GET /Payslip/{id}`; removed the phantom `Payslips` collection and
    `Employee.leaveBalances()`/`Employees.leaveBalances()` (404 endpoint)
- `Accounting`: `BankTransfers`, `Currencies`, `ExpenseClaims` (create),
  `LinkedTransactions`, `PaymentServices`, and `ContactGroups/{id}/Contacts`
  are now created with `PUT` (was `POST`, which Xero rejects/ignores for
  these resources); `ExpenseClaims` update remains `POST /{id}`

## 1.0.0 - 2026-03-31

### Release Highlights

- first public release of `Xero PHP SDK`
- fluent, framework-agnostic SDK for PHP `8.2` to `8.5`
- rich model public API across the main Xero families
- official-docs-aligned coverage across Accounting, Files, Assets, Projects, Payroll AU, Payroll NZ, Payroll UK, Finance, App Store, Auth / Identity, and Webhooks
- built-in native transport with custom transport support
- full PHPUnit and PHPStan coverage

### Included

- fluent SDK foundation under `Sujip\\Xero`
- OAuth2 authorization URL, token exchange, token refresh, PKCE, custom connections, tenant discovery, disconnect flows, and webhook verification
- broad `Accounting` coverage including contacts, invoices, payments, accounts, items, tax rates, tracking categories, currencies, branding themes, organisations, users, credit notes, bank transactions, bank transfers, linked transactions, overpayments, prepayments, batch payments, manual journals, contact groups, expense claims, journals, purchase orders, quotes, receipts, repeating invoices, payment services, reports, attachments, history helpers, PDFs, and invoice reminders
- `Files` coverage including uploads, folders, inbox, associations, object-side lookup, counts, content reads, metadata updates, and deletes
- `Assets` coverage including assets, asset types, settings, and collection search parameters
- `Projects` coverage including projects, users, tasks, time entries, and project patch/update flows
- `Payroll AU` coverage including employees, leave balances, leave applications, pay items, pay runs, payslips, timesheets, payroll calendars, settings, super funds, and super fund products
- `Payroll NZ` coverage including employees, employment, leave, payment method, salary and wages, leave setup, opening balances, leave types, pay run calendars, pay runs, timesheets, settings, and statutory deductions
- `Payroll UK` coverage including employees, leave balances, leave types, leave records, employment, payment methods, pay run calendars, pay runs, payslips, timesheets, settings helpers, and reimbursements
- `Finance` coverage including accounting activities, account usage, lock history, report history, user activities, bank statement accounting, cash validation, and financial statements
- `App Store` coverage including subscriptions and usage records
- package docs covering auth, accounting, files, assets, projects, payroll, finance, app store, webhooks, architecture, status, and release guidance

### Package Design

- public API moved to a richer model-first style instead of array-driven payload handling
- visible model-layer raw access was removed from the main package areas
- default client transport now uses the built-in native transport instead of the fake transport
- `FakeTransport` remains available as the explicit testing path
- `ConnectedAccount` now exposes `tenant()` as the fluent tenant-scoped accessor, while keeping `getClient()` as the explicit alias
- token handling now tracks both access token expiry and refresh token expiry
- package extension handling is capability-based:
  - `ext-json` and `ext-curl` are no longer hard Composer requirements
  - runtime exceptions explain when `json` or native curl transport support is required
- docs were tightened around usage, examples, transport setup, and scope guidance
- CI now enforces the supported PHP window across `8.2`, `8.3`, `8.4`, and `8.5`

### Release Notes

- granular scopes are covered in both code and docs
- apps created on or after `2026-03-02` should use granular scopes
- existing apps have until `September 2027` to move off broad scopes
- `Finance > Accounting Activities` is still supported for compatibility, but Xero has scheduled it for decommissioning on `2026-04-06`
- `Accounting > Employees` remains documented in the package with a deprecation note because Xero has scheduled it for removal on `2026-04-28`
