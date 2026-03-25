# Accounting Parity

This document tracks Accounting coverage against the current Xero Accounting documentation surface.

It is not meant to mirror the older `xero-php` package structure. It is meant to show, plainly, what the package has already covered and what is still missing if the goal is full Accounting coverage from top to bottom of the docs.

## Current Position

The package has a strong first Accounting slice, but it does not yet cover the full Accounting API.

Current implemented slice:

- accounts
- contacts
- currencies
- branding themes
- invoices
- invoice attachments
- invoice history
- invoice PDF
- items
- payments
- tax rates
- tracking categories
- organisations
- users
- credit notes
- credit note attachments
- credit note history
- credit note PDF
- bank transactions
- bank transfers
- linked transactions
- overpayments
- prepayments
- batch payments
- manual journals
- contact groups
- employees
- expense claims
- journals
- purchase orders
- purchase order attachments
- quotes
- quote PDF
- receipts
- repeating invoices
- payment services
- reports

## Parity Matrix

| Resource Area | Current status | Notes |
| --- | --- | --- |
| Accounts | Built | Query, find, create, update |
| Contacts | Built | Query, find, create, update |
| Invoices | Built | Query, find, create, update |
| Invoice attachments | Built | List, upload |
| Invoice history | Built | List, record |
| Invoice PDF | Built | Direct PDF helper |
| Payments | Built | Query, find, create, update |
| Bank transactions | Built | Query, find, create, update |
| Bank transfers | Built | Query, find, create |
| Batch payments | Built | Query, find, create |
| Branding themes | Built | Query, find |
| Contact groups | Built | Query, find, create, update, attach contacts |
| Credit notes | Built | Query, find, create, update |
| Credit note attachments | Built | List, upload |
| Credit note history | Built | List, record |
| Credit note PDF | Built | Direct PDF helper |
| Currencies | Built | Query, create |
| Employees | Built | Query, find, create, update; deprecated by Xero for removal on April 28, 2026 |
| Expense claims | Built | Query, find, create, update |
| Items | Built | Query, find, create, update |
| Journals | Built | Query, find by ID, find by journal number |
| Linked transactions | Built | Query, create |
| Manual journals | Built | Query, find, create, update |
| Organisations | Built | Current organisation read |
| Overpayments | Built | Query, find |
| Payment services | Built | Query, create |
| Prepayments | Built | Query, find |
| Purchase orders | Built | Query, find, create, update |
| Purchase order attachments | Built | List, upload |
| Quotes | Built | Query, find, create, update |
| Quote PDF | Built | Direct PDF helper |
| Receipts | Built | Query, find |
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

This still needs to be made more explicit resource by resource in the docs.

## Recommended Delivery Order

To cover Accounting top to bottom without losing quality, the next batches should be:

### 1. Settings And List Foundations

- items
- tax rates
- tracking categories
- currencies
- branding themes
- organisations
- users

### 2. Transaction Depth

- credit notes
- bank transactions
- overpayments
- prepayments
- linked transactions
- batch payments
- manual journals

### 3. Commercial Workflow Resources

- purchase orders
- quotes
- receipts
- repeating invoices
- payment services

### 4. Long Tail And Deep Helpers

- bank transfer attachments and history
- contact group contact removal helpers
- expense claim history
- credit note download-by-name and download-by-id attachment helpers
- purchase order download-by-name and download-by-id attachment helpers
- additional attachments, history, PDF helpers where documented

## Definition Of Done For An Accounting Resource

A resource is only done when it has:

- fluent public entrypoints
- typed read models
- typed create or update payloads where the API supports them
- tests
- scope notes in docs
- coverage map entry

Anything less should be treated as partial work, not finished parity.
