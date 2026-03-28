# Accounting

Accounting is where the package needs to feel calm and predictable.

The package now covers the main Accounting surface and a lot of the helper paths that make real integrations less awkward:

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
- invoice attachment downloads
- invoice history
- invoice PDF
- invoice reminder settings
- credit note attachments
- credit note attachment downloads
- credit note history
- credit note PDF
- bank transaction history
- batch payment history
- item history
- payment history
- purchase order attachments
- purchase order attachment downloads
- purchase order history
- purchase order PDF
- quote PDF
- receipt history
- receipt attachments
- receipt attachment downloads
- manual journal attachments
- manual journal attachment downloads
- manual journal history

If you want the full current Accounting API picture, use the Accounting coverage guide:

- [Accounting Coverage](accounting-coverage.md)

## Scope Notes

The Accounting surface is split across a few practical scope families:

- `accounting.contacts.read` and `accounting.contacts` for contacts
- `accounting.settings.read` and `accounting.settings` for settings-style resources like accounts, items, tax rates, tracking categories, branding themes, organisations, and users
- `accounting.transactions.read` and `accounting.transactions` for invoices, payments, credit notes, bank transactions, manual journals, purchase orders, quotes, receipts, repeating invoices, and similar workflow resources

If a job is read-only, prefer the `.read` scopes. Only ask for the write scope when the app actually creates, updates, uploads, or records history.

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
use Sujip\Xero\Accounting\Contact\Contact;

$contact = $xero->accounting()
    ->contacts()
    ->create()
    ->using(
        (new Contact())
            ->setName('Acme Pty Ltd')
            ->setEmailAddress('accounts@acme.test')
    )
    ->save();
```

```php
use Sujip\Xero\Accounting\Contact\Contact;

$updated = $xero->accounting()
    ->contacts()
    ->update('contact-id')
    ->using(
        (new Contact())
            ->setContactID('contact-id')
            ->setName('Acme Holdings Pty Ltd')
    )
    ->save();
```

```php
$contact = $xero->accounting()
    ->contacts()
    ->create()
    ->using(
        (new \Sujip\Xero\Accounting\Contact\Contact())
            ->setName('Acme Pty Ltd')
            ->addPhone(
                (new \Sujip\Xero\Accounting\Contact\Phone())
                    ->setPhoneType('DEFAULT')
                    ->setPhoneNumber('5551234')
            )
            ->addAddress(
                (new \Sujip\Xero\Accounting\Contact\Address())
                    ->setAddressType('STREET')
                    ->setAddressLine1('100 George Street')
                    ->setCity('Sydney')
            )
    )
    ->save();
```

## Invoices

```php
use Sujip\Xero\Accounting\Invoice\Invoice;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;

$invoice = $xero->accounting()
    ->invoices()
    ->create()
    ->using(
        (new Invoice())
            ->setType('ACCREC')
            ->setStatus('DRAFT')
            ->setContact(
                (new Contact())
                    ->setContactID('contact-id')
            )
            ->setReference('PO-1001')
            ->addLineItem(
                (new LineItem())
                    ->setDescription('Consulting')
                    ->setQuantity(2)
                    ->setUnitAmount(150)
            )
    )
    ->save();
```

```php
use Sujip\Xero\Accounting\Invoice\Invoice;

$updated = $xero->accounting()
    ->invoices()
    ->update('invoice-id')
    ->using(
        (new Invoice())
            ->setInvoiceID('invoice-id')
            ->setReference('PO-1002')
    )
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

```php
$binary = $xero->accounting()
    ->invoices()
    ->attachments('invoice-id')
    ->download('invoice.pdf', 'application/pdf');
```

## Invoice History

```php
$history = $xero->accounting()
    ->invoices()
    ->history('invoice-id')
    ->record('Invoice synced from back office');
```

## Invoice Reminders

```php
$settings = $xero->accounting()
    ->invoiceReminders()
    ->settings();

$enabled = $settings->getEnabled();
$days = $settings->getDays();
```

## Payments

```php
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Accounting\Payment\Payment;

$payment = $xero->accounting()
    ->payments()
    ->create()
    ->using(
        (new Payment())
            ->setInvoiceID('invoice-id')
            ->setAccount(
                (new Account())
                    ->setAccountID('account-id')
            )
            ->setDate('2026-03-25')
            ->setAmount(150)
            ->setReference('PAY-1001')
    )
    ->save();
```

```php
use Sujip\Xero\Accounting\Payment\Payment;

$updated = $xero->accounting()
    ->payments()
    ->update('payment-id')
    ->using(
        (new Payment())
            ->setPaymentID('payment-id')
            ->setReference('PAY-1002')
    )
    ->save();
```

```php
$history = $xero->accounting()
    ->payments()
    ->history('payment-id')
    ->record('Payment reconciled');
```

## Receipts

```php
$attachment = $xero->accounting()
    ->receipts()
    ->attachments('receipt-id')
    ->upload('receipt.jpg', $binaryImage)
    ->mimeType('image/jpeg')
    ->save();
```

```php
$binary = $xero->accounting()
    ->receipts()
    ->attachments('receipt-id')
    ->download('receipt.jpg', 'image/jpeg');
```

```php
$receipt = $xero->accounting()
    ->receipts()
    ->find('receipt-id');

$contactId = $receipt?->getContact()?->getContactID();
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
    ->using(
        (new \Sujip\Xero\Accounting\Account\Account())
            ->setCode('200')
            ->setName('Sales')
            ->setType('REVENUE')
            ->setDescription('Primary sales account')
    )
    ->save();
```

