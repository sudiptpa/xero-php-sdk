# Coverage Map

This document is the working implementation tracker for the package.

It is meant to answer three practical questions quickly:

- what already exists
- what is ready to use
- what is still missing

## Current Snapshot

| Area | Status | Notes |
| --- | --- | --- |
| Core client, context, transport | Built | Native transport, fake transport, request pipeline, error mapping |
| Auth | Strong working slice | Authorization URL, token exchange client, refresh, PKCE, custom connections, token storage, and connection manager are in place |
| Identity | Built | Tenant discovery through `/connections` is covered |
| Webhooks | Built base | Signature verification and payload parsing are covered; richer app/framework ergonomics are still light |
| Accounting | Broad coverage | Core workflows, settings, transactions, reporting, and long-tail resources are now in place |
| Files | Strong working slice | Files, uploads, deletes, folders, inbox, associations, object-side association lookup |
| Assets | Strong working slice | Assets, asset types, settings, and documented collection search parameters |
| Payroll AU | Strong slice | Employees, leave applications, pay items, pay runs, timesheets, settings |
| Payroll NZ | Strong slice | Employees, leave types, pay run calendars, pay runs, timesheets, settings |
| Payroll UK | Strong slice | Employees, leave balances, pay run calendars, pay runs, timesheets |
| Projects | Strong working slice | Projects, project lifecycle patch helpers, project users, tasks, and time entries |
| Finance | Strong working slice | Accounting activities, account usage, report history, cash validation, financial statements |
| App Store | Strong working slice | Subscription lookup, documented subscription-item usage paths, and usage record updates |

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

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| OAuth authorization URL | Yes | n/a | Yes | Yes | Partial |
| Token exchange | Yes | Yes | Yes | Yes | Partial |
| Token refresh helper | Supported in code | Yes | Yes | Partial | Partial |
| Connection manager | Yes | Yes | Yes | Yes | Partial |
| Identity connections | Yes | n/a | Yes | Yes | n/a |
| Custom connections | Yes | Yes | Yes | Yes | Partial |
| PKCE flow | Yes | Yes | Yes | Yes | Partial |

## Accounting

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| Contacts | Yes | Create, update | Yes | Yes | Partial |
| Invoices | Yes | Create, update | Yes | Yes | Partial |
| Invoice attachments | Yes | Upload | Yes | Yes | Partial |
| Invoice history | Yes | Record | Yes | Yes | Partial |
| Invoice PDF | Yes | n/a | Yes | Yes | Partial |
| Payments | Yes | Create, update | Yes | Yes | Partial |
| Accounts | Yes | Create, update | Yes | Yes | Partial |
| Items | Yes | Create, update | Yes | Yes | Partial |
| Tax rates | Yes | Create, update | Yes | Yes | Partial |
| Tracking categories | Yes | Create, update | Yes | Yes | Partial |
| Currencies | Yes | Create | Yes | Yes | Partial |
| Branding themes | Yes | No | Yes | Yes | Partial |
| Organisations | Yes | No | Yes | Yes | Partial |
| Users | Yes | No | Yes | Yes | Partial |
| Credit notes | Yes | Create, update | Yes | Yes | Partial |
| Bank transactions | Yes | Create, update | Yes | Yes | Partial |
| Bank transfers | Yes | Create | Yes | Yes | Partial |
| Linked transactions | Yes | Create | Yes | Yes | Partial |
| Overpayments | Yes | No | Yes | Yes | Partial |
| Prepayments | Yes | No | Yes | Yes | Partial |
| Batch payments | Yes | Create | Yes | Yes | Partial |
| Manual journals | Yes | Create, update | Yes | Yes | Partial |
| Contact groups | Yes | Create, update, attach contacts | Yes | Yes | Partial |
| Employees | Yes | Create, update | Yes | Yes | Partial |
| Expense claims | Yes | Create, update | Yes | Yes | Partial |
| Credit note attachments | Yes | Upload | Yes | Yes | Partial |
| Credit note history | Yes | Record | Yes | Yes | Partial |
| Credit note PDF | Yes | n/a | Yes | Yes | Partial |
| Journals | Yes | No | Yes | Yes | Partial |
| Purchase orders | Yes | Create, update | Yes | Yes | Partial |
| Purchase order attachments | Yes | Upload | Yes | Yes | Partial |
| Quotes | Yes | Create, update | Yes | Yes | Partial |
| Quote PDF | Yes | n/a | Yes | Yes | Partial |
| Receipts | Yes | No | Yes | Yes | Partial |
| Repeating invoices | Yes | Create, update | Yes | Yes | Partial |
| Payment services | Yes | Create | Yes | Yes | Partial |
| Reports | Yes | No | Yes | Yes | Partial |

