# Changelog

All notable changes to this package should be documented here.

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
