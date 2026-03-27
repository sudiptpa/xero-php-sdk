# Accounting Coverage

This document tracks Accounting coverage against the current Xero Accounting documentation surface.

## Current Position

The package has broad Accounting coverage.

Current implemented coverage:

- accounts
- contacts
- currencies
- branding themes
- invoices
- invoice attachments
- invoice attachment downloads
- invoice history
- invoice PDF
- invoice reminder settings
- items
- payments
- tax rates
- tracking categories
- organisations
- users
- credit notes
- credit note attachments
- credit note attachment downloads
- credit note history
- credit note PDF
- bank transactions
- bank transfers
- linked transactions
- overpayments
- prepayments
- batch payments
- manual journals
- manual journal attachments, downloads, and history
- contact groups
- employees
- expense claims
- journals
- purchase orders
- purchase order attachments
- purchase order attachment downloads
- purchase order PDF
- quotes
- quote PDF
- receipts
- receipt attachments
- receipt attachment downloads
- repeating invoices
- payment services
- reports

## Coverage Matrix

| Resource Area | Current status | Notes |
| --- | --- | --- |
| Accounts | Built | Query, find, create, update |
| Contacts | Built | Query, find, create, update |
| Invoices | Built | Query, find, create, update |
| Invoice attachments | Built | List, upload, download by filename and attachment id |
| Invoice history | Built | List, record |
| Invoice PDF | Built | Direct PDF helper |
| Invoice reminder settings | Built | Reminder settings read |
| Payments | Built | Query, find, create, update |
| Bank transactions | Built | Query, find, create, update |
| Bank transfers | Built | Query, find, create |
| Batch payments | Built | Query, find, create |
| Branding themes | Built | Query, find |
| Contact groups | Built | Query, find, create, update, attach contacts |
| Credit notes | Built | Query, find, create, update |
| Credit note attachments | Built | List, upload, download by filename and attachment id |
| Credit note history | Built | List, record |
| Credit note PDF | Built | Direct PDF helper |
| Currencies | Built | Query, create |
| Employees | Built | Query, find, create, update; deprecated by Xero for removal on April 28, 2026 |
| Expense claims | Built | Query, find, create, update |
| Items | Built | Query, find, create, update |
| Journals | Built | Query, find by ID, find by journal number |
| Linked transactions | Built | Query, create |
| Manual journals | Built | Query, find, create, update, attachment helpers, history helpers |
| Organisations | Built | Current organisation read |
| Overpayments | Built | Query, find |
| Payment services | Built | Query, create |
| Prepayments | Built | Query, find |
| Purchase orders | Built | Query, find, create, update, PDF helper |
| Purchase order attachments | Built | List, upload, download by filename and attachment id |
| Quotes | Built | Query, find, create, update |
| Quote PDF | Built | Direct PDF helper |
| Receipts | Built | Query, find, attachment helpers |
| Receipt attachments | Built | List, upload, download by filename and attachment id |
| Repeating invoices | Built | Query, find, create, update |
| Reports | Built | Reports list, report by ID, named report helpers |
| Tax rates | Built | Query, find, create, update |
| Tracking categories | Built | Query, find, create, update |
| Users | Built | Query |

## Scope Shape

The current implemented resources already use scope metadata in code.

Broadly:

- contacts use contact scopes
- invoices and payments use transaction scopes
- accounts use settings-style scopes

The package carries this metadata in code, and the docs point to the main scope families used by Accounting resources.

## Open Items

The open items in Accounting are small:

- a final live-docs recheck for low-traffic long-tail helpers
- any resource-specific attachment helpers beyond the current invoice, credit note, purchase order, manual journal, and receipt set if the docs expose them

## Definition Of Done For An Accounting Resource

A resource is only done when it has:

- fluent public entrypoints
- typed read models
- typed create or update payloads where the API supports them
- tests
- scope notes in docs
- coverage map entry

Anything less should not be treated as finished coverage.
