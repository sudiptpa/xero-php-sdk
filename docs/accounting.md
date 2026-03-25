# Accounting

Accounting is where the package needs to feel calm and predictable.

The current surface is still early, but it already covers the basic shape for:

- contacts
- invoices
- payments
- accounts
- items
- tax rates
- tracking categories
- currencies
- branding themes
- organisations
- users
- credit notes
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
- quotes
- receipts
- repeating invoices
- payment services
- reports
- invoice attachments
- invoice history
- invoice PDF
- credit note attachments
- credit note history
- credit note PDF
- purchase order attachments
- quote PDF

If you want the full current Accounting API picture, use the parity tracker:

- [Accounting Parity](accounting-parity.md)

## Contacts

```php
$contacts = $xero->accounting()
    ->contacts()
    ->where('Name.Contains(:name)', name: 'Acme')
    ->orderBy('Name')
    ->page(1)
    ->get();
```

```php
$contact = $xero->accounting()
    ->contacts()
    ->create()
    ->name('Acme Pty Ltd')
    ->email('accounts@acme.test')
    ->save();
```

```php
$updated = $xero->accounting()
    ->contacts()
    ->update('contact-id')
    ->name('Acme Holdings Pty Ltd')
    ->save();
```

## Invoices

```php
$invoice = $xero->accounting()
    ->invoices()
    ->create()
    ->type('ACCREC')
    ->draft()
    ->contact('contact-id')
    ->reference('PO-1001')
    ->lineItem('Consulting', quantity: 2, unitAmount: 150)
    ->save();
```

```php
$updated = $xero->accounting()
    ->invoices()
    ->update('invoice-id')
    ->reference('PO-1002')
    ->save();
```

```php
$pdf = $xero->accounting()
    ->invoices()
    ->pdf('invoice-id');
```

## Invoice Attachments

```php
$attachment = $xero->accounting()
    ->invoices()
    ->attachments('invoice-id')
    ->upload('invoice.pdf', $pdfBinary)
    ->mimeType('application/pdf')
    ->includeOnline()
    ->save();
```

## Invoice History

```php
$history = $xero->accounting()
    ->invoices()
    ->history('invoice-id')
    ->record('Invoice synced from back office');
```

## Payments

```php
$payment = $xero->accounting()
    ->payments()
    ->create()
    ->invoice('invoice-id')
    ->account('account-id')
    ->date('2026-03-25')
    ->amount(150)
    ->reference('PAY-1001')
    ->save();
```

```php
$updated = $xero->accounting()
    ->payments()
    ->update('payment-id')
    ->reference('PAY-1002')
    ->save();
```

## Accounts

```php
$accounts = $xero->accounting()
    ->accounts()
    ->where('Status == :status', status: 'ACTIVE')
    ->orderBy('Code')
    ->get();
```

```php
$account = $xero->accounting()
    ->accounts()
    ->create()
    ->code('200')
    ->name('Sales')
    ->type('REVENUE')
    ->description('Primary sales account')
    ->save();
```

```php
$updated = $xero->accounting()
    ->accounts()
    ->update('account-id')
    ->name('Primary Sales')
    ->save();
```

## Items

```php
$items = $xero->accounting()
    ->items()
    ->where('Code == :code', code: 'ABC123')
    ->unitDp(4)
    ->get();
```

```php
$item = $xero->accounting()
    ->items()
    ->create()
    ->code('ABC123')
    ->name('Widget')
    ->description('Standard widget')
    ->save();
```

## Tax Rates

```php
$taxRates = $xero->accounting()
    ->taxRates()
    ->where('Status == :status', status: 'ACTIVE')
    ->orderBy('Name')
    ->get();
```

```php
$taxRate = $xero->accounting()
    ->taxRates()
    ->create()
    ->taxType('OUTPUT')
    ->name('GST')
    ->component('GST', 15)
    ->save();
```

## Tracking Categories

```php
$categories = $xero->accounting()
    ->trackingCategories()
    ->includeArchived()
    ->get();
```

```php
$category = $xero->accounting()
    ->trackingCategories()
    ->create()
    ->name('Region')
    ->save();
```

## Currencies

```php
$currencies = $xero->accounting()
    ->currencies()
    ->get();
```

```php
$currency = $xero->accounting()
    ->currencies()
    ->create()
    ->code('EUR')
    ->description('Euro')
    ->save();
```

## Branding Themes

```php
$themes = $xero->accounting()
    ->brandingThemes()
    ->get();
```

## Organisation

