# Changelog

All notable changes to this package are documented here.

## Unreleased

### Added

New endpoints and resources. These are additive and do not change existing method signatures.

- `Accounting`:
  - `Budgets`: `budgets()` with `get()`, `find()`, and `dateFrom`/`dateTo` filters, under `accounting.budgets.read`
  - `Invoices`: `email()` to send an invoice to the contact; `onlineInvoiceUrl()` for the shareable link — both on the `Invoices` resource and a bound `Invoice`
  - `Allocations` on credit notes, overpayments, and prepayments (create with `PUT`, remove with `DELETE`)
  - `attachments()` on accounts, bank transactions, bank transfers, contacts, quotes, and repeating invoices (list, download by file name or attachment id, create, update)
  - `history()` on contacts, bank transfers, expense claims, quotes, overpayments, prepayments, and repeating invoices
  - `LinkedTransactions`: `find()`, `update()`, and `delete()` by id
  - `TrackingCategories`: add, rename, and delete options
  - `Users::find()` by id, `Organisations::actions()`, and contact and organisation CIS settings reads
  - `BrandingThemes`: list and add payment services
  - `Accounting::setup()` to post the conversion date and opening balances
- `Payroll AU`:
  - `LeaveApplications::v2()`, which also returns pending leave requests
- `Payroll NZ`:
  - `Deductions`, `EarningsRates`, and `Superannuations` pay items (list, find, create)
  - `PaySlips`: list by pay run, find by id, and update line items
- `Payroll UK`:
  - `Deductions`, `EarningsRates`, `Benefits`, and `EarningsOrders` pay items (`EarningsOrders` is read-only)
  - employee opening balances: `openingBalances()`, `createOpeningBalances()`, `updateOpeningBalances()`
  - statutory sick leave: `statutoryLeaves()->findSick()` and `createSick()`
- `Payroll NZ` and `Payroll UK`:
  - timesheet lines: create, update, and delete a line on a timesheet
  - employee pay template earnings: list, create, update, delete, and bulk create

### Added (infrastructure)

- CI audit workflow (`.github/workflows/audit.yml`): downloads the latest Xero OpenAPI specs from `XeroAPI/Xero-OpenAPI` on every push and PR, runs `.github/scripts/audit.py` (endpoint coverage) and `.github/scripts/schema_audit.py` (model field audit), and fails the build on any finding — zero tolerance

### Fixed

These are bug fixes against the official Xero OpenAPI specs. The affected calls previously 404'd, returned empty data, or sent a payload Xero ignores. They change method signatures and serialized payloads, so they are breaking. See `UPGRADE.md` for the full list of affected methods.

- `AppStore`: every call now goes to `https://api.xero.com/appstore/2.0/...` (was `https://api.xero.com/subscriptions/...`, a 404 for every request)
- `AppStore`: `Subscription` model rewritten to spec fields (`id`, `organisationId`, `status`, `startDate`, `currentPeriodEnd`, `endDate`, `testMode`, `plans`); removed guessed `SubscriptionID`/`PlanID`/`items` fields
- `AppStore`: `UsageRecord` model rewritten to spec fields (`usageRecordId`, `subscriptionId`, `quantity`, `recordedAt`, etc.); `UsageRecordPayload` now sends `quantity` and `timestamp` (was `quantity`, `startDate`, `endDate`)
- `Files`: `File` model fields corrected to spec casing (`CreatedDateUtc`/`UpdatedDateUtc`); `User` model added; upload changed to `multipart/form-data` (was a raw body that Xero rejected with 415); `Associations` response shapes fixed from guessed `Items`-wrapper to bare array
- `Assets`: `Asset` model rewritten to spec camelCase fields; `AssetType` and `Settings` models rewritten to spec fields; list responses now read `items` (was `Items`)
- `Projects`: `Project` model rewritten to spec camelCase fields; `Task` and `TimeEntry` models rewritten; `ProjectUser` model rewritten to spec fields (`userId`, `name`, `email`)
- `Finance`: removed `AccountingActivities` module — Xero removed this API from the OpenAPI spec in February 2026; `BankStatementAccounting` response shape fixed; `FinancialStatements` models (`BalanceSheet`, `ProfitAndLoss`, `Cashflow`, `TrialBalance`, `IncomeByContact`) rewritten to spec fields
- `Finance`: `bankStatementAccounting()` now calls `/finance.xro/1.0/BankStatementsPlus/statements` with the documented `BankAccountID`/`FromDate`/`ToDate`/`SummaryOnly` parameters
- `Payroll NZ` and `Payroll UK`:
  - `Timesheets`: revert now calls `RevertToDraft` (was `Revert`, a 404); removed the phantom `update()`; UK gained `delete()`
  - `Employees`: update is now `PUT` (was `POST`); request/response bodies are bare camelCase; `email` replaces `EmailAddress`; removed the non-existent `Status` field
  - `Employees`: removed the phantom `employment()` reader (the API only supports `POST .../Employment` to create, no `GET`)
  - `PayRuns`: request/response bodies are bare camelCase; full schema exposed; added `paymentDate()` builder for create
  - `PayRunCalendars`: response unwraps from camelCase `payRunCalendars`/`payRunCalendar`; full schema exposed
