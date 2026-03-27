# Implementation Status

This document shows what is already in the package and what is still open.

It is meant to answer three practical questions quickly:

- what already exists
- what is ready to use
- what is still missing

## Xero Docs Overview

| Xero docs area | In Xero docs | Integrated in package | Open items |
| --- | --- | --- | --- |
| Auth and Identity | Yes | Yes | no clear gap from the official overview today |
| Webhooks | Yes | Yes | no clear gap from the official overview today |
| Accounting | Yes | Yes | no clear gap from the official overview today |
| Files | Yes | Yes | no clear gap from the official overview today |
| Assets | Yes | Yes | no clear gap from the official overview today |
| Projects | Yes | Yes | no clear gap from the official overview today |
| Payroll AU | Yes | Yes | no clear gap from the official overview today |
| Payroll NZ | Yes | Yes | no clear gap from the official overview today |
| Payroll UK | Yes | Yes | no clear gap from the official overview today |
| Finance | Yes | Yes | no clear gap from the official overview today |
| App Store | Yes | Yes | no clear gap today |

This table is the quickest overview:

- if the last column is empty or close to empty, that area is already in good shape
- if the last column still lists work, that area is not finished yet
- this status reflects the official Xero overview pages and guides listed in the package docs

## Current Snapshot

| Area | Status | Notes |
| --- | --- | --- |
| Core client, context, transport | Built | Native transport, fake transport, request pipeline, error mapping |
| Auth | Strong coverage | Authorization URL, token exchange client, refresh, PKCE, custom connections, token storage, connection manager, and disconnect helpers are in place |
| Identity | Built | Tenant discovery and connection disconnect support through `/connections` are covered |
| Webhooks | Strong coverage | Signature verification, header-array helpers, payload parsing, and event-query helpers are covered |
| Accounting | Broad coverage | Core workflows, settings, transactions, reporting, invoice reminder settings, receipt attachments, and long-tail resources are now in place |
| Files | Strong coverage | Files, uploads, deletes, folders, inbox, associations, object-side association lookup, and associations count |
| Assets | Near-complete overview coverage | Assets, asset types, settings, and documented collection search parameters |
| Payroll AU | Strong coverage | Employees, leave balances, employee-scoped leave application helper, payroll calendars, super funds, super fund products, super fund create flow, leave applications, pay items, pay runs, payslips, timesheets, settings |
| Payroll NZ | Strong coverage | Employees, employee leave/tax/working-pattern helpers, employment, payment-method, leave, salary-and-wages, single salary record lookup, leave setup, opening balances, leave types, pay run calendars, pay runs, timesheets, settings, statutory deductions |
| Payroll UK | Strong coverage | Employees, leave balances, leave types, leave-type creation, leave records, leave creation, employment, payment methods, pay run calendars, pay runs, payslips, timesheets, settings helpers, reimbursement create flow |
| Projects | Strong coverage | Projects, project lifecycle patch helpers, project users, tasks, and time entries |
| Finance | Strong coverage | Accounting activities, account usage, lock history, report history, user activities, cash validation, bank statement accounting, and financial statements; note the documented Accounting Activities decommissioning scheduled for April 6, 2026 |
| App Store | Strong | Subscription lookup, documented subscription-item usage paths, and usage record updates |

## Foundation

| Capability | Status | Tests | Docs |
| --- | --- | --- | --- |
| Root client | Built | Yes | README, architecture |
| Tenant-aware context | Built | Yes | README, architecture |
| HTTP transport contracts | Built | Yes | architecture |
| Pending request pipeline | Built | Yes | architecture |
| Native transport | Built | Indirect | architecture |
| Fake transport | Built | Yes | architecture |
| Shared pagination support | Built | Yes | accounting docs |
| Response error mapping | Built | Yes | auth docs |
| OAuth authorization URL helper | Built | Yes | auth docs |
| OAuth token object | Built | Yes | auth docs |
| OAuth token exchange client | Built | Yes | auth docs |
| Auth lifecycle helper | Built | Yes | auth docs |
| Identity connections | Built | Yes | README, auth docs |
| Webhook verification | Built | Yes | README |
| Webhook payload parsing | Built | Yes | README |
| PKCE helper | Built | Yes | auth docs |
| Custom connection helper | Built | Yes | auth docs |