```php
$organisation = $xero->accounting()
    ->organisations()
    ->current();
```

## Contact Groups

```php
$groups = $xero->accounting()
    ->contactGroups()
    ->where('Status == :status', status: 'ACTIVE')
    ->get();
```

```php
$group = $xero->accounting()
    ->contactGroups()
    ->create()
    ->name('Strategic Partners')
    ->save()
    ->attachContacts('contact-id');
```

## Users

```php
$users = $xero->accounting()
    ->users()
    ->where('IsSubscriber == :sub', sub: true)
    ->orderBy('LastName')
    ->get();
```

## Employees

This endpoint is still documented by Xero today, but it is deprecated and scheduled for removal on April 28, 2026. It is supported here so existing integrations have a clean path, but it should not be treated as a long-term foundation for new product design.

```php
$employees = $xero->accounting()
    ->employees()
    ->where('Status == :status', status: 'ACTIVE')
    ->orderBy('LastName')
    ->get();
```

```php
$employee = $xero->accounting()
    ->employees()
    ->create()
    ->firstName('Maria')
    ->lastName('Hill')
    ->email('maria@example.test')
    ->save();
```

## Credit Notes

```php
$creditNotes = $xero->accounting()
    ->creditNotes()
    ->where('Status == :status', status: 'AUTHORISED')
    ->get();
```

```php
$creditNote = $xero->accounting()
    ->creditNotes()
    ->create()
    ->type('ACCRECCREDIT')
    ->contact('contact-id')
    ->reference('CN-1001')
    ->lineItem('Adjustment', 1, 50)
    ->save();
```

```php
$attachments = $xero->accounting()
    ->creditNotes()
    ->attachments('credit-note-id')
    ->get();
```

```php
$history = $xero->accounting()
    ->creditNotes()
    ->history('credit-note-id')
    ->record('Credit note synced from ERP');
```

```php
$pdf = $xero->accounting()
    ->creditNotes()
    ->pdf('credit-note-id');
```

## Bank Transactions

```php
$transactions = $xero->accounting()
    ->bankTransactions()
    ->where('Status == :status', status: 'AUTHORISED')
    ->get();
```

```php
$transaction = $xero->accounting()
    ->bankTransactions()
    ->create()
    ->type('SPEND')
    ->contact('contact-id')
    ->bankAccount('account-id')
    ->reference('BT-1001')
    ->lineItem('Office supplies', 1, 25)
    ->save();
```

## Bank Transfers

```php
$bankTransfers = $xero->accounting()
    ->bankTransfers()
    ->where('Amount > :amount', amount: 100)
    ->get();
```

```php
$bankTransfer = $xero->accounting()
    ->bankTransfers()
    ->create()
    ->fromBankAccount('bank-account-a')
    ->toBankAccount('bank-account-b')
    ->amount(400)
    ->reference('Daily sweep')
    ->save();
```

## Linked Transactions

```php
$links = $xero->accounting()
    ->linkedTransactions()
    ->sourceTransaction('source-id')
    ->status('ACTIVE')
    ->get();
```

```php
$link = $xero->accounting()
    ->linkedTransactions()
    ->create()
    ->sourceTransaction('source-id')
    ->targetTransaction('target-id')
    ->contact('contact-id')
    ->save();
```

## Overpayments

```php
$overpayments = $xero->accounting()
    ->overpayments()
    ->where('Status == :status', status: 'AUTHORISED')
    ->get();
```

## Prepayments

```php
$prepayments = $xero->accounting()
    ->prepayments()
    ->where('Status == :status', status: 'AUTHORISED')
    ->get();
```

## Batch Payments

```php
$batchPayments = $xero->accounting()
    ->batchPayments()
    ->where('Status == :status', status: 'AUTHORISED')
    ->get();
```

```php
$batchPayment = $xero->accounting()
    ->batchPayments()
    ->create()
    ->account('account-id')
    ->reference('BATCH-1001')
    ->payment('invoice-id', 75)
    ->save();
```

## Manual Journals

```php
$manualJournals = $xero->accounting()
    ->manualJournals()
    ->where('Status == :status', status: 'POSTED')
    ->get();
```

```php
$manualJournal = $xero->accounting()
    ->manualJournals()
    ->create()
    ->narration('Month end adjustments')
    ->line(100, '200', true)
    ->line(100, '300', false)
    ->save();
```

## Purchase Orders

```php
$purchaseOrders = $xero->accounting()
    ->purchaseOrders()
    ->where('Status == :status', status: 'AUTHORISED')
    ->get();
```

