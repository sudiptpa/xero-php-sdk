# Package status

Review date: 27 March 2026

## Source set

This status is based on the official Xero overview pages:

- [Getting Started Guide](https://developer.xero.com/documentation/getting-started-guide/)
- [Accounting API Overview](https://developer.xero.com/documentation/api/accounting/overview)
- [Files API Overview](https://developer.xero.com/documentation/api/files/overview)
- [Assets API Overview](https://developer.xero.com/documentation/api/assets/overview)
- [Projects API Overview](https://developer.xero.com/documentation/api/projects/overview)
- [Payroll AU API Overview](https://developer.xero.com/documentation/api/payrollau/overview)
- [Payroll NZ API Overview](https://developer.xero.com/documentation/api/payrollnz/overview)
- [Payroll UK API Overview](https://developer.xero.com/documentation/api/payrolluk/overview)
- [Finance API Overview](https://developer.xero.com/documentation/api/finance/overview)
- [Xero App Store API Overview](https://developer.xero.com/documentation/api/xero-app-store/overview)
- [Webhooks Overview](https://developer.xero.com/documentation/guides/webhooks/overview/)

## Summary

| Area | Status | Notes |
| --- | --- | --- |
| Auth and Identity | Built | OAuth lifecycle, PKCE, custom connections, token exchange, refresh, tenant discovery, connection management, disconnect, tenant-aware requests |
| Webhooks | Built | Signature verification, header-array helpers, payload parsing, event helpers |
| Accounting | Built | Core workflows, settings, transactions, reporting, attachments, long-tail resources |
| Files | Built | Reads, uploads, deletes, folders, inbox, associations, object-side lookup, association counts |
| Assets | Built | Assets, asset types, settings, collection search parameters |
| Projects | Built | Projects, users, tasks, time entries, lifecycle patch helpers |
| Payroll AU | Built | Employees, leave, pay items, pay runs, payslips, timesheets, payroll calendars, super funds, settings |
| Payroll NZ | Built | Employees, leave, employment, payment methods, salary-and-wages, leave types, pay run calendars, pay runs, timesheets, settings, statutory deductions |
| Payroll UK | Built | Employees, leave, employment, statutory leave balance, payment methods, pay run calendars, pay runs, payslips, timesheets, settings, reimbursements |
| Finance | Built | Cash validation, bank statement accounting, balance sheet, cashflow, profit and loss, trial balance, contact revenue, contact expenses |
| App Store | Built | Subscription lookup, usage records |

## Family matrix

| Family | Status | Tested | Docs | Open items |
| --- | --- | --- | --- | --- |
| Accounting | Built | Yes | Yes | None |
| Files | Built | Yes | Yes | None |
| Assets | Built | Yes | Yes | None |
| Projects | Built | Yes | Yes | None |
| Payroll AU | Built | Yes | Yes | None |
| Payroll NZ | Built | Yes | Yes | None |
| Payroll UK | Built | Yes | Yes | None |
| Finance | Built | Yes | Yes | None |
| App Store | Built | Yes | Yes | None |
| Auth / Identity | Built | Yes | Yes | None |
| Webhooks | Built | Yes | Yes | None |

## Open items

No open items remain from the official overview pages used for this review.

This does not mean every generated reference page endpoint was audited line by line. It means the package covers the official source set above without a remaining gap from this review.