Detailed parity tracking for Accounting lives in [accounting-parity.md](accounting-parity.md).

## Files

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| Files | Yes | Upload, update metadata, delete | Yes | Yes | Partial |
| File content | Yes | n/a | Yes | Yes | Partial |
| File associations | Yes | Create, delete association | Yes | Yes | Partial |
| Object-side file associations | Yes | n/a | Yes | Yes | Partial |
| Folders | Yes | Create, update, delete | Yes | Yes | Partial |
| Inbox | Yes | n/a | Yes | Yes | Partial |

## Assets

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| Assets | Yes | Create, search/query | Yes | Yes | Partial |
| Asset types | Yes | Create | Yes | Yes | Partial |
| Asset settings | Yes | n/a | Yes | Yes | Partial |

## Payroll

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| AU employees | Yes | Create, update | Yes | Yes | Partial |
| AU leave applications | Yes | Create, update, approve, reject | Yes | Yes | Partial |
| AU pay items | Yes | No | Yes | Yes | Partial |
| AU pay runs | Yes | Create, update | Yes | Yes | Partial |
| AU timesheets | Yes | Create, update | Yes | Yes | Partial |
| AU settings | Yes | No | Yes | Yes | Partial |
| NZ employees | Yes | Create, update, leave helpers | Yes | Yes | Partial |
| NZ leave types | Yes | No | Yes | Yes | Partial |
| NZ pay run calendars | Yes | No | Yes | Yes | Partial |
| NZ pay runs | Yes | Create | Yes | Yes | Partial |
| NZ timesheets | Yes | Create, update, approve, revert, delete | Yes | Yes | Partial |
| NZ settings | Yes | No | Yes | Yes | Partial |
| UK employees | Yes | Create, update | Yes | Yes | Partial |
| UK employee leave balances | Yes | No | Yes | Yes | Partial |
| UK employee statutory leave balance | Yes | No | Yes | Yes | Partial |
| UK pay run calendars | Yes | No | Yes | Yes | Partial |
| UK pay runs | Yes | Create | Yes | Yes | Partial |
| UK timesheets | Yes | Create, update, approve, revert | Yes | Yes | Partial |

## Finance

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| Accounting activities | Yes | No | Yes | Yes | Partial |
| Accounting activity account usage | Yes | No | Yes | Yes | Partial |
| Accounting activity report history | Yes | No | Yes | Yes | Partial |
| Cash validation | Yes | No | Yes | Yes | Partial |
| Balance sheet | Yes | No | Yes | Yes | Partial |
| Cashflow | Yes | No | Yes | Yes | Partial |
| Profit and loss | Yes | No | Yes | Yes | Partial |
| Trial balance | Yes | No | Yes | Yes | Partial |
| Contact expenses | Yes | No | Yes | Yes | Partial |
| Contact revenue | Yes | No | Yes | Yes | Partial |

## App Store

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| Subscriptions | Yes | No | Yes | Yes | Partial |
| Usage records | Yes | Create, update | Yes | Yes | Partial |

## Projects

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| Projects | Yes | Create, update, patch state | Yes | Yes | Partial |
| Project users | Yes | No | Yes | Yes | Partial |
| Tasks | Yes | Create, update, delete | Yes | Yes | Partial |
| Time entries | Yes | Create, update, delete | Yes | Yes | Partial |

## Remaining API Families

| Domain | Status | Notes |
| --- | --- | --- |
| Projects | Strong working slice | Broader helper and long-tail endpoint coverage can come later |
| Finance | Strong working slice | Read-only finance statements, accounting activity views, and validation are now covered |
| App Store | Strong working slice | Subscription lookup and documented usage-record flows are now covered |

## Next Priority

1. Tighten broad vs granular scopes per implemented resource page.
2. Tighten quick-start docs around auth, tenant selection, and first successful call.
3. Improve webhook and application integration ergonomics.
4. Re-run the parity audit after each serious domain pass.
