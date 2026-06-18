# Implementation status

Shows what is in the package and what is still open.

## Overview

| Area | In Xero docs | In package | Open items |
| --- | --- | --- | --- |
| Auth and Identity | Yes | Yes | None |
| Webhooks | Yes | Yes | None |
| Accounting | Yes | Yes | None |
| Files | Yes | Yes | None |
| Assets | Yes | Yes | None |
| Projects | Yes | Yes | None |
| Payroll AU | Yes | Yes | None |
| Payroll NZ | Yes | Yes | None |
| Payroll UK | Yes | Yes | None |
| Finance | Yes | Yes | None |
| App Store | Yes | Yes | None |

## Current snapshot

| Area | Status | Notes |
| --- | --- | --- |
| Core client, context, transport | Built | Native transport, fake transport, request pipeline, error mapping |
| Auth | Built | Authorization URL, token exchange, refresh, PKCE, custom connections, token storage, connection manager, disconnect |
| Identity | Built | Tenant discovery and connection disconnect via `/connections` |
| Webhooks | Built | Signature verification, header-array helpers, payload parsing, event helpers |
| Accounting | Built | Core workflows, settings, transactions, reporting, attachments, long-tail resources |
| Files | Built | Files, uploads, deletes, folders, inbox, associations, object-side lookup, association counts |
| Assets | Built | Assets, asset types, settings, collection search parameters |
| Payroll AU | Built | Employees, leave balances, leave applications, pay items, pay runs, payslips, timesheets, payroll calendars, super funds, settings |
| Payroll NZ | Built | Employees, leave, employment, payment-method, salary-and-wages, leave types, pay run calendars, pay runs, timesheets, settings, statutory deductions |
| Payroll UK | Built | Employees, leave balances, leave types, employment, payment methods, pay run calendars, pay runs, payslips, timesheets, settings, reimbursements |
| Projects | Built | Projects, users, tasks, time entries, lifecycle patch helpers |
| Finance | Built | Cash validation, bank statement accounting, balance sheet, cashflow, profit and loss, trial balance, contact revenue, contact expenses |
| App Store | Built | Subscription lookup, usage records |

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

## Auth and Identity

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| OAuth authorization URL | Yes | n/a | Yes | Yes | Yes |
| Token exchange | Yes | Yes | Yes | Yes | Yes |
| Token refresh | Yes | Yes | Yes | Yes | Yes |
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

See [accounting-coverage.md](accounting-coverage.md) for the full Accounting resource matrix.

## Files

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
| Files | Yes | Upload, update metadata, delete | Yes | Yes | Yes |
| File content | Yes | n/a | Yes | Yes | Yes |
| File associations | Yes | Create, delete | Yes | Yes | Yes |
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
| AU employees | Yes | Create, update | Yes | Yes | Yes |
| AU employee leave balances | Yes | No | Yes | Yes | Yes |
| AU leave applications | Yes | Create, update, approve, reject | Yes | Yes | Yes |
| AU pay items | Yes | No | Yes | Yes | Yes |
| AU pay runs | Yes | Create, update, payslip reads | Yes | Yes | Yes |
| AU timesheets | Yes | Create, update | Yes | Yes | Yes |
| AU payroll calendars | Yes | Create, update | Yes | Yes | Yes |
| AU super funds | Yes | Create | Yes | Yes | Yes |
| AU super fund products | Yes | No | Yes | Yes | Yes |
| AU settings | Yes | No | Yes | Yes | Yes |
| NZ employees | Yes | Create, update, leave, payment, tax, working-pattern, leave-setup, opening-balance helpers | Yes | Yes | Yes |
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
| UK settings helpers | Yes | Create reimbursement | Yes | Yes | Yes |

## Finance

| Resource | Read | Write | Tests | Docs | Scope notes |
| --- | --- | --- | --- | --- | --- |
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