## Auth And Identity

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| OAuth authorization URL | Yes | n/a | Yes | Yes | Yes |
| Token exchange | Yes | Yes | Yes | Yes | Yes |
| Token refresh helper | Supported in code | Yes | Yes | Yes | Yes |
| Connection manager | Yes | Yes | Yes | Yes | Yes |
| Identity connections | Yes | n/a | Yes | Yes | n/a |
| Custom connections | Yes | Yes | Yes | Yes | Yes |
| PKCE flow | Yes | Yes | Yes | Yes | Yes |

## Accounting

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| Contacts | Yes | Create, update | Yes | Yes | Yes |
| Invoices | Yes | Create, update | Yes | Yes | Yes |
| Invoice attachments | Yes | Upload | Yes | Yes | Yes |
| Invoice history | Yes | Record | Yes | Yes | Yes |
| Invoice PDF | Yes | n/a | Yes | Yes | Yes |
| Invoice reminder settings | Yes | n/a | Yes | Yes | Yes |
| Payments | Yes | Create, update | Yes | Yes | Yes |
| Accounts | Yes | Create, update | Yes | Yes | Yes |
| Items | Yes | Create, update | Yes | Yes | Yes |
| Tax rates | Yes | Create, update | Yes | Yes | Yes |
| Tracking categories | Yes | Create, update | Yes | Yes | Yes |
| Currencies | Yes | Create | Yes | Yes | Yes |
| Branding themes | Yes | No | Yes | Yes | Yes |
| Organisations | Yes | No | Yes | Yes | Yes |
| Users | Yes | No | Yes | Yes | Yes |
| Credit notes | Yes | Create, update | Yes | Yes | Yes |
| Bank transactions | Yes | Create, update | Yes | Yes | Yes |
| Bank transfers | Yes | Create | Yes | Yes | Yes |
| Linked transactions | Yes | Create | Yes | Yes | Yes |
| Overpayments | Yes | No | Yes | Yes | Yes |
| Prepayments | Yes | No | Yes | Yes | Yes |
| Batch payments | Yes | Create | Yes | Yes | Yes |
| Manual journals | Yes | Create, update | Yes | Yes | Yes |
| Contact groups | Yes | Create, update, attach contacts | Yes | Yes | Yes |
| Employees | Yes | Create, update | Yes | Yes | Yes |
| Expense claims | Yes | Create, update | Yes | Yes | Yes |
| Credit note attachments | Yes | Upload | Yes | Yes | Yes |
| Credit note history | Yes | Record | Yes | Yes | Yes |
| Credit note PDF | Yes | n/a | Yes | Yes | Yes |
| Journals | Yes | No | Yes | Yes | Yes |
| Purchase orders | Yes | Create, update | Yes | Yes | Yes |
| Purchase order attachments | Yes | Upload | Yes | Yes | Yes |
| Quotes | Yes | Create, update | Yes | Yes | Yes |
| Quote PDF | Yes | n/a | Yes | Yes | Yes |
| Receipts | Yes | No | Yes | Yes | Yes |
| Receipt attachments | Yes | Upload | Yes | Yes | Yes |
| Repeating invoices | Yes | Create, update | Yes | Yes | Yes |
| Payment services | Yes | Create | Yes | Yes | Yes |
| Reports | Yes | No | Yes | Yes | Yes |

Detailed Accounting tracking lives in [accounting-coverage.md](accounting-coverage.md).

## Files

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| Files | Yes | Upload, update metadata, delete | Yes | Yes | Yes |
| File content | Yes | n/a | Yes | Yes | Yes |
| File associations | Yes | Create, delete association | Yes | Yes | Yes |
| Object-side file associations | Yes | n/a | Yes | Yes | Yes |
| Associations count | Yes | n/a | Yes | Yes | Yes |
| Folders | Yes | Create, update, delete | Yes | Yes | Yes |
| Inbox | Yes | n/a | Yes | Yes | Yes |

