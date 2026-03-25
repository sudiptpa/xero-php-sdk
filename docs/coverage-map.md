# Coverage Map

This document is the working implementation tracker for the package.

It is meant to answer three practical questions quickly:

- what already exists
- what is production-shaped
- what is still missing

## Current Snapshot

| Area | Status | Notes |
| --- | --- | --- |
| Core client, context, transport | Built | Native transport, fake transport, request pipeline, error mapping |
| Auth | Partial | Authorization URL, token exchange client, token storage contract, connection manager are in place |
| Identity | Built | Tenant discovery through `/connections` is covered |
| Webhooks | Built | Signature verification and payload parsing are covered |
| Accounting | Broad coverage | Core workflows, settings, transactions, reporting, and long-tail resources are now in place |
| Files | Strong first slice | Files, uploads, content, folders, inbox, associations |
| Assets | Strong first slice | Assets, asset types, settings |
| Payroll AU | Partial | Employees only |
| Payroll NZ | Scaffold | Root only |
| Payroll UK | Scaffold | Root only |
| Projects | Scaffold | Root only |
| Finance | Scaffold | Root only |
| App Store | Scaffold | Root only |

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

## Auth And Identity

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| OAuth authorization URL | Yes | n/a | Yes | Yes | Partial |
| Token exchange | Yes | Yes | Yes | Yes | Partial |
| Token refresh helper | Supported in code | Yes | Yes | Partial | Partial |
| Connection manager | Yes | Yes | Yes | Yes | Partial |
| Identity connections | Yes | n/a | Yes | Yes | n/a |
| Custom connections | Not yet | Not yet | No | No | No |
| PKCE flow | Not yet | Not yet | No | No | No |

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
| Files | Yes | Upload, update metadata | Yes | Yes | Partial |
| File content | Yes | n/a | Yes | Yes | Partial |
| File associations | Yes | Create association | Yes | Yes | Partial |
| Folders | Yes | Create, update | Yes | Yes | Partial |
| Inbox | Yes | n/a | Yes | Yes | Partial |

## Assets

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| Assets | Yes | Create | Yes | Yes | Partial |
| Asset types | Yes | Create | Yes | Yes | Partial |
| Asset settings | Yes | n/a | Yes | Yes | Partial |

## Payroll

| Resource | Read | Write | Tests | Docs | Scope visibility |
| --- | --- | --- | --- | --- | --- |
| AU employees | Yes | No | Yes | README only | No |
| NZ root | No | No | No | No | No |
| UK root | No | No | No | No | No |

## Remaining API Families

| Domain | Status | Notes |
| --- | --- | --- |
| Projects | Scaffold | No real resources yet |
| Finance | Scaffold | No real resources yet |
| App Store | Scaffold | No real resources yet |

## Next Priority

1. Tighten broad vs granular scopes per implemented resource page.
2. Audit Accounting against the live Xero docs again and close the remaining helper gaps.
3. Tighten quick-start docs around auth, tenant selection, and first successful call.
4. Build the next real API family, which should be `Projects`.
