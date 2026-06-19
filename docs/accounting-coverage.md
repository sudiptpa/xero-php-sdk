# Accounting coverage

Tracks implemented Accounting resources against the Xero Accounting API.

## Implemented resources

- accounts
- contacts
- currencies
- branding themes
- invoices
- invoice attachments and downloads
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
- credit note attachments and downloads
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
- purchase order attachments and downloads
- purchase order PDF
- quotes
- quote PDF
- receipts
- receipt attachments and downloads
- repeating invoices
- payment services
- reports

## Coverage matrix

| Resource | Read | Write | Notes |
| --- | --- | --- | --- |
| Accounts | Yes | Create, update | |
| Contacts | Yes | Create, update | |
| Invoices | Yes | Create, update | |
| Invoice attachments | Yes | Upload | List, upload, download by filename and attachment id |
| Invoice history | Yes | Record | |
| Invoice PDF | Yes | n/a | |
| Invoice reminder settings | Yes | n/a | |
| Payments | Yes | Create, update | |
| Bank transactions | Yes | Create, update | |
| Bank transfers | Yes | Create | |
| Batch payments | Yes | Create | |
| Branding themes | Yes | No | |
| Contact groups | Yes | Create, update, attach contacts | |
| Credit notes | Yes | Create, update | |
| Credit note attachments | Yes | Upload | List, upload, download by filename and attachment id |
| Credit note history | Yes | Record | |
| Credit note PDF | Yes | n/a | |
| Currencies | Yes | Create | |
| Employees | Yes | Create, update | Deprecated by Xero: use the Payroll API instead |
| Expense claims | Yes | Create, update | |
| Items | Yes | Create, update | |
| Journals | Yes | No | Query, find by ID, find by journal number |
| Linked transactions | Yes | Create | |
| Manual journals | Yes | Create, update | Includes attachment helpers and history helpers |
| Organisations | Yes | No | Current organisation read |
| Overpayments | Yes | No | |
| Payment services | Yes | Create | |
| Prepayments | Yes | No | |
| Purchase orders | Yes | Create, update | Includes PDF helper |
| Purchase order attachments | Yes | Upload | List, upload, download by filename and attachment id |
| Quotes | Yes | Create, update | |
| Quote PDF | Yes | n/a | |
| Receipts | Yes | No | Includes attachment helpers |
| Receipt attachments | Yes | Upload | List, upload, download by filename and attachment id |
| Repeating invoices | Yes | Create, update | |
| Reports | Yes | No | Reports list, report by ID, named report helpers |
| Tax rates | Yes | Create, update | |
| Tracking categories | Yes | Create, update | |
| Users | Yes | No | |

## Scopes

- contacts: `accounting.contacts.read`, `accounting.contacts`
- invoices and payments: `accounting.transactions.read`, `accounting.transactions`; broad: `accounting.transactions`
- accounts, items, tax rates, tracking categories, branding themes, organisations, users: `accounting.settings.read`, `accounting.settings`; broad: `accounting.settings`
- credit notes, bank transactions, bank transfers, manual journals, purchase orders, quotes, receipts, repeating invoices: `accounting.transactions.read`, `accounting.transactions`
- journals: `accounting.journals.read`
- reports: `accounting.reports.read`
- attachments: `accounting.attachments.read`, `accounting.attachments`

## Done criteria

A resource is complete when it has:

- fluent public entry points
- typed read models
- typed create or update payloads where the API supports them
- tests
- scope notes
- a coverage matrix entry