```php
$purchaseOrder = $xero->accounting()
    ->purchaseOrders()
    ->create()
    ->contact('contact-id')
    ->reference('PO-REF')
    ->lineItem('Hardware', 1, 250)
    ->save();
```

```php
$attachment = $xero->accounting()
    ->purchaseOrders()
    ->attachments('purchase-order-id')
    ->upload('purchase-order.pdf', $pdfBinary)
    ->mimeType('application/pdf')
    ->includeOnline()
    ->save();
```

## Quotes

```php
$quotes = $xero->accounting()
    ->quotes()
    ->where('Status == :status', status: 'DRAFT')
    ->get();
```

```php
$quote = $xero->accounting()
    ->quotes()
    ->create()
    ->contact('contact-id')
    ->title('Website redesign')
    ->lineItem('Design sprint', 1, 1200)
    ->save();
```

```php
$pdf = $xero->accounting()
    ->quotes()
    ->pdf('quote-id');
```

## Receipts

```php
$receipts = $xero->accounting()
    ->receipts()
    ->where('Status == :status', status: 'DRAFT')
    ->unitDp(4)
    ->get();
```

## Repeating Invoices

```php
$repeatingInvoices = $xero->accounting()
    ->repeatingInvoices()
    ->where('Status == :status', status: 'DRAFT')
    ->get();
```

```php
$repeatingInvoice = $xero->accounting()
    ->repeatingInvoices()
    ->create()
    ->type('ACCREC')
    ->contact('contact-id')
    ->reference('RI-1001')
    ->lineItem('Monthly support', 1, 99)
    ->save();
```

## Payment Services

```php
$services = $xero->accounting()
    ->paymentServices()
    ->get();
```

```php
$service = $xero->accounting()
    ->paymentServices()
    ->create()
    ->name('Stripe')
    ->url('https://example.test/pay')
    ->payNowText('Pay online')
    ->save();
```

## Expense Claims

```php
$claims = $xero->accounting()
    ->expenseClaims()
    ->where('Status == :status', status: 'SUBMITTED')
    ->get();
```

```php
$claim = $xero->accounting()
    ->expenseClaims()
    ->create()
    ->employee('employee-id')
    ->receipt('receipt-id')
    ->status('DRAFT')
    ->save();
```

## Journals

```php
$journals = $xero->accounting()
    ->journals()
    ->offset(1200)
    ->paymentsOnly()
    ->get();
```

```php
$journal = $xero->accounting()
    ->journals()
    ->number(1251);
```

## Reports

```php
$reports = $xero->accounting()
    ->reports()
    ->list();
```

```php
$profitAndLoss = $xero->accounting()
    ->reports()
    ->profitAndLoss([
        'fromDate' => new DateTimeImmutable('2026-01-01'),
        'toDate' => new DateTimeImmutable('2026-03-25'),
    ]);
```

## Scope Notes

The package carries scope metadata on these resources already.

Current implemented scope shape:

- contacts: broad `accounting.contacts`, granular `accounting.contacts.read`, `accounting.contacts`
- invoices: broad `accounting.transactions`, granular `accounting.invoices.read`, `accounting.invoices`; PDF stays under the same invoice scope family
- payments: broad `accounting.transactions`, granular `accounting.payments.read`, `accounting.payments`
- accounts: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- items: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- tax rates: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- tracking categories: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- currencies: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- branding themes: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- organisations: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- users: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- credit notes: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`; attachments additionally use `accounting.attachments.read` or `accounting.attachments`
- bank transactions: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- bank transfers: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- linked transactions: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- overpayments: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- prepayments: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- batch payments: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- manual journals: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- contact groups: broad `accounting.contacts`, granular `accounting.contacts.read`, `accounting.contacts`
- employees: broad `accounting.settings`, granular `accounting.settings.read`, `accounting.settings`
- expense claims: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- journals: granular `accounting.journals.read`
- purchase orders: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`; attachments additionally use `accounting.attachments.read` or `accounting.attachments`
- quotes: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`; PDF stays under the same quote scope family
- receipts: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- repeating invoices: broad `accounting.transactions`, granular `accounting.transactions.read`, `accounting.transactions`
- payment services: broad `paymentservices`, granular scope shape still needs to be clarified in docs if Xero expands it
- reports: granular `accounting.reports.read`

That is only the current implemented slice. The full Accounting parity target is tracked separately in [Accounting Parity](accounting-parity.md).