- `Payroll UK`:
  - `Employees`: payment methods endpoint is `/PaymentMethods` (plural, was singular)
  - `Employees`: leave types now return `EmployeeLeaveType` (was incorrectly mapped to `LeaveType`)
  - `Settings`: `trackingCategories()` returns the single `trackingCategories` object; `Reimbursement` corrected to `accountID`/`currentRecord`; `statutoryLeaveSummary()` returns a collection of `EmployeeStatutoryLeaveSummary`
  - `Payslips`: unwrap from `paySlips`/`paySlip`; corrected to the real schema; payslip access hits the real `GET /Payslips?PayRunID=` and `GET /Payslips/{id}` endpoints
- `Payroll NZ`:
  - `LeaveTypes`: unwraps from camelCase `leaveTypes`/`leaveType` with the full schema; employee leave types now return `EmployeeLeaveType`
  - `Settings`: `GET /Settings` unwraps from camelCase `settings`; `trackingCategories()` moved to its own call; `StatutoryDeduction` corrected to real schema
- `Payroll AU`:
  - removed the phantom `PayrollCalendars::update()` (only `GET`/`POST` exist)
  - `PayRun::payslips()` now returns embedded `PayslipSummary[]` from the pay run response; added `PayRuns::payslip($id)` for the full `Payslip`; removed phantom `Payslips` collection
  - `Employee::leaveBalances()` and `Employees::leaveBalances($id)` removed — the endpoint does not exist; leave balances are on the `Employee` resource itself
- `Accounting`: `BankTransfers`, `Currencies`, `ExpenseClaims` (create), `LinkedTransactions`, `PaymentServices`, and `ContactGroups/{id}/Contacts` now send `PUT` (was `POST`, which Xero rejects for these resources)
- Many Accounting, Payroll, and other models gained missing spec fields (`ValidationErrors`, `StatusAttributeString`, `UpdatedDateUTC`, nested sub-models) across 46 models
- `Accounting/Allocation`: removed the `AllocationId` alias — only `AllocationID` is in the spec
- `Payroll AU/Payslip` and `PayslipSummary`: removed `LastEdited` — not in the AU payroll spec

## 1.0.0 — 2026-03-31

First public release.

### Added

- Fluent, framework-agnostic SDK for PHP 8.2 to 8.5, no runtime dependencies
- Typed models across all major Xero API families
- OAuth2 authorization URL, token exchange, token refresh, PKCE, custom connections, tenant discovery, disconnect, and webhook verification
- `Accounting`: contacts, invoices, payments, accounts, items, tax rates, tracking categories, currencies, branding themes, organisations, users, credit notes, bank transactions, bank transfers, linked transactions, overpayments, prepayments, batch payments, manual journals, contact groups, expense claims, journals, purchase orders, quotes, receipts, repeating invoices, payment services, reports, attachments, history helpers, PDFs, and invoice reminders
- `Files`: uploads, folders, inbox, associations, object-side lookup, counts, content reads, metadata updates, and deletes
- `Assets`: assets, asset types, settings, and collection search parameters
- `Projects`: projects, users, tasks, time entries, and lifecycle patch helpers
- `Payroll AU`: employees, leave balances, leave applications, pay items, pay runs, payslips, timesheets, payroll calendars, settings, super funds, and super fund products
- `Payroll NZ`: employees, employment, leave, payment method, salary and wages, leave setup, opening balances, leave types, pay run calendars, pay runs, timesheets, settings, and statutory deductions
- `Payroll UK`: employees, leave balances, leave types, leave records, employment, payment methods, pay run calendars, pay runs, payslips, timesheets, settings helpers, and reimbursements
- `Finance`: bank statement accounting, cash validation, and financial statements (balance sheet, cashflow, profit and loss, trial balance, contact revenue, contact expenses)
- `App Store`: subscriptions and usage records
- CI across PHP 8.2, 8.3, 8.4, and 8.5; PHPStan max; 100% test coverage

### Notes

- Granular scopes are covered in code and docs
- Apps created on or after 2026-03-02 should use granular scopes
- All apps must migrate off broad scopes by September 2027
- `Accounting > Employees` is deprecated by Xero — use the Payroll API for employee management