```php
$updated = $xero->accounting()
    ->accounts()
    ->update('account-id')
    ->using(
        (new \Sujip\Xero\Accounting\Account\Account())
            ->setAccountID('account-id')
            ->setName('Primary Sales')
    )
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
    ->using(
        (new \Sujip\Xero\Accounting\Item\Item())
            ->setCode('ABC123')
            ->setName('Widget')
            ->setDescription('Standard widget')
    )
    ->save();
```

```php
$history = $xero->accounting()
    ->items()
    ->history('item-id')
    ->record('Item updated from ERP');
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
    ->using(
        (new \Sujip\Xero\Accounting\TaxRate\TaxRate())
            ->setTaxType('OUTPUT')
            ->setName('GST')
            ->addTaxComponent(
                (new \Sujip\Xero\Accounting\TaxRate\Component())
                    ->setName('GST')
                    ->setRate(15)
            )
    )
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
    ->using(
        (new \Sujip\Xero\Accounting\TrackingCategory\TrackingCategory())
            ->setName('Region')
            ->addOption(
                (new \Sujip\Xero\Accounting\TrackingCategory\Option())
                    ->setName('APAC')
            )
    )
    ->save();
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
    ->using(
        (new \Sujip\Xero\Accounting\Currency\Currency())
            ->setCode('EUR')
            ->setDescription('Euro')
    )
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

$firstEmployee = $employees->first();
$employeeId = $firstEmployee?->getEmployeeID();
$firstName = $firstEmployee?->getFirstName();
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
    ->using(
        (new \Sujip\Xero\Accounting\CreditNote\CreditNote())
            ->setType('ACCRECCREDIT')
            ->setContact(
                (new \Sujip\Xero\Accounting\Contact\Contact())
                    ->setContactID('contact-id')
            )
            ->setReference('CN-1001')
            ->addLineItem(
                (new \Sujip\Xero\Accounting\Invoice\LineItem())
                    ->setDescription('Adjustment')
                    ->setQuantity(1)
                    ->setUnitAmount(50)
            )
    )
    ->save();
```

```php
$attachments = $xero->accounting()
    ->creditNotes()
    ->attachments('credit-note-id')
    ->get();
```

```php
$binary = $xero->accounting()
    ->creditNotes()
    ->attachments('credit-note-id')
    ->downloadById('attachment-id', 'application/pdf');
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
    ->using(
        (new \Sujip\Xero\Accounting\BankTransaction\BankTransaction())
            ->setType('SPEND')
            ->setContact(
                (new \Sujip\Xero\Accounting\Contact\Contact())
                    ->setContactID('contact-id')
            )
            ->setBankAccount(
                (new \Sujip\Xero\Accounting\BankTransaction\BankAccount())
                    ->setAccountID('account-id')
            )
            ->setReference('BT-1001')
            ->addLineItem(
                (new \Sujip\Xero\Accounting\Invoice\LineItem())
                    ->setDescription('Office supplies')
                    ->setQuantity(1)
                    ->setUnitAmount(25)
            )
    )
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

```php
$binary = $xero->accounting()
    ->manualJournals()
    ->attachments('manual-journal-id')
    ->download('journal.pdf', 'application/pdf');
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
    ->using(
        (new \Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder())
            ->setContact(
                (new \Sujip\Xero\Accounting\Contact\Contact())
                    ->setContactID('contact-id')
            )
            ->setReference('PO-REF')
            ->addLineItem(
                (new \Sujip\Xero\Accounting\Invoice\LineItem())
                    ->setDescription('Hardware')
                    ->setQuantity(1)
                    ->setUnitAmount(250)
            )
    )
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

```php
$binary = $xero->accounting()
    ->purchaseOrders()
    ->attachments('purchase-order-id')
    ->downloadById('attachment-id', 'application/pdf');
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
    ->using(
        (new \Sujip\Xero\Accounting\Quote\Quote())
            ->setContact(
                (new \Sujip\Xero\Accounting\Contact\Contact())
                    ->setContactID('contact-id')
            )
            ->setTitle('Website redesign')
            ->addLineItem(
                (new \Sujip\Xero\Accounting\Invoice\LineItem())
                    ->setDescription('Design sprint')
                    ->setQuantity(1)
                    ->setUnitAmount(1200)
            )
    )
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

$firstService = $services->first();
$serviceName = $firstService?->getPaymentServiceName();
$payNowText = $firstService?->getPayNowText();
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

$firstClaim = $claims->first();
$claimId = $firstClaim?->getExpenseClaimID();
$status = $firstClaim?->getStatus();
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

$journalId = $journal?->getJournalID();
$journalNumber = $journal?->getJournalNumber();
```

## Reports

```php
$reports = $xero->accounting()
    ->reports()
    ->list();

$firstReport = $reports->first();
$reportName = $firstReport?->getReportName();
$reportType = $firstReport?->getReportType();
```

```php
$profitAndLoss = $xero->accounting()
    ->reports()
    ->profitAndLoss([
        'fromDate' => new DateTimeImmutable('2026-01-01'),
        'toDate' => new DateTimeImmutable('2026-03-25'),
    ]);

$title = $profitAndLoss?->getTitle();
```

## Scope Notes

Accounting is the broadest family in the package, so it is also the easiest place to ask for too many scopes.

Use this rule of thumb:

- reads can use granular `*.read` scopes where Xero exposes them
- writes and action endpoints need the corresponding write scopes
- attachments, history actions, and PDFs should be treated as resource-specific operations, not as “free extras”

For the current per-resource implementation picture, use:

- [Accounting Coverage](accounting-coverage.md)

The package carries scope metadata on these resources already.

Current scope shape:

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

That is only the current implemented coverage. The broader Accounting target is tracked separately in [Accounting Coverage](accounting-coverage.md).
