<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

use Sujip\Xero\Accounting\Account\Accounts as AccountsResource;
use Sujip\Xero\Accounting\BankTransaction\BankTransactions as BankTransactionsResource;
use Sujip\Xero\Accounting\BankTransfer\BankTransfers as BankTransfersResource;
use Sujip\Xero\Accounting\BatchPayment\BatchPayments as BatchPaymentsResource;
use Sujip\Xero\Accounting\BrandingTheme\BrandingThemes as BrandingThemesResource;
use Sujip\Xero\Accounting\Budget\Budgets as BudgetsResource;
use Sujip\Xero\Accounting\Contact\Contacts as ContactsResource;
use Sujip\Xero\Accounting\ContactGroup\ContactGroups as ContactGroupsResource;
use Sujip\Xero\Accounting\CreditNote\CreditNotes as CreditNotesResource;
use Sujip\Xero\Accounting\Currency\Currencies as CurrenciesResource;
use Sujip\Xero\Accounting\Employee\Employees as EmployeesResource;
use Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaims as ExpenseClaimsResource;
use Sujip\Xero\Accounting\Invoice\Invoices as InvoicesResource;
use Sujip\Xero\Accounting\InvoiceReminder\InvoiceReminders as InvoiceRemindersResource;
use Sujip\Xero\Accounting\Item\Items as ItemsResource;
use Sujip\Xero\Accounting\Journal\Journals as JournalsResource;
use Sujip\Xero\Accounting\LinkedTransaction\LinkedTransactions as LinkedTransactionsResource;
use Sujip\Xero\Accounting\ManualJournal\ManualJournals as ManualJournalsResource;
use Sujip\Xero\Accounting\Organisation\Organisations as OrganisationsResource;
use Sujip\Xero\Accounting\Overpayment\Overpayments as OverpaymentsResource;
use Sujip\Xero\Accounting\Payment\Payments as PaymentsResource;
use Sujip\Xero\Accounting\PaymentService\PaymentServices as PaymentServicesResource;
use Sujip\Xero\Accounting\Prepayment\Prepayments as PrepaymentsResource;
use Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrders as PurchaseOrdersResource;
use Sujip\Xero\Accounting\Quote\Quotes as QuotesResource;
use Sujip\Xero\Accounting\Receipt\Receipts as ReceiptsResource;
use Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoices as RepeatingInvoicesResource;
use Sujip\Xero\Accounting\Report\Reports as ReportsResource;
use Sujip\Xero\Accounting\Setup\Payload as SetupPayload;
use Sujip\Xero\Accounting\TaxRate\TaxRates as TaxRatesResource;
use Sujip\Xero\Accounting\TrackingCategory\TrackingCategories as TrackingCategoriesResource;
use Sujip\Xero\Accounting\User\Users as UsersResource;
use Sujip\Xero\Client;

final readonly class Accounting
{
    public function __construct(
        private Client $client
    ) {
    }

    public function contacts(): ContactsResource
    {
        return new ContactsResource($this->client);
    }

    public function creditNotes(): CreditNotesResource
    {
        return new CreditNotesResource($this->client);
    }

    public function bankTransactions(): BankTransactionsResource
    {
        return new BankTransactionsResource($this->client);
    }

    public function bankTransfers(): BankTransfersResource
    {
        return new BankTransfersResource($this->client);
    }

    public function linkedTransactions(): LinkedTransactionsResource
    {
        return new LinkedTransactionsResource($this->client);
    }

    public function overpayments(): OverpaymentsResource
    {
        return new OverpaymentsResource($this->client);
    }

    public function prepayments(): PrepaymentsResource
    {
        return new PrepaymentsResource($this->client);
    }

    public function batchPayments(): BatchPaymentsResource
    {
        return new BatchPaymentsResource($this->client);
    }

    public function manualJournals(): ManualJournalsResource
    {
        return new ManualJournalsResource($this->client);
    }

    public function accounts(): AccountsResource
    {
        return new AccountsResource($this->client);
    }

    public function items(): ItemsResource
    {
        return new ItemsResource($this->client);
    }

    public function taxRates(): TaxRatesResource
    {
        return new TaxRatesResource($this->client);
    }

    public function trackingCategories(): TrackingCategoriesResource
    {
        return new TrackingCategoriesResource($this->client);
    }

    public function currencies(): CurrenciesResource
    {
        return new CurrenciesResource($this->client);
    }

    public function brandingThemes(): BrandingThemesResource
    {
        return new BrandingThemesResource($this->client);
    }

    public function organisations(): OrganisationsResource
    {
        return new OrganisationsResource($this->client);
    }

    public function users(): UsersResource
    {
        return new UsersResource($this->client);
    }

    public function contactGroups(): ContactGroupsResource
    {
        return new ContactGroupsResource($this->client);
    }

    public function employees(): EmployeesResource
    {
        return new EmployeesResource($this->client);
    }

    public function expenseClaims(): ExpenseClaimsResource
    {
        return new ExpenseClaimsResource($this->client);
    }

    public function journals(): JournalsResource
    {
        return new JournalsResource($this->client);
    }

    public function reports(): ReportsResource
    {
        return new ReportsResource($this->client);
    }

    public function purchaseOrders(): PurchaseOrdersResource
    {
        return new PurchaseOrdersResource($this->client);
    }

    public function quotes(): QuotesResource
    {
        return new QuotesResource($this->client);
    }

    public function receipts(): ReceiptsResource
    {
        return new ReceiptsResource($this->client);
    }

    public function repeatingInvoices(): RepeatingInvoicesResource
    {
        return new RepeatingInvoicesResource($this->client);
    }

    public function paymentServices(): PaymentServicesResource
    {
        return new PaymentServicesResource($this->client);
    }

    public function invoices(): InvoicesResource
    {
        return new InvoicesResource($this->client);
    }

    public function invoiceReminders(): InvoiceRemindersResource
    {
        return new InvoiceRemindersResource($this->client);
    }

    public function payments(): PaymentsResource
    {
        return new PaymentsResource($this->client);
    }

    public function budgets(): BudgetsResource
    {
        return new BudgetsResource($this->client);
    }

    public function setup(): SetupPayload
    {
        return new SetupPayload($this->client);
    }
}