## Assets

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| Assets | Yes | Create, search/query | Yes | Yes | Yes |
| Asset types | Yes | Create | Yes | Yes | Yes |
| Asset settings | Yes | n/a | Yes | Yes | Yes |

## Payroll

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| AU employees | Yes | Create, update, employee-scoped leave helper | Yes | Yes | Yes |
| AU employee leave balances | Yes | No | Yes | Yes | Yes |
| AU leave applications | Yes | Create, update, approve, reject | Yes | Yes | Yes |
| AU pay items | Yes | No | Yes | Yes | Yes |
| AU pay runs | Yes | Create, update, payslip reads | Yes | Yes | Yes |
| AU timesheets | Yes | Create, update | Yes | Yes | Yes |
| AU payroll calendars | Yes | Create, update | Yes | Yes | Yes |
| AU super funds | Yes | Create | Yes | Yes | Yes |
| AU super fund products | Yes | No | Yes | Yes | Yes |
| AU settings | Yes | No | Yes | Yes | Yes |
| NZ employees | Yes | Create, update, leave, payment, tax, working-pattern, leave-setup, and opening-balance helpers | Yes | Yes | Yes |
| NZ employee employment | Yes | No | Yes | Yes | Yes |
| NZ employee salary and wages | Yes | No | Yes | Yes | Yes |
| NZ leave types | Yes | No | Yes | Yes | Yes |
| NZ pay run calendars | Yes | No | Yes | Yes | Yes |
| NZ pay runs | Yes | Create | Yes | Yes | Yes |
| NZ timesheets | Yes | Create, update, approve, revert, delete | Yes | Yes | Yes |
| NZ settings | Yes | Statutory deductions read helpers | Yes | Yes | Yes |
| UK employees | Yes | Create, update, leave and payment helpers | Yes | Yes | Yes |
| UK employee leave balances | Yes | No | Yes | Yes | Yes |
| UK employee statutory leave balance | Yes | No | Yes | Yes | Yes |
| UK employee employment | Yes | No | Yes | Yes | Yes |
| UK employee leave types | Yes | No | Yes | Yes | Yes |
| UK pay run calendars | Yes | No | Yes | Yes | Yes |
| UK pay runs | Yes | Create, payslip reads | Yes | Yes | Yes |
| UK timesheets | Yes | Create, update, approve, revert | Yes | Yes | Yes |
| UK settings helpers | Yes | No | Yes | Yes | Yes |

## Finance

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| Accounting activities | Yes | No | Yes | Yes | Yes |
| Accounting activity account usage | Yes | No | Yes | Yes | Yes |
| Accounting activity lock history | Yes | No | Yes | Yes | Yes |
| Accounting activity report history | Yes | No | Yes | Yes | Yes |
| Accounting activity user activities | Yes | No | Yes | Yes | Yes |
| Bank statement accounting | Yes | No | Yes | Yes | Yes |
| Cash validation | Yes | No | Yes | Yes | Yes |
| Balance sheet | Yes | No | Yes | Yes | Yes |
| Cashflow | Yes | No | Yes | Yes | Yes |
| Profit and loss | Yes | No | Yes | Yes | Yes |
| Trial balance | Yes | No | Yes | Yes | Yes |
| Contact expenses | Yes | No | Yes | Yes | Yes |
| Contact revenue | Yes | No | Yes | Yes | Yes |

## App Store

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| Subscriptions | Yes | No | Yes | Yes | Yes |
| Usage records | Yes | Create, update | Yes | Yes | Yes |

## Projects

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| Projects | Yes | Create, update, patch state | Yes | Yes | Yes |
| Project users | Yes | No | Yes | Yes | Yes |
| Tasks | Yes | Create, update, delete | Yes | Yes | Yes |
| Time entries | Yes | Create, update, delete | Yes | Yes | Yes |

## Other API Families

| Domain | Status | Notes |
| --- | --- | --- |
| Projects | Strong | Projects, users, tasks, and time entries are covered |
| Finance | Strong | Finance statements, accounting activity views, and validation are covered |
| App Store | Strong | Subscription lookup and documented usage-record flows are covered |
