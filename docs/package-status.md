# Package Status

This document shows where the package stands against the current Xero docs.

Review date: 27 March 2026

It is meant to be a plain status page.

## Source Set

This status is based on the current official Xero docs and overview pages:

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
| Auth and Identity | Strong | Core OAuth lifecycle, PKCE, custom connections, token exchange, refresh, tenant discovery, connection management, disconnect flows, and tenant-aware request handling are covered |
| Webhooks | Strong | Signature verification, header-array helpers, payload parsing, and event-query helpers are covered |
| Accounting | Broad | This is the largest family in the package and the most complete today, including receipt attachments and downloads |
| Files | Strong | Reads, uploads, deletes, folders, inbox, associations, object-side lookup, and association counts are covered |
| Assets | Strong | Assets, asset types, settings, and the documented overview query parameters are covered |
| Projects | Strong | Projects, users, tasks, time entries, and patch/update flows are covered |
| Payroll AU | Strong | Employees, leave balances, employee-scoped leave application helpers, payroll calendars, super funds, super fund products, super fund create flow, leave applications, pay items, pay runs, payslips, timesheets, and settings are covered |
| Payroll NZ | Strong | Employees, leave helpers, tax and working-pattern helpers, employment, payment-method, salary-and-wages, leave, leave setup, opening balances, leave types, pay run calendars, pay runs, timesheets, settings, and statutory deductions are covered |
| Payroll UK | Strong | Employees, leave balances, leave types, leave-type creation, leave records, leave creation, employment, statutory leave balance, payment-method helpers, pay run calendars, pay runs, payslips, timesheets, settings helpers, and reimbursement create flow are covered |
| Finance | Strong | Core statements, cash validation, bank statement accounting, account usage, lock history, report history, and user activities are covered; Xero says Accounting Activities is being decommissioned effective April 6, 2026 |
| App Store | Strong | The currently documented subscription and usage-record flows are covered |

## What Is In Good Shape

These areas are already useful in real applications:

- Auth and Identity
- Webhooks
- Accounting core workflows
- Files
- Assets overview coverage
- Projects core flows
- Payroll AU core flows
- Payroll NZ core flows
- Payroll UK core flows
- Finance core reads
- App Store core flows

## Family Matrix

| Family | Status | Tested | Docs | Open items |
| --- | --- | --- | --- | --- |
| Accounting | Broad | Yes | Yes | no clear gap from the official overview today |
| Files | Strong | Yes | Yes | no clear gap from the official overview today |
| Assets | Strong | Yes | Yes | no clear gap from the official overview today |
| Projects | Strong | Yes | Yes | no clear gap from the official overview today |
| Payroll AU | Strong | Yes | Yes | no clear gap from the official overview today |
| Payroll NZ | Strong | Yes | Yes | no clear gap from the official overview today |
| Payroll UK | Strong | Yes | Yes | no clear gap from the official overview today |
| Finance | Strong | Yes | Yes | no clear gap from the official overview today |
| App Store | Strong | Yes | Yes | no clear gap today |
| Auth / Identity | Strong | Yes | Yes | no clear gap from the official overview today |
| Webhooks | Strong | Yes | Yes | no clear gap from the official overview today |

## Open Items

No clear open item is left from the official overview pages and guides used for this review.

That does not mean every possible low-level path from every generated reference page was audited line by line. It means the package covers the official source set listed above without a clear remaining gap from this review.
