# Accounting reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Accounting\Account\Account](#accountingaccountaccount)
- [Accounting\Account\Accounts](#accountingaccountaccounts)
- [Accounting\Account\Payload](#accountingaccountpayload)
- [Accounting\Accounting](#accountingaccounting)
- [Accounting\Allocation](#accountingallocation)
- [Accounting\Allocations](#accountingallocations)
- [Accounting\Attachment](#accountingattachment)
- [Accounting\AttachmentUpload](#accountingattachmentupload)
- [Accounting\Attachments](#accountingattachments)
- [Accounting\BankTransaction\BankAccount](#accountingbanktransactionbankaccount)
- [Accounting\BankTransaction\BankTransaction](#accountingbanktransactionbanktransaction)
- [Accounting\BankTransaction\BankTransactions](#accountingbanktransactionbanktransactions)
- [Accounting\BankTransaction\Payload](#accountingbanktransactionpayload)
- [Accounting\BankTransfer\BankAccount](#accountingbanktransferbankaccount)
- [Accounting\BankTransfer\BankTransfer](#accountingbanktransferbanktransfer)
- [Accounting\BankTransfer\BankTransfers](#accountingbanktransferbanktransfers)
- [Accounting\BankTransfer\Payload](#accountingbanktransferpayload)
- [Accounting\BatchPayment\BatchPayment](#accountingbatchpaymentbatchpayment)
- [Accounting\BatchPayment\BatchPayments](#accountingbatchpaymentbatchpayments)
- [Accounting\BatchPayment\Payload](#accountingbatchpaymentpayload)
- [Accounting\BatchPayment\PaymentEntry](#accountingbatchpaymentpaymententry)
- [Accounting\BrandingTheme\BrandingTheme](#accountingbrandingthemebrandingtheme)
- [Accounting\BrandingTheme\BrandingThemes](#accountingbrandingthemebrandingthemes)
- [Accounting\Budget\Budget](#accountingbudgetbudget)
- [Accounting\Budget\BudgetBalance](#accountingbudgetbudgetbalance)
- [Accounting\Budget\BudgetLine](#accountingbudgetbudgetline)
- [Accounting\Budget\Budgets](#accountingbudgetbudgets)
- [Accounting\ContactGroup\ContactAssignments](#accountingcontactgroupcontactassignments)
- [Accounting\ContactGroup\ContactGroup](#accountingcontactgroupcontactgroup)
- [Accounting\ContactGroup\ContactGroups](#accountingcontactgroupcontactgroups)
- [Accounting\ContactGroup\Payload](#accountingcontactgrouppayload)
- [Accounting\Contact\AccountBalance](#accountingcontactaccountbalance)
- [Accounting\Contact\Address](#accountingcontactaddress)
- [Accounting\Contact\Balances](#accountingcontactbalances)
- [Accounting\Contact\BatchPaymentDetails](#accountingcontactbatchpaymentdetails)
- [Accounting\Contact\CisSetting](#accountingcontactcissetting)
- [Accounting\Contact\Contact](#accountingcontactcontact)
- [Accounting\Contact\ContactPerson](#accountingcontactcontactperson)
- [Accounting\Contact\Contacts](#accountingcontactcontacts)
- [Accounting\Contact\Payload](#accountingcontactpayload)
- [Accounting\Contact\Phone](#accountingcontactphone)
- [Accounting\Contact\SalesTrackingCategory](#accountingcontactsalestrackingcategory)
- [Accounting\CreditNote\Attachment](#accountingcreditnoteattachment)
- [Accounting\CreditNote\Attachments](#accountingcreditnoteattachments)
- [Accounting\CreditNote\CreditNote](#accountingcreditnotecreditnote)
- [Accounting\CreditNote\CreditNotes](#accountingcreditnotecreditnotes)
- [Accounting\CreditNote\History](#accountingcreditnotehistory)
- [Accounting\CreditNote\HistoryRecord](#accountingcreditnotehistoryrecord)
- [Accounting\CreditNote\Payload](#accountingcreditnotepayload)
- [Accounting\CreditNote\Upload](#accountingcreditnoteupload)
- [Accounting\Currency\Currencies](#accountingcurrencycurrencies)
- [Accounting\Currency\Currency](#accountingcurrencycurrency)
- [Accounting\Currency\Payload](#accountingcurrencypayload)
- [Accounting\Employee\Employee](#accountingemployeeemployee)
- [Accounting\Employee\Employees](#accountingemployeeemployees)
- [Accounting\Employee\ExternalLink](#accountingemployeeexternallink)
- [Accounting\Employee\Payload](#accountingemployeepayload)
- [Accounting\ExpenseClaim\ExpenseClaim](#accountingexpenseclaimexpenseclaim)
- [Accounting\ExpenseClaim\ExpenseClaims](#accountingexpenseclaimexpenseclaims)
- [Accounting\ExpenseClaim\Payload](#accountingexpenseclaimpayload)
- [Accounting\History](#accountinghistory)
- [Accounting\HistoryRecord](#accountinghistoryrecord)
- [Accounting\InvoiceReminder\InvoiceReminderSettings](#accountinginvoicereminderinvoiceremindersettings)
- [Accounting\InvoiceReminder\InvoiceReminders](#accountinginvoicereminderinvoicereminders)
- [Accounting\Invoice\Attachment](#accountinginvoiceattachment)
- [Accounting\Invoice\Attachments](#accountinginvoiceattachments)
- [Accounting\Invoice\Draft](#accountinginvoicedraft)
- [Accounting\Invoice\History](#accountinginvoicehistory)
- [Accounting\Invoice\HistoryRecord](#accountinginvoicehistoryrecord)
- [Accounting\Invoice\Invoice](#accountinginvoiceinvoice)
- [Accounting\Invoice\Invoices](#accountinginvoiceinvoices)
- [Accounting\Invoice\LineItem](#accountinginvoicelineitem)
- [Accounting\Invoice\LineItemItem](#accountinginvoicelineitemitem)
- [Accounting\Invoice\LineItemTracking](#accountinginvoicelineitemtracking)
- [Accounting\Invoice\TaxBreakdownComponent](#accountinginvoicetaxbreakdowncomponent)
- [Accounting\Invoice\Upload](#accountinginvoiceupload)
- [Accounting\Item\Item](#accountingitemitem)
- [Accounting\Item\Items](#accountingitemitems)
- [Accounting\Item\Payload](#accountingitempayload)
- [Accounting\Item\Purchase](#accountingitempurchase)
- [Accounting\Journal\Journal](#accountingjournaljournal)
- [Accounting\Journal\JournalLine](#accountingjournaljournalline)
- [Accounting\Journal\Journals](#accountingjournaljournals)
- [Accounting\LinkedTransaction\LinkedTransaction](#accountinglinkedtransactionlinkedtransaction)
- [Accounting\LinkedTransaction\LinkedTransactions](#accountinglinkedtransactionlinkedtransactions)
- [Accounting\LinkedTransaction\Payload](#accountinglinkedtransactionpayload)
- [Accounting\ManualJournal\Attachment](#accountingmanualjournalattachment)
- [Accounting\ManualJournal\Attachments](#accountingmanualjournalattachments)
- [Accounting\ManualJournal\JournalLine](#accountingmanualjournaljournalline)
- [Accounting\ManualJournal\ManualJournal](#accountingmanualjournalmanualjournal)
- [Accounting\ManualJournal\ManualJournals](#accountingmanualjournalmanualjournals)
- [Accounting\ManualJournal\Payload](#accountingmanualjournalpayload)
- [Accounting\ManualJournal\Upload](#accountingmanualjournalupload)
- [Accounting\Organisation\Bill](#accountingorganisationbill)
- [Accounting\Organisation\CisOrgSetting](#accountingorganisationcisorgsetting)
- [Accounting\Organisation\ExternalLink](#accountingorganisationexternallink)
- [Accounting\Organisation\Organisation](#accountingorganisationorganisation)
- [Accounting\Organisation\OrganisationAction](#accountingorganisationorganisationaction)
- [Accounting\Organisation\Organisations](#accountingorganisationorganisations)
- [Accounting\Organisation\PaymentTerm](#accountingorganisationpaymentterm)
- [Accounting\Overpayment\Overpayment](#accountingoverpaymentoverpayment)
- [Accounting\Overpayment\Overpayments](#accountingoverpaymentoverpayments)
- [Accounting\PaymentService\Payload](#accountingpaymentservicepayload)
- [Accounting\PaymentService\PaymentService](#accountingpaymentservicepaymentservice)
- [Accounting\PaymentService\PaymentServices](#accountingpaymentservicepaymentservices)
- [Accounting\Payment\InvoiceReference](#accountingpaymentinvoicereference)
- [Accounting\Payment\Payload](#accountingpaymentpayload)
- [Accounting\Payment\Payment](#accountingpaymentpayment)
- [Accounting\Payment\Payments](#accountingpaymentpayments)
- [Accounting\Prepayment\Prepayment](#accountingprepaymentprepayment)
- [Accounting\Prepayment\Prepayments](#accountingprepaymentprepayments)
- [Accounting\PurchaseOrder\Attachment](#accountingpurchaseorderattachment)
- [Accounting\PurchaseOrder\Attachments](#accountingpurchaseorderattachments)
- [Accounting\PurchaseOrder\Payload](#accountingpurchaseorderpayload)
- [Accounting\PurchaseOrder\PurchaseOrder](#accountingpurchaseorderpurchaseorder)
- [Accounting\PurchaseOrder\PurchaseOrders](#accountingpurchaseorderpurchaseorders)
- [Accounting\PurchaseOrder\Upload](#accountingpurchaseorderupload)
- [Accounting\Quote\Payload](#accountingquotepayload)
- [Accounting\Quote\Quote](#accountingquotequote)
- [Accounting\Quote\Quotes](#accountingquotequotes)
- [Accounting\Receipt\Attachment](#accountingreceiptattachment)
- [Accounting\Receipt\Attachments](#accountingreceiptattachments)
- [Accounting\Receipt\Receipt](#accountingreceiptreceipt)
- [Accounting\Receipt\Receipts](#accountingreceiptreceipts)
- [Accounting\Receipt\Upload](#accountingreceiptupload)
- [Accounting\RepeatingInvoice\Payload](#accountingrepeatinginvoicepayload)
- [Accounting\RepeatingInvoice\RepeatingInvoice](#accountingrepeatinginvoicerepeatinginvoice)
- [Accounting\RepeatingInvoice\RepeatingInvoices](#accountingrepeatinginvoicerepeatinginvoices)
- [Accounting\RepeatingInvoice\Schedule](#accountingrepeatinginvoiceschedule)
- [Accounting\Report\Report](#accountingreportreport)
- [Accounting\Report\Reports](#accountingreportreports)
- [Accounting\Report\TenNinetyNineContact](#accountingreporttenninetyninecontact)
- [Accounting\Setup\ImportSummary](#accountingsetupimportsummary)
- [Accounting\Setup\Payload](#accountingsetuppayload)
- [Accounting\TaxRate\Component](#accountingtaxratecomponent)
- [Accounting\TaxRate\Payload](#accountingtaxratepayload)
- [Accounting\TaxRate\TaxRate](#accountingtaxratetaxrate)
- [Accounting\TaxRate\TaxRates](#accountingtaxratetaxrates)
- [Accounting\TrackingCategory\Option](#accountingtrackingcategoryoption)
- [Accounting\TrackingCategory\Payload](#accountingtrackingcategorypayload)
- [Accounting\TrackingCategory\TrackingCategories](#accountingtrackingcategorytrackingcategories)
- [Accounting\TrackingCategory\TrackingCategory](#accountingtrackingcategorytrackingcategory)
- [Accounting\User\User](#accountinguseruser)
- [Accounting\User\Users](#accountinguserusers)

## Accounting\Account\Account

[Source](../../src/Accounting/Account/Account.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AccountID` | string or null | `()` |
| `Code` | string or null | `()` |
| `Name` | string or null | `()` |
| `Type` | string or null | `()` |
| `Status` | string or null | `()` |
| `Description` | string or null | `()` |
| `BankAccountNumber` | string or null | `()` |
| `BankAccountType` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `TaxType` | string or null | `()` |
| `EnablePaymentsToAccount` | bool or null | `()` |
| `ShowInExpenseClaims` | bool or null | `()` |
| `Class` | string or null | `()` |
| `SystemAccount` | string or null | `()` |
| `ReportingCode` | string or null | `()` |
| `ReportingCodeName` | string or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `AddToWatchlist` | bool or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Account/Account.php#L16)
- [`getAccountID(): ?string`](../../src/Accounting/Account/Account.php#L64)
- [`setAccountID(?string $accountID): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L69)
- [`getCode(): ?string`](../../src/Accounting/Account/Account.php#L76)
- [`setCode(?string $code): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L81)
- [`getName(): ?string`](../../src/Accounting/Account/Account.php#L88)
- [`setName(?string $name): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L93)
- [`getType(): ?string`](../../src/Accounting/Account/Account.php#L100)
- [`setType(?string $type): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L105)
- [`getStatus(): ?string`](../../src/Accounting/Account/Account.php#L112)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L117)
- [`getDescription(): ?string`](../../src/Accounting/Account/Account.php#L124)
- [`setDescription(?string $description): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L129)
- [`getBankAccountNumber(): ?string`](../../src/Accounting/Account/Account.php#L136)
- [`setBankAccountNumber(?string $bankAccountNumber): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L141)
- [`getBankAccountType(): ?string`](../../src/Accounting/Account/Account.php#L148)
- [`setBankAccountType(?string $bankAccountType): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L153)
- [`getCurrencyCode(): ?string`](../../src/Accounting/Account/Account.php#L160)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L165)
- [`getTaxType(): ?string`](../../src/Accounting/Account/Account.php#L172)
- [`setTaxType(?string $taxType): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L177)
- [`getEnablePaymentsToAccount(): ?bool`](../../src/Accounting/Account/Account.php#L184)
- [`setEnablePaymentsToAccount(?bool $enablePaymentsToAccount): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L189)
- [`getShowInExpenseClaims(): ?bool`](../../src/Accounting/Account/Account.php#L196)
- [`setShowInExpenseClaims(?bool $showInExpenseClaims): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L201)
- [`getClass(): ?string`](../../src/Accounting/Account/Account.php#L208)
- [`setClass(?string $class): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L213)
- [`getSystemAccount(): ?string`](../../src/Accounting/Account/Account.php#L220)
- [`setSystemAccount(?string $systemAccount): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L225)
- [`getReportingCode(): ?string`](../../src/Accounting/Account/Account.php#L232)
- [`setReportingCode(?string $reportingCode): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L237)
- [`getReportingCodeName(): ?string`](../../src/Accounting/Account/Account.php#L244)
- [`setReportingCodeName(?string $reportingCodeName): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L249)
- [`getHasAttachments(): ?bool`](../../src/Accounting/Account/Account.php#L256)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L261)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Account/Account.php#L268)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L273)
- [`getAddToWatchlist(): ?bool`](../../src/Accounting/Account/Account.php#L280)
- [`setAddToWatchlist(?bool $addToWatchlist): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L285)
- [`getValidationErrors(): array`](../../src/Accounting/Account/Account.php#L295)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L300)
- [`toRequest(): array`](../../src/Accounting/Account/Account.php#L339)
- [`code(string $code): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L359)
- [`name(string $name): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L364)
- [`type(string $type): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L369)
- [`save(): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Account.php#L374)

## Accounting\Account\Accounts

[Source](../../src/Accounting/Account/Accounts.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/Account/Accounts.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Account/Accounts.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/Account/Accounts.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Account/Accounts.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Account/Accounts.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Account/Accounts.php#L30)
- [`ids(string ...$ids): static`](../../src/Accounting/Account/Accounts.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Account\Accounts`](../../src/Accounting/Account/Accounts.php#L38)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Account/Accounts.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Account/Accounts.php#L49)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Account/Accounts.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/Account/Accounts.php#L69)
- [`find(string $accountId): ?\Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Accounts.php#L89)
- [`create(): Sujip\Xero\Accounting\Account\Payload`](../../src/Accounting/Account/Accounts.php#L101)
- [`update(string $accountId): Sujip\Xero\Accounting\Account\Payload`](../../src/Accounting/Account/Accounts.php#L106)
- [`attachments(string $accountId): Sujip\Xero\Accounting\Attachments`](../../src/Accounting/Account/Accounts.php#L111)
- [`mapAccount(array $payload): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Accounts.php#L119)

## Accounting\Account\Payload

[Source](../../src/Accounting/Account/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Account/Payload.php#L14)
- [`code(string $code): Sujip\Xero\Accounting\Account\Payload`](../../src/Accounting/Account/Payload.php#L20)
- [`name(string $name): Sujip\Xero\Accounting\Account\Payload`](../../src/Accounting/Account/Payload.php#L29)
- [`type(string $type): Sujip\Xero\Accounting\Account\Payload`](../../src/Accounting/Account/Payload.php#L38)
- [`description(string $description): Sujip\Xero\Accounting\Account\Payload`](../../src/Accounting/Account/Payload.php#L47)
- [`id(string $accountId): Sujip\Xero\Accounting\Account\Payload`](../../src/Accounting/Account/Payload.php#L56)
- [`using(\Sujip\Xero\Accounting\Account\Account $account): Sujip\Xero\Accounting\Account\Payload`](../../src/Accounting/Account/Payload.php#L65)
- [`save(): Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Account/Payload.php#L73)

## Accounting\Accounting

[Source](../../src/Accounting/Accounting.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Accounting.php#L43)
- [`contacts(): Sujip\Xero\Accounting\Contact\Contacts`](../../src/Accounting/Accounting.php#L48)
- [`creditNotes(): Sujip\Xero\Accounting\CreditNote\CreditNotes`](../../src/Accounting/Accounting.php#L53)
- [`bankTransactions(): Sujip\Xero\Accounting\BankTransaction\BankTransactions`](../../src/Accounting/Accounting.php#L58)
- [`bankTransfers(): Sujip\Xero\Accounting\BankTransfer\BankTransfers`](../../src/Accounting/Accounting.php#L63)
- [`linkedTransactions(): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransactions`](../../src/Accounting/Accounting.php#L68)
- [`overpayments(): Sujip\Xero\Accounting\Overpayment\Overpayments`](../../src/Accounting/Accounting.php#L73)
- [`prepayments(): Sujip\Xero\Accounting\Prepayment\Prepayments`](../../src/Accounting/Accounting.php#L78)
- [`batchPayments(): Sujip\Xero\Accounting\BatchPayment\BatchPayments`](../../src/Accounting/Accounting.php#L83)
- [`manualJournals(): Sujip\Xero\Accounting\ManualJournal\ManualJournals`](../../src/Accounting/Accounting.php#L88)
- [`accounts(): Sujip\Xero\Accounting\Account\Accounts`](../../src/Accounting/Accounting.php#L93)
- [`items(): Sujip\Xero\Accounting\Item\Items`](../../src/Accounting/Accounting.php#L98)
- [`taxRates(): Sujip\Xero\Accounting\TaxRate\TaxRates`](../../src/Accounting/Accounting.php#L103)
- [`trackingCategories(): Sujip\Xero\Accounting\TrackingCategory\TrackingCategories`](../../src/Accounting/Accounting.php#L108)
- [`currencies(): Sujip\Xero\Accounting\Currency\Currencies`](../../src/Accounting/Accounting.php#L113)
- [`brandingThemes(): Sujip\Xero\Accounting\BrandingTheme\BrandingThemes`](../../src/Accounting/Accounting.php#L118)
- [`organisations(): Sujip\Xero\Accounting\Organisation\Organisations`](../../src/Accounting/Accounting.php#L123)
- [`users(): Sujip\Xero\Accounting\User\Users`](../../src/Accounting/Accounting.php#L128)
- [`contactGroups(): Sujip\Xero\Accounting\ContactGroup\ContactGroups`](../../src/Accounting/Accounting.php#L133)
- [`employees(): Sujip\Xero\Accounting\Employee\Employees`](../../src/Accounting/Accounting.php#L138)
- [`expenseClaims(): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaims`](../../src/Accounting/Accounting.php#L143)
- [`journals(): Sujip\Xero\Accounting\Journal\Journals`](../../src/Accounting/Accounting.php#L148)
- [`reports(): Sujip\Xero\Accounting\Report\Reports`](../../src/Accounting/Accounting.php#L153)
- [`purchaseOrders(): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrders`](../../src/Accounting/Accounting.php#L158)
- [`quotes(): Sujip\Xero\Accounting\Quote\Quotes`](../../src/Accounting/Accounting.php#L163)
- [`receipts(): Sujip\Xero\Accounting\Receipt\Receipts`](../../src/Accounting/Accounting.php#L168)
- [`repeatingInvoices(): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoices`](../../src/Accounting/Accounting.php#L173)
- [`paymentServices(): Sujip\Xero\Accounting\PaymentService\PaymentServices`](../../src/Accounting/Accounting.php#L178)
- [`invoices(): Sujip\Xero\Accounting\Invoice\Invoices`](../../src/Accounting/Accounting.php#L183)
- [`invoiceReminders(): Sujip\Xero\Accounting\InvoiceReminder\InvoiceReminders`](../../src/Accounting/Accounting.php#L188)
- [`payments(): Sujip\Xero\Accounting\Payment\Payments`](../../src/Accounting/Accounting.php#L193)
- [`budgets(): Sujip\Xero\Accounting\Budget\Budgets`](../../src/Accounting/Accounting.php#L198)
- [`setup(): Sujip\Xero\Accounting\Setup\Payload`](../../src/Accounting/Accounting.php#L203)

## Accounting\Allocation

[Source](../../src/Accounting/Allocation.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AllocationID` | string or null | `setAllocationID()` |
| `Amount` | int, float, or null | `setAmount()` |
| `Date` | string or null | `setDate()` |
| `IsDeleted` | bool or null | `setIsDeleted()` |
| `Invoice` | object or null ([Accounting\Invoice\Invoice](accounting.md#accountinginvoiceinvoice)) | `setInvoice()` |
| `Overpayment` | object or null ([Accounting\Overpayment\Overpayment](accounting.md#accountingoverpaymentoverpayment)) | `setOverpayment()` |
| `Prepayment` | object or null ([Accounting\Prepayment\Prepayment](accounting.md#accountingprepaymentprepayment)) | `setPrepayment()` |
| `CreditNote` | object or null ([Accounting\CreditNote\CreditNote](accounting.md#accountingcreditnotecreditnote)) | `setCreditNote()` |
| `StatusAttributeString` | string or null | `setStatusAttributeString()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`getAllocationID(): ?string`](../../src/Accounting/Allocation.php#L32)
- [`setAllocationID(?string $allocationID): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L37)
- [`getAmount(): ?float`](../../src/Accounting/Allocation.php#L44)
- [`setAmount(?float $amount): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L49)
- [`getDate(): ?string`](../../src/Accounting/Allocation.php#L56)
- [`setDate(?string $date): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L61)
- [`getIsDeleted(): ?bool`](../../src/Accounting/Allocation.php#L68)
- [`setIsDeleted(?bool $isDeleted): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L73)
- [`getInvoice(): ?\Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Allocation.php#L80)
- [`setInvoice(?\Sujip\Xero\Accounting\Invoice\Invoice $invoice): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L85)
- [`getOverpayment(): ?\Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Allocation.php#L92)
- [`setOverpayment(?\Sujip\Xero\Accounting\Overpayment\Overpayment $overpayment): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L97)
- [`getPrepayment(): ?\Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Allocation.php#L104)
- [`setPrepayment(?\Sujip\Xero\Accounting\Prepayment\Prepayment $prepayment): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L109)
- [`getCreditNote(): ?\Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/Allocation.php#L116)
- [`setCreditNote(?\Sujip\Xero\Accounting\CreditNote\CreditNote $creditNote): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L121)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/Allocation.php#L128)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L133)
- [`getValidationErrors(): array`](../../src/Accounting/Allocation.php#L143)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocation.php#L148)

## Accounting\Allocations

[Source](../../src/Accounting/Allocations.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $path)`](../../src/Accounting/Allocations.php#L12)
- [`create(string $invoiceId, float $amount, string $date, ?string $idempotencyKey = NULL): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocations.php#L18)
- [`delete(string $allocationId): Sujip\Xero\Accounting\Allocation`](../../src/Accounting/Allocations.php#L40)

## Accounting\Attachment

[Source](../../src/Accounting/Attachment.php)

### Public methods

- [`__construct(?string $id, ?string $fileName, ?string $mimeType, ?bool $includeOnline, array $raw = array (
))`](../../src/Accounting/Attachment.php#L12)

## Accounting\AttachmentUpload

[Source](../../src/Accounting/AttachmentUpload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $path, string $fileName, string $content)`](../../src/Accounting/AttachmentUpload.php#L17)
- [`mimeType(string $mimeType): Sujip\Xero\Accounting\AttachmentUpload`](../../src/Accounting/AttachmentUpload.php#L25)
- [`includeOnline(bool $includeOnline = true): Sujip\Xero\Accounting\AttachmentUpload`](../../src/Accounting/AttachmentUpload.php#L33)
- [`save(): Sujip\Xero\Accounting\Attachment`](../../src/Accounting/AttachmentUpload.php#L41)
- [`update(): Sujip\Xero\Accounting\Attachment`](../../src/Accounting/AttachmentUpload.php#L46)

## Accounting\Attachments

[Source](../../src/Accounting/Attachments.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $path)`](../../src/Accounting/Attachments.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Attachments.php#L22)
- [`upload(string $fileName, string $content): Sujip\Xero\Accounting\AttachmentUpload`](../../src/Accounting/Attachments.php#L37)
- [`download(string $fileName, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/Attachments.php#L42)
- [`downloadById(string $attachmentId, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/Attachments.php#L54)
- [`mapAttachment(array $attachment): Sujip\Xero\Accounting\Attachment`](../../src/Accounting/Attachments.php#L69)

## Accounting\BankTransaction\BankAccount

[Source](../../src/Accounting/BankTransaction/BankAccount.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AccountID` | string or null | `()` |

### Public methods

- [`getAccountID(): ?string`](../../src/Accounting/BankTransaction/BankAccount.php#L15)
- [`setAccountID(?string $accountID): Sujip\Xero\Accounting\BankTransaction\BankAccount`](../../src/Accounting/BankTransaction/BankAccount.php#L20)
- [`toRequest(): array`](../../src/Accounting/BankTransaction/BankAccount.php#L40)

## Accounting\BankTransaction\BankTransaction

[Source](../../src/Accounting/BankTransaction/BankTransaction.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `BankTransactionID` | string or null | `()` |
| `Type` | string or null | `()` |
| `Status` | string or null | `()` |
| `Reference` | string or null | `()` |
| `Total` | int, float, or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `BankAccount` | object or null ([Accounting\BankTransaction\BankAccount](accounting.md#accountingbanktransactionbankaccount)) | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `IsReconciled` | bool or null | `()` |
| `Date` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `Url` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `PrepaymentID` | string or null | `()` |
| `OverpaymentID` | string or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/BankTransaction/BankTransaction.php#L19)
- [`getBankTransactionID(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L74)
- [`setBankTransactionID(?string $bankTransactionID): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L79)
- [`getType(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L86)
- [`setType(?string $type): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L91)
- [`getStatus(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L98)
- [`setStatus(?string $status): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L103)
- [`getReference(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L110)
- [`setReference(?string $reference): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L115)
- [`getTotal(): int\|float\|null`](../../src/Accounting/BankTransaction/BankTransaction.php#L122)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L127)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/BankTransaction/BankTransaction.php#L134)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L139)
- [`getBankAccount(): ?\Sujip\Xero\Accounting\BankTransaction\BankAccount`](../../src/Accounting/BankTransaction/BankTransaction.php#L146)
- [`setBankAccount(?\Sujip\Xero\Accounting\BankTransaction\BankAccount $bankAccount): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L151)
- [`getLineItems(): array`](../../src/Accounting/BankTransaction/BankTransaction.php#L161)
- [`setLineItems(array $lineItems): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L169)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L176)
- [`getIsReconciled(): ?bool`](../../src/Accounting/BankTransaction/BankTransaction.php#L183)
- [`setIsReconciled(?bool $isReconciled): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L188)
- [`getDate(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L195)
- [`setDate(?string $date): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L200)
- [`getCurrencyCode(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L207)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L212)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/BankTransaction/BankTransaction.php#L219)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L224)
- [`getUrl(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L231)
- [`setUrl(?string $url): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L236)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L243)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L248)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/BankTransaction/BankTransaction.php#L255)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L260)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/BankTransaction/BankTransaction.php#L267)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L272)
- [`getPrepaymentID(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L279)
- [`setPrepaymentID(?string $prepaymentID): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L284)
- [`getOverpaymentID(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L291)
- [`setOverpaymentID(?string $overpaymentID): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L296)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L303)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L308)
- [`getHasAttachments(): ?bool`](../../src/Accounting/BankTransaction/BankTransaction.php#L315)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L320)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/BankTransaction/BankTransaction.php#L327)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L332)
- [`getValidationErrors(): array`](../../src/Accounting/BankTransaction/BankTransaction.php#L342)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L347)
- [`toRequest(): array`](../../src/Accounting/BankTransaction/BankTransaction.php#L397)
- [`reference(string $reference): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L420)
- [`type(string $type): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L425)
- [`contact(string $contactId): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L430)
- [`bankAccount(string $accountId): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L438)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L446)
- [`save(): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransaction.php#L456)
- [`history(): Sujip\Xero\Accounting\History`](../../src/Accounting/BankTransaction/BankTransaction.php#L467)

## Accounting\BankTransaction\BankTransactions

[Source](../../src/Accounting/BankTransaction/BankTransactions.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/BankTransaction/BankTransactions.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/BankTransaction/BankTransactions.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/BankTransaction/BankTransactions.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/BankTransaction/BankTransactions.php#L26)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/BankTransaction/BankTransactions.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/BankTransaction/BankTransactions.php#L31)
- [`ids(string ...$ids): static`](../../src/Accounting/BankTransaction/BankTransactions.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\BankTransaction\BankTransactions`](../../src/Accounting/BankTransaction/BankTransactions.php#L39)
- [`unitDp(int $unitDp): static`](../../src/Accounting/BankTransaction/BankTransactions.php#L43)
- [`references(string ...$references): Sujip\Xero\Accounting\BankTransaction\BankTransactions`](../../src/Accounting/BankTransaction/BankTransactions.php#L47)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/BankTransaction/BankTransactions.php#L51)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/BankTransaction/BankTransactions.php#L58)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/BankTransaction/BankTransactions.php#L78)
- [`find(string $bankTransactionId): ?\Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransactions.php#L93)
- [`create(): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/BankTransactions.php#L105)
- [`update(string $bankTransactionId): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/BankTransactions.php#L110)
- [`history(string $bankTransactionId): Sujip\Xero\Accounting\History`](../../src/Accounting/BankTransaction/BankTransactions.php#L115)
- [`attachments(string $bankTransactionId): Sujip\Xero\Accounting\Attachments`](../../src/Accounting/BankTransaction/BankTransactions.php#L120)
- [`mapBankTransaction(array $payload): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/BankTransactions.php#L128)

## Accounting\BankTransaction\Payload

[Source](../../src/Accounting/BankTransaction/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/BankTransaction/Payload.php#L16)
- [`id(string $bankTransactionId): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/Payload.php#L22)
- [`type(string $type): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/Payload.php#L31)
- [`contact(string $contactId): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/Payload.php#L40)
- [`bankAccount(string $accountId): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/Payload.php#L52)
- [`reference(string $reference): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/Payload.php#L64)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/Payload.php#L73)
- [`using(\Sujip\Xero\Accounting\BankTransaction\BankTransaction $transaction): Sujip\Xero\Accounting\BankTransaction\Payload`](../../src/Accounting/BankTransaction/Payload.php#L87)
- [`save(): Sujip\Xero\Accounting\BankTransaction\BankTransaction`](../../src/Accounting/BankTransaction/Payload.php#L95)

## Accounting\BankTransfer\BankAccount

[Source](../../src/Accounting/BankTransfer/BankAccount.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AccountID` | string or null | `()` |

### Public methods

- [`getAccountID(): ?string`](../../src/Accounting/BankTransfer/BankAccount.php#L15)
- [`setAccountID(?string $accountID): Sujip\Xero\Accounting\BankTransfer\BankAccount`](../../src/Accounting/BankTransfer/BankAccount.php#L20)
- [`toRequest(): array`](../../src/Accounting/BankTransfer/BankAccount.php#L40)

## Accounting\BankTransfer\BankTransfer

[Source](../../src/Accounting/BankTransfer/BankTransfer.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `BankTransferID` | string or null | `()` |
| `FromBankAccount` | object or null ([Accounting\BankTransfer\BankAccount](accounting.md#accountingbanktransferbankaccount)) | `()` |
| `ToBankAccount` | object or null ([Accounting\BankTransfer\BankAccount](accounting.md#accountingbanktransferbankaccount)) | `()` |
| `Amount` | int, float, or null | `()` |
| `Date` | string or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `FromBankTransactionID` | string or null | `()` |
| `ToBankTransactionID` | string or null | `()` |
| `FromIsReconciled` | bool or null | `()` |
| `ToIsReconciled` | bool or null | `()` |
| `Reference` | string or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `CreatedDateUTC` | string or null | `()` |
| `Status` | string or null | `()` |
| `FromTracking` | list of objects ([Accounting\Invoice\LineItemTracking](accounting.md#accountinginvoicelineitemtracking)) | `()` |
| `ToTracking` | list of objects ([Accounting\Invoice\LineItemTracking](accounting.md#accountinginvoicelineitemtracking)) | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/BankTransfer/BankTransfer.php#L59)
- [`getBankTransferID(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L64)
- [`setBankTransferID(?string $bankTransferID): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L69)
- [`getFromBankAccount(): ?\Sujip\Xero\Accounting\BankTransfer\BankAccount`](../../src/Accounting/BankTransfer/BankTransfer.php#L76)
- [`setFromBankAccount(?\Sujip\Xero\Accounting\BankTransfer\BankAccount $fromBankAccount): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L81)
- [`getToBankAccount(): ?\Sujip\Xero\Accounting\BankTransfer\BankAccount`](../../src/Accounting/BankTransfer/BankTransfer.php#L88)
- [`setToBankAccount(?\Sujip\Xero\Accounting\BankTransfer\BankAccount $toBankAccount): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L93)
- [`getFromBankAccountID(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L100)
- [`setFromBankAccountID(?string $fromBankAccountID): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L105)
- [`getToBankAccountID(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L114)
- [`setToBankAccountID(?string $toBankAccountID): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L119)
- [`getAmount(): int\|float\|null`](../../src/Accounting/BankTransfer/BankTransfer.php#L128)
- [`setAmount(int\|float\|null $amount): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L133)
- [`getDate(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L140)
- [`setDate(?string $date): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L145)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/BankTransfer/BankTransfer.php#L152)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L157)
- [`getFromBankTransactionID(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L164)
- [`setFromBankTransactionID(?string $fromBankTransactionID): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L169)
- [`getToBankTransactionID(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L176)
- [`setToBankTransactionID(?string $toBankTransactionID): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L181)
- [`getFromIsReconciled(): ?bool`](../../src/Accounting/BankTransfer/BankTransfer.php#L188)
- [`setFromIsReconciled(?bool $fromIsReconciled): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L193)
- [`getToIsReconciled(): ?bool`](../../src/Accounting/BankTransfer/BankTransfer.php#L200)
- [`setToIsReconciled(?bool $toIsReconciled): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L205)
- [`getReference(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L212)
- [`setReference(?string $reference): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L217)
- [`getHasAttachments(): ?bool`](../../src/Accounting/BankTransfer/BankTransfer.php#L224)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L229)
- [`getCreatedDateUTC(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L236)
- [`setCreatedDateUTC(?string $createdDateUTC): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L241)
- [`getStatus(): ?string`](../../src/Accounting/BankTransfer/BankTransfer.php#L248)
- [`setStatus(?string $status): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L253)
- [`getFromTracking(): array`](../../src/Accounting/BankTransfer/BankTransfer.php#L263)
- [`addFromTracking(\Sujip\Xero\Accounting\Invoice\LineItemTracking $fromTracking): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L268)
- [`getToTracking(): array`](../../src/Accounting/BankTransfer/BankTransfer.php#L278)
- [`addToTracking(\Sujip\Xero\Accounting\Invoice\LineItemTracking $toTracking): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L283)
- [`getValidationErrors(): array`](../../src/Accounting/BankTransfer/BankTransfer.php#L293)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L298)
- [`amount(int\|float $amount): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L331)
- [`date(string $date): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L336)
- [`reference(string $reference): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L341)
- [`save(): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfer.php#L346)

## Accounting\BankTransfer\BankTransfers

[Source](../../src/Accounting/BankTransfer/BankTransfers.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/BankTransfer/BankTransfers.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/BankTransfer/BankTransfers.php#L22)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/BankTransfer/BankTransfers.php#L27)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/BankTransfer/BankTransfers.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\BankTransfer\BankTransfers`](../../src/Accounting/BankTransfer/BankTransfers.php#L35)
- [`ids(string ...$ids): static`](../../src/Accounting/BankTransfer/BankTransfers.php#L35)
- [`includeDeleted(bool $includeDeleted = true): Sujip\Xero\Accounting\BankTransfer\BankTransfers`](../../src/Accounting/BankTransfer/BankTransfers.php#L43)
- [`unitDp(int $unitDp): static`](../../src/Accounting/BankTransfer/BankTransfers.php#L43)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/BankTransfer/BankTransfers.php#L51)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/BankTransfer/BankTransfers.php#L54)
- [`find(string $bankTransferId): ?\Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfers.php#L71)
- [`create(): Sujip\Xero\Accounting\BankTransfer\Payload`](../../src/Accounting/BankTransfer/BankTransfers.php#L83)
- [`delete(string $bankTransferId): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfers.php#L88)
- [`deleteMany(array $bankTransferIds): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/BankTransfer/BankTransfers.php#L105)
- [`history(string $bankTransferId): Sujip\Xero\Accounting\History`](../../src/Accounting/BankTransfer/BankTransfers.php#L129)
- [`attachments(string $bankTransferId): Sujip\Xero\Accounting\Attachments`](../../src/Accounting/BankTransfer/BankTransfers.php#L134)
- [`mapBankTransfer(array $payload): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/BankTransfers.php#L142)

## Accounting\BankTransfer\Payload

[Source](../../src/Accounting/BankTransfer/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/BankTransfer/Payload.php#L19)
- [`fromBankAccount(string $accountId): Sujip\Xero\Accounting\BankTransfer\Payload`](../../src/Accounting/BankTransfer/Payload.php#L24)
- [`toBankAccount(string $accountId): Sujip\Xero\Accounting\BankTransfer\Payload`](../../src/Accounting/BankTransfer/Payload.php#L32)
- [`amount(int\|float $amount): Sujip\Xero\Accounting\BankTransfer\Payload`](../../src/Accounting/BankTransfer/Payload.php#L40)
- [`date(string $date): Sujip\Xero\Accounting\BankTransfer\Payload`](../../src/Accounting/BankTransfer/Payload.php#L48)
- [`reference(string $reference): Sujip\Xero\Accounting\BankTransfer\Payload`](../../src/Accounting/BankTransfer/Payload.php#L56)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\BankTransfer\Payload`](../../src/Accounting/BankTransfer/Payload.php#L64)
- [`save(): Sujip\Xero\Accounting\BankTransfer\BankTransfer`](../../src/Accounting/BankTransfer/Payload.php#L72)

## Accounting\BatchPayment\BatchPayment

[Source](../../src/Accounting/BatchPayment/BatchPayment.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `BatchPaymentID` | string or null | `()` |
| `Reference` | string or null | `()` |
| `Status` | string or null | `()` |
| `Amount` | int, float, or null | `()` |
| `Account` | object or null ([Accounting\Account\Account](accounting.md#accountingaccountaccount)) | `()` |
| `Payments` | list of objects ([Accounting\BatchPayment\PaymentEntry](accounting.md#accountingbatchpaymentpaymententry)) | `()` |
| `Particulars` | string or null | `()` |
| `Code` | string or null | `()` |
| `Details` | string or null | `()` |
| `Narrative` | string or null | `()` |
| `DateString` | string or null | `()` |
| `Date` | string or null | `()` |
| `Type` | string or null | `()` |
| `TotalAmount` | int, float, or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `IsReconciled` | bool or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/BatchPayment/BatchPayment.php#L18)
- [`getBatchPaymentID(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L63)
- [`setBatchPaymentID(?string $batchPaymentID): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L68)
- [`getReference(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L75)
- [`setReference(?string $reference): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L80)
- [`getStatus(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L87)
- [`setStatus(?string $status): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L92)
- [`getAmount(): int\|float\|null`](../../src/Accounting/BatchPayment/BatchPayment.php#L99)
- [`setAmount(int\|float\|null $amount): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L104)
- [`getAccount(): ?\Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/BatchPayment/BatchPayment.php#L111)
- [`setAccount(?\Sujip\Xero\Accounting\Account\Account $account): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L116)
- [`getPayments(): array`](../../src/Accounting/BatchPayment/BatchPayment.php#L126)
- [`setPayments(array $payments): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L134)
- [`addPayment(\Sujip\Xero\Accounting\BatchPayment\PaymentEntry $payment): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L141)
- [`getParticulars(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L148)
- [`setParticulars(?string $particulars): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L153)
- [`getCode(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L160)
- [`setCode(?string $code): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L165)
- [`getDetails(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L172)
- [`setDetails(?string $details): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L177)
- [`getNarrative(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L184)
- [`setNarrative(?string $narrative): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L189)
- [`getDateString(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L196)
- [`setDateString(?string $dateString): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L201)
- [`getDate(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L208)
- [`setDate(?string $date): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L213)
- [`getType(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L220)
- [`setType(?string $type): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L225)
- [`getTotalAmount(): int\|float\|null`](../../src/Accounting/BatchPayment/BatchPayment.php#L232)
- [`setTotalAmount(int\|float\|null $totalAmount): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L237)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/BatchPayment/BatchPayment.php#L244)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L249)
- [`getIsReconciled(): ?bool`](../../src/Accounting/BatchPayment/BatchPayment.php#L256)
- [`setIsReconciled(?bool $isReconciled): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L261)
- [`getValidationErrors(): array`](../../src/Accounting/BatchPayment/BatchPayment.php#L271)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayment.php#L276)
- [`toRequest(): array`](../../src/Accounting/BatchPayment/BatchPayment.php#L321)
- [`history(): Sujip\Xero\Accounting\History`](../../src/Accounting/BatchPayment/BatchPayment.php#L341)

## Accounting\BatchPayment\BatchPayments

[Source](../../src/Accounting/BatchPayment/BatchPayments.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/BatchPayment/BatchPayments.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/BatchPayment/BatchPayments.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/BatchPayment/BatchPayments.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/BatchPayment/BatchPayments.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/BatchPayment/BatchPayments.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/BatchPayment/BatchPayments.php#L30)
- [`ids(string ...$ids): static`](../../src/Accounting/BatchPayment/BatchPayments.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\BatchPayment\BatchPayments`](../../src/Accounting/BatchPayment/BatchPayments.php#L38)
- [`unitDp(int $unitDp): static`](../../src/Accounting/BatchPayment/BatchPayments.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/BatchPayment/BatchPayments.php#L49)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/BatchPayment/BatchPayments.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/BatchPayment/BatchPayments.php#L69)
- [`find(string $batchPaymentId): ?\Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayments.php#L81)
- [`create(): Sujip\Xero\Accounting\BatchPayment\Payload`](../../src/Accounting/BatchPayment/BatchPayments.php#L93)
- [`history(string $batchPaymentId): Sujip\Xero\Accounting\History`](../../src/Accounting/BatchPayment/BatchPayments.php#L98)
- [`mapBatchPayment(array $payload): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/BatchPayments.php#L106)
- [`mapPaymentEntry(array $payload): Sujip\Xero\Accounting\BatchPayment\PaymentEntry`](../../src/Accounting/BatchPayment/BatchPayments.php#L114)

## Accounting\BatchPayment\Payload

[Source](../../src/Accounting/BatchPayment/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/BatchPayment/Payload.php#L15)
- [`account(string $accountId): Sujip\Xero\Accounting\BatchPayment\Payload`](../../src/Accounting/BatchPayment/Payload.php#L21)
- [`reference(string $reference): Sujip\Xero\Accounting\BatchPayment\Payload`](../../src/Accounting/BatchPayment/Payload.php#L33)
- [`payment(string $invoiceId, int\|float $amount): Sujip\Xero\Accounting\BatchPayment\Payload`](../../src/Accounting/BatchPayment/Payload.php#L42)
- [`using(\Sujip\Xero\Accounting\BatchPayment\BatchPayment $batchPayment): Sujip\Xero\Accounting\BatchPayment\Payload`](../../src/Accounting/BatchPayment/Payload.php#L55)
- [`save(): Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/BatchPayment/Payload.php#L63)

## Accounting\BatchPayment\PaymentEntry

[Source](../../src/Accounting/BatchPayment/PaymentEntry.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Amount` | int, float, or null | `()` |

### Public methods

- [`getInvoiceID(): ?string`](../../src/Accounting/BatchPayment/PaymentEntry.php#L17)
- [`setInvoiceID(?string $invoiceID): Sujip\Xero\Accounting\BatchPayment\PaymentEntry`](../../src/Accounting/BatchPayment/PaymentEntry.php#L22)
- [`getAmount(): int\|float\|null`](../../src/Accounting/BatchPayment/PaymentEntry.php#L29)
- [`setAmount(int\|float\|null $amount): Sujip\Xero\Accounting\BatchPayment\PaymentEntry`](../../src/Accounting/BatchPayment/PaymentEntry.php#L34)
- [`fill(array $payload): static`](../../src/Accounting/BatchPayment/PaymentEntry.php#L51)
- [`toRequest(): array`](../../src/Accounting/BatchPayment/PaymentEntry.php#L66)

## Accounting\BrandingTheme\BrandingTheme

[Source](../../src/Accounting/BrandingTheme/BrandingTheme.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `BrandingThemeID` | string or null | `()` |
| `Name` | string or null | `()` |
| `LogoUrl` | string or null | `()` |
| `Type` | string or null | `()` |
| `SortOrder` | int, float, or null | `()` |
| `CreatedDateUTC` | string or null | `()` |

### Public methods

- [`getBrandingThemeID(): ?string`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L24)
- [`setBrandingThemeID(?string $brandingThemeID): Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L29)
- [`getName(): ?string`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L36)
- [`setName(?string $name): Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L41)
- [`getLogoUrl(): ?string`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L48)
- [`setLogoUrl(?string $logoUrl): Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L53)
- [`getType(): ?string`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L60)
- [`setType(?string $type): Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L65)
- [`getSortOrder(): ?int`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L72)
- [`setSortOrder(?int $sortOrder): Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L77)
- [`getCreatedDateUTC(): ?string`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L84)
- [`setCreatedDateUTC(?string $createdDateUTC): Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/BrandingTheme/BrandingTheme.php#L89)

## Accounting\BrandingTheme\BrandingThemes

[Source](../../src/Accounting/BrandingTheme/BrandingThemes.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/BrandingTheme/BrandingThemes.php#L16)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/BrandingTheme/BrandingThemes.php#L21)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/BrandingTheme/BrandingThemes.php#L32)
- [`find(string $brandingThemeId): ?\Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/BrandingTheme/BrandingThemes.php#L47)
- [`paymentServices(string $brandingThemeId): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/BrandingTheme/BrandingThemes.php#L62)
- [`applyPaymentService(string $brandingThemeId, string $paymentServiceId, ?string $idempotencyKey = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/BrandingTheme/BrandingThemes.php#L75)
- [`mapBrandingTheme(array $payload): Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/BrandingTheme/BrandingThemes.php#L94)

## Accounting\Budget\Budget

[Source](../../src/Accounting/Budget/Budget.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `BudgetID` | string or null | `setBudgetID()` |
| `Status` | string or null | `setStatus()` |
| `Type` | string or null | `setType()` |
| `Description` | string or null | `setDescription()` |
| `UpdatedDateUTC` | string or null | `setUpdatedDateUTC()` |
| `BudgetLines` | list of objects ([Accounting\Budget\BudgetLine](accounting.md#accountingbudgetbudgetline)) | `addBudgetLine()` |
| `Tracking` | list of objects ([Accounting\TrackingCategory\TrackingCategory](accounting.md#accountingtrackingcategorytrackingcategory)) | `addTracking()` |

### Public methods

- [`getBudgetID(): ?string`](../../src/Accounting/Budget/Budget.php#L29)
- [`setBudgetID(?string $budgetID): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L34)
- [`getStatus(): ?string`](../../src/Accounting/Budget/Budget.php#L41)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L46)
- [`getType(): ?string`](../../src/Accounting/Budget/Budget.php#L53)
- [`setType(?string $type): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L58)
- [`getDescription(): ?string`](../../src/Accounting/Budget/Budget.php#L65)
- [`setDescription(?string $description): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L70)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Budget/Budget.php#L77)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L82)
- [`getBudgetLines(): array`](../../src/Accounting/Budget/Budget.php#L92)
- [`setBudgetLines(array $budgetLines): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L100)
- [`addBudgetLine(\Sujip\Xero\Accounting\Budget\BudgetLine $budgetLine): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L107)
- [`getTracking(): array`](../../src/Accounting/Budget/Budget.php#L117)
- [`setTracking(array $tracking): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L125)
- [`addTracking(\Sujip\Xero\Accounting\TrackingCategory\TrackingCategory $tracking): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budget.php#L132)

## Accounting\Budget\BudgetBalance

[Source](../../src/Accounting/Budget/BudgetBalance.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Period` | string or null | `setPeriod()` |
| `Amount` | int, float, or null | `setAmount()` |
| `UnitAmount` | int, float, or null | `setUnitAmount()` |
| `Notes` | string or null | `setNotes()` |

### Public methods

- [`getPeriod(): ?string`](../../src/Accounting/Budget/BudgetBalance.php#L17)
- [`setPeriod(?string $period): Sujip\Xero\Accounting\Budget\BudgetBalance`](../../src/Accounting/Budget/BudgetBalance.php#L22)
- [`getAmount(): ?float`](../../src/Accounting/Budget/BudgetBalance.php#L29)
- [`setAmount(?float $amount): Sujip\Xero\Accounting\Budget\BudgetBalance`](../../src/Accounting/Budget/BudgetBalance.php#L34)
- [`getUnitAmount(): ?float`](../../src/Accounting/Budget/BudgetBalance.php#L41)
- [`setUnitAmount(?float $unitAmount): Sujip\Xero\Accounting\Budget\BudgetBalance`](../../src/Accounting/Budget/BudgetBalance.php#L46)
- [`getNotes(): ?string`](../../src/Accounting/Budget/BudgetBalance.php#L53)
- [`setNotes(?string $notes): Sujip\Xero\Accounting\Budget\BudgetBalance`](../../src/Accounting/Budget/BudgetBalance.php#L58)

## Accounting\Budget\BudgetLine

[Source](../../src/Accounting/Budget/BudgetLine.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AccountID` | string or null | `setAccountID()` |
| `AccountCode` | string or null | `setAccountCode()` |
| `BudgetBalances` | list of objects ([Accounting\Budget\BudgetBalance](accounting.md#accountingbudgetbudgetbalance)) | `addBudgetBalance()` |

### Public methods

- [`getAccountID(): ?string`](../../src/Accounting/Budget/BudgetLine.php#L20)
- [`setAccountID(?string $accountID): Sujip\Xero\Accounting\Budget\BudgetLine`](../../src/Accounting/Budget/BudgetLine.php#L25)
- [`getAccountCode(): ?string`](../../src/Accounting/Budget/BudgetLine.php#L32)
- [`setAccountCode(?string $accountCode): Sujip\Xero\Accounting\Budget\BudgetLine`](../../src/Accounting/Budget/BudgetLine.php#L37)
- [`getBudgetBalances(): array`](../../src/Accounting/Budget/BudgetLine.php#L47)
- [`setBudgetBalances(array $budgetBalances): Sujip\Xero\Accounting\Budget\BudgetLine`](../../src/Accounting/Budget/BudgetLine.php#L55)
- [`addBudgetBalance(\Sujip\Xero\Accounting\Budget\BudgetBalance $budgetBalance): Sujip\Xero\Accounting\Budget\BudgetLine`](../../src/Accounting/Budget/BudgetLine.php#L62)

## Accounting\Budget\Budgets

[Source](../../src/Accounting/Budget/Budgets.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Budget/Budgets.php#L18)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Budget/Budgets.php#L19)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Budget/Budgets.php#L23)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Budget/Budgets.php#L27)
- [`dateFrom(string $date): Sujip\Xero\Accounting\Budget\Budgets`](../../src/Accounting/Budget/Budgets.php#L31)
- [`ids(string ...$ids): static`](../../src/Accounting/Budget/Budgets.php#L35)
- [`dateTo(string $date): Sujip\Xero\Accounting\Budget\Budgets`](../../src/Accounting/Budget/Budgets.php#L39)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Budget/Budgets.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Budget/Budgets.php#L50)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Budget/Budgets.php#L51)
- [`find(string $budgetId): ?\Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budgets.php#L67)
- [`mapBudget(array $budget): Sujip\Xero\Accounting\Budget\Budget`](../../src/Accounting/Budget/Budgets.php#L84)

## Accounting\ContactGroup\ContactAssignments

[Source](../../src/Accounting/ContactGroup/ContactAssignments.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $contactGroupId)`](../../src/Accounting/ContactGroup/ContactAssignments.php#L12)
- [`attach(string ...$contactIds): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactAssignments.php#L18)
- [`remove(string $contactId): bool`](../../src/Accounting/ContactGroup/ContactAssignments.php#L37)

## Accounting\ContactGroup\ContactGroup

[Source](../../src/Accounting/ContactGroup/ContactGroup.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `ContactGroupID` | string or null | `()` |
| `Name` | string or null | `()` |
| `Status` | string or null | `()` |
| `Contacts` | list of objects ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/ContactGroup/ContactGroup.php#L31)
- [`getContactGroupID(): ?string`](../../src/Accounting/ContactGroup/ContactGroup.php#L36)
- [`setContactGroupID(?string $contactGroupID): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L41)
- [`getName(): ?string`](../../src/Accounting/ContactGroup/ContactGroup.php#L48)
- [`setName(?string $name): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L53)
- [`getStatus(): ?string`](../../src/Accounting/ContactGroup/ContactGroup.php#L60)
- [`setStatus(?string $status): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L65)
- [`getContactIDs(): array`](../../src/Accounting/ContactGroup/ContactGroup.php#L75)
- [`setContactIDs(array $contactIDs): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L83)
- [`addContactID(string $contactID): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L90)
- [`getContacts(): array`](../../src/Accounting/ContactGroup/ContactGroup.php#L100)
- [`addContact(\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L105)
- [`fill(array $payload): static`](../../src/Accounting/ContactGroup/ContactGroup.php#L125)
- [`name(string $name): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L140)
- [`save(): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L145)
- [`contacts(): Sujip\Xero\Accounting\ContactGroup\ContactAssignments`](../../src/Accounting/ContactGroup/ContactGroup.php#L168)
- [`attachContacts(string ...$contactIds): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroup.php#L177)
- [`removeContact(string $contactId): bool`](../../src/Accounting/ContactGroup/ContactGroup.php#L182)

## Accounting\ContactGroup\ContactGroups

[Source](../../src/Accounting/ContactGroup/ContactGroups.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/ContactGroup/ContactGroups.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/ContactGroup/ContactGroups.php#L20)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/ContactGroup/ContactGroups.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/ContactGroup/ContactGroups.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\ContactGroup\ContactGroups`](../../src/Accounting/ContactGroup/ContactGroups.php#L33)
- [`ids(string ...$ids): static`](../../src/Accounting/ContactGroup/ContactGroups.php#L35)
- [`unitDp(int $unitDp): static`](../../src/Accounting/ContactGroup/ContactGroups.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/ContactGroup/ContactGroups.php#L44)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/ContactGroup/ContactGroups.php#L51)
- [`find(string $contactGroupId): ?\Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroups.php#L61)
- [`create(): Sujip\Xero\Accounting\ContactGroup\Payload`](../../src/Accounting/ContactGroup/ContactGroups.php#L74)
- [`update(string $contactGroupId): Sujip\Xero\Accounting\ContactGroup\Payload`](../../src/Accounting/ContactGroup/ContactGroups.php#L79)
- [`contacts(string $contactGroupId): Sujip\Xero\Accounting\ContactGroup\ContactAssignments`](../../src/Accounting/ContactGroup/ContactGroups.php#L84)
- [`mapContactGroup(array $payload): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/ContactGroups.php#L92)

## Accounting\ContactGroup\Payload

[Source](../../src/Accounting/ContactGroup/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/ContactGroup/Payload.php#L19)
- [`id(string $contactGroupId): Sujip\Xero\Accounting\ContactGroup\Payload`](../../src/Accounting/ContactGroup/Payload.php#L24)
- [`name(string $name): Sujip\Xero\Accounting\ContactGroup\Payload`](../../src/Accounting/ContactGroup/Payload.php#L32)
- [`status(string $status): Sujip\Xero\Accounting\ContactGroup\Payload`](../../src/Accounting/ContactGroup/Payload.php#L40)
- [`contact(string $contactId): Sujip\Xero\Accounting\ContactGroup\Payload`](../../src/Accounting/ContactGroup/Payload.php#L48)
- [`save(): Sujip\Xero\Accounting\ContactGroup\ContactGroup`](../../src/Accounting/ContactGroup/Payload.php#L58)

## Accounting\Contact\AccountBalance

[Source](../../src/Accounting/Contact/AccountBalance.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Outstanding` | int, float, or null | `()` |
| `Overdue` | int, float, or null | `()` |

### Public methods

- [`getOutstanding(): int\|float\|null`](../../src/Accounting/Contact/AccountBalance.php#L16)
- [`setOutstanding(int\|float\|null $outstanding): Sujip\Xero\Accounting\Contact\AccountBalance`](../../src/Accounting/Contact/AccountBalance.php#L21)
- [`getOverdue(): int\|float\|null`](../../src/Accounting/Contact/AccountBalance.php#L28)
- [`setOverdue(int\|float\|null $overdue): Sujip\Xero\Accounting\Contact\AccountBalance`](../../src/Accounting/Contact/AccountBalance.php#L33)

## Accounting\Contact\Address

[Source](../../src/Accounting/Contact/Address.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AddressType` | string or null | `()` |
| `AddressLine1` | string or null | `()` |
| `AddressLine2` | string or null | `()` |
| `AddressLine3` | string or null | `()` |
| `AddressLine4` | string or null | `()` |
| `City` | string or null | `()` |
| `Region` | string or null | `()` |
| `PostalCode` | string or null | `()` |
| `Country` | string or null | `()` |
| `AttentionTo` | string or null | `()` |

### Public methods

- [`getAddressType(): ?string`](../../src/Accounting/Contact/Address.php#L33)
- [`setAddressType(?string $addressType): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L38)
- [`getAddressLine1(): ?string`](../../src/Accounting/Contact/Address.php#L45)
- [`setAddressLine1(?string $addressLine1): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L50)
- [`getAddressLine2(): ?string`](../../src/Accounting/Contact/Address.php#L57)
- [`setAddressLine2(?string $addressLine2): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L62)
- [`getAddressLine3(): ?string`](../../src/Accounting/Contact/Address.php#L69)
- [`setAddressLine3(?string $addressLine3): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L74)
- [`getAddressLine4(): ?string`](../../src/Accounting/Contact/Address.php#L81)
- [`setAddressLine4(?string $addressLine4): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L86)
- [`getCity(): ?string`](../../src/Accounting/Contact/Address.php#L93)
- [`setCity(?string $city): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L98)
- [`getRegion(): ?string`](../../src/Accounting/Contact/Address.php#L105)
- [`setRegion(?string $region): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L110)
- [`getPostalCode(): ?string`](../../src/Accounting/Contact/Address.php#L117)
- [`setPostalCode(?string $postalCode): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L122)
- [`getCountry(): ?string`](../../src/Accounting/Contact/Address.php#L129)
- [`setCountry(?string $country): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L134)
- [`getAttentionTo(): ?string`](../../src/Accounting/Contact/Address.php#L141)
- [`setAttentionTo(?string $attentionTo): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Address.php#L146)
- [`toRequest(): array`](../../src/Accounting/Contact/Address.php#L175)

## Accounting\Contact\Balances

[Source](../../src/Accounting/Contact/Balances.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AccountsReceivable` | object or null ([Accounting\Contact\AccountBalance](accounting.md#accountingcontactaccountbalance)) | `()` |
| `AccountsPayable` | object or null ([Accounting\Contact\AccountBalance](accounting.md#accountingcontactaccountbalance)) | `()` |

### Public methods

- [`getAccountsReceivable(): ?\Sujip\Xero\Accounting\Contact\AccountBalance`](../../src/Accounting/Contact/Balances.php#L16)
- [`setAccountsReceivable(?\Sujip\Xero\Accounting\Contact\AccountBalance $accountsReceivable): Sujip\Xero\Accounting\Contact\Balances`](../../src/Accounting/Contact/Balances.php#L21)
- [`getAccountsPayable(): ?\Sujip\Xero\Accounting\Contact\AccountBalance`](../../src/Accounting/Contact/Balances.php#L28)
- [`setAccountsPayable(?\Sujip\Xero\Accounting\Contact\AccountBalance $accountsPayable): Sujip\Xero\Accounting\Contact\Balances`](../../src/Accounting/Contact/Balances.php#L33)

## Accounting\Contact\BatchPaymentDetails

[Source](../../src/Accounting/Contact/BatchPaymentDetails.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `BankAccountNumber` | string or null | `()` |
| `BankAccountName` | string or null | `()` |
| `Details` | string or null | `()` |
| `Code` | string or null | `()` |
| `Reference` | string or null | `()` |

### Public methods

- [`getBankAccountNumber(): ?string`](../../src/Accounting/Contact/BatchPaymentDetails.php#L23)
- [`setBankAccountNumber(?string $bankAccountNumber): Sujip\Xero\Accounting\Contact\BatchPaymentDetails`](../../src/Accounting/Contact/BatchPaymentDetails.php#L28)
- [`getBankAccountName(): ?string`](../../src/Accounting/Contact/BatchPaymentDetails.php#L35)
- [`setBankAccountName(?string $bankAccountName): Sujip\Xero\Accounting\Contact\BatchPaymentDetails`](../../src/Accounting/Contact/BatchPaymentDetails.php#L40)
- [`getDetails(): ?string`](../../src/Accounting/Contact/BatchPaymentDetails.php#L47)
- [`setDetails(?string $details): Sujip\Xero\Accounting\Contact\BatchPaymentDetails`](../../src/Accounting/Contact/BatchPaymentDetails.php#L52)
- [`getCode(): ?string`](../../src/Accounting/Contact/BatchPaymentDetails.php#L59)
- [`setCode(?string $code): Sujip\Xero\Accounting\Contact\BatchPaymentDetails`](../../src/Accounting/Contact/BatchPaymentDetails.php#L64)
- [`getReference(): ?string`](../../src/Accounting/Contact/BatchPaymentDetails.php#L71)
- [`setReference(?string $reference): Sujip\Xero\Accounting\Contact\BatchPaymentDetails`](../../src/Accounting/Contact/BatchPaymentDetails.php#L76)
- [`toRequest(): array`](../../src/Accounting/Contact/BatchPaymentDetails.php#L100)

## Accounting\Contact\CisSetting

[Source](../../src/Accounting/Contact/CisSetting.php)

### Public methods

- [`__construct(?bool $cisEnabled, ?float $rate, array $raw = array (
))`](../../src/Accounting/Contact/CisSetting.php#L12)

## Accounting\Contact\Contact

[Source](../../src/Accounting/Contact/Contact.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `ContactID` | string or null | `()` |
| `Name` | string or null | `()` |
| `FirstName` | string or null | `()` |
| `LastName` | string or null | `()` |
| `EmailAddress` | string or null | `()` |
| `Addresses` | list of objects ([Accounting\Contact\Address](accounting.md#accountingcontactaddress)) | `()` |
| `Phones` | list of objects ([Accounting\Contact\Phone](accounting.md#accountingcontactphone)) | `()` |
| `MergedToContactID` | string or null | `()` |
| `ContactNumber` | string or null | `()` |
| `AccountNumber` | string or null | `()` |
| `ContactStatus` | string or null | `()` |
| `CompanyNumber` | string or null | `()` |
| `ContactPersons` | list of objects ([Accounting\Contact\ContactPerson](accounting.md#accountingcontactcontactperson)) | `()` |
| `BankAccountDetails` | string or null | `()` |
| `TaxNumber` | string or null | `()` |
| `TaxNumberType` | string or null | `()` |
| `AccountsReceivableTaxType` | string or null | `()` |
| `AccountsPayableTaxType` | string or null | `()` |
| `IsSupplier` | bool or null | `()` |
| `IsCustomer` | bool or null | `()` |
| `SalesDefaultLineAmountType` | string or null | `()` |
| `PurchasesDefaultLineAmountType` | string or null | `()` |
| `DefaultCurrency` | string or null | `()` |
| `XeroNetworkKey` | string or null | `()` |
| `SalesDefaultAccountCode` | string or null | `()` |
| `PurchasesDefaultAccountCode` | string or null | `()` |
| `SalesTrackingCategories` | list of objects ([Accounting\Contact\SalesTrackingCategory](accounting.md#accountingcontactsalestrackingcategory)) | `()` |
| `PurchasesTrackingCategories` | list of objects ([Accounting\Contact\SalesTrackingCategory](accounting.md#accountingcontactsalestrackingcategory)) | `()` |
| `TrackingCategoryName` | string or null | `()` |
| `TrackingCategoryOption` | string or null | `()` |
| `PaymentTerms` | object or null ([Accounting\Organisation\PaymentTerm](accounting.md#accountingorganisationpaymentterm)) | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `ContactGroups` | list of objects ([Accounting\ContactGroup\ContactGroup](accounting.md#accountingcontactgroupcontactgroup)) | `()` |
| `Website` | string or null | `()` |
| `BrandingTheme` | object or null ([Accounting\BrandingTheme\BrandingTheme](accounting.md#accountingbrandingthemebrandingtheme)) | `()` |
| `BatchPayments` | object or null ([Accounting\Contact\BatchPaymentDetails](accounting.md#accountingcontactbatchpaymentdetails)) | `()` |
| `Discount` | int, float, or null | `()` |
| `Balances` | object or null ([Accounting\Contact\Balances](accounting.md#accountingcontactbalances)) | `()` |
| `Attachments` | list of objects ([Support\AttachmentDetail](support.md#supportattachmentdetail)) | `()` |
| `HasAttachments` | bool or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `HasValidationErrors` | bool or null | `()` |
| `StatusAttributeString` | string or null | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Contact/Contact.php#L130)
- [`getContactID(): ?string`](../../src/Accounting/Contact/Contact.php#L135)
- [`setContactID(?string $contactID): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L140)
- [`getName(): ?string`](../../src/Accounting/Contact/Contact.php#L147)
- [`setName(?string $name): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L152)
- [`getFirstName(): ?string`](../../src/Accounting/Contact/Contact.php#L159)
- [`setFirstName(?string $firstName): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L164)
- [`getLastName(): ?string`](../../src/Accounting/Contact/Contact.php#L171)
- [`setLastName(?string $lastName): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L176)
- [`getEmailAddress(): ?string`](../../src/Accounting/Contact/Contact.php#L183)
- [`setEmailAddress(?string $emailAddress): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L188)
- [`getAddresses(): array`](../../src/Accounting/Contact/Contact.php#L198)
- [`setAddresses(array $addresses): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L206)
- [`addAddress(\Sujip\Xero\Accounting\Contact\Address $address): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L213)
- [`getPhones(): array`](../../src/Accounting/Contact/Contact.php#L223)
- [`setPhones(array $phones): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L231)
- [`addPhone(\Sujip\Xero\Accounting\Contact\Phone $phone): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L238)
- [`getMergedToContactID(): ?string`](../../src/Accounting/Contact/Contact.php#L245)
- [`setMergedToContactID(?string $mergedToContactID): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L250)
- [`getContactNumber(): ?string`](../../src/Accounting/Contact/Contact.php#L257)
- [`setContactNumber(?string $contactNumber): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L262)
- [`getAccountNumber(): ?string`](../../src/Accounting/Contact/Contact.php#L269)
- [`setAccountNumber(?string $accountNumber): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L274)
- [`getContactStatus(): ?string`](../../src/Accounting/Contact/Contact.php#L281)
- [`setContactStatus(?string $contactStatus): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L286)
- [`getCompanyNumber(): ?string`](../../src/Accounting/Contact/Contact.php#L293)
- [`setCompanyNumber(?string $companyNumber): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L298)
- [`getContactPersons(): array`](../../src/Accounting/Contact/Contact.php#L308)
- [`addContactPerson(\Sujip\Xero\Accounting\Contact\ContactPerson $contactPerson): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L313)
- [`getBankAccountDetails(): ?string`](../../src/Accounting/Contact/Contact.php#L320)
- [`setBankAccountDetails(?string $bankAccountDetails): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L325)
- [`getTaxNumber(): ?string`](../../src/Accounting/Contact/Contact.php#L332)
- [`setTaxNumber(?string $taxNumber): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L337)
- [`getTaxNumberType(): ?string`](../../src/Accounting/Contact/Contact.php#L344)
- [`setTaxNumberType(?string $taxNumberType): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L349)
- [`getAccountsReceivableTaxType(): ?string`](../../src/Accounting/Contact/Contact.php#L356)
- [`setAccountsReceivableTaxType(?string $accountsReceivableTaxType): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L361)
- [`getAccountsPayableTaxType(): ?string`](../../src/Accounting/Contact/Contact.php#L368)
- [`setAccountsPayableTaxType(?string $accountsPayableTaxType): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L373)
- [`getIsSupplier(): ?bool`](../../src/Accounting/Contact/Contact.php#L380)
- [`setIsSupplier(?bool $isSupplier): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L385)
- [`getIsCustomer(): ?bool`](../../src/Accounting/Contact/Contact.php#L392)
- [`setIsCustomer(?bool $isCustomer): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L397)
- [`getSalesDefaultLineAmountType(): ?string`](../../src/Accounting/Contact/Contact.php#L404)
- [`setSalesDefaultLineAmountType(?string $salesDefaultLineAmountType): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L409)
- [`getPurchasesDefaultLineAmountType(): ?string`](../../src/Accounting/Contact/Contact.php#L416)
- [`setPurchasesDefaultLineAmountType(?string $purchasesDefaultLineAmountType): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L421)
- [`getDefaultCurrency(): ?string`](../../src/Accounting/Contact/Contact.php#L428)
- [`setDefaultCurrency(?string $defaultCurrency): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L433)
- [`getXeroNetworkKey(): ?string`](../../src/Accounting/Contact/Contact.php#L440)
- [`setXeroNetworkKey(?string $xeroNetworkKey): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L445)
- [`getSalesDefaultAccountCode(): ?string`](../../src/Accounting/Contact/Contact.php#L452)
- [`setSalesDefaultAccountCode(?string $salesDefaultAccountCode): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L457)
- [`getPurchasesDefaultAccountCode(): ?string`](../../src/Accounting/Contact/Contact.php#L464)
- [`setPurchasesDefaultAccountCode(?string $purchasesDefaultAccountCode): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L469)
- [`getSalesTrackingCategories(): array`](../../src/Accounting/Contact/Contact.php#L479)
- [`addSalesTrackingCategory(\Sujip\Xero\Accounting\Contact\SalesTrackingCategory $salesTrackingCategory): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L484)
- [`getPurchasesTrackingCategories(): array`](../../src/Accounting/Contact/Contact.php#L494)
- [`addPurchasesTrackingCategory(\Sujip\Xero\Accounting\Contact\SalesTrackingCategory $purchasesTrackingCategory): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L499)
- [`getTrackingCategoryName(): ?string`](../../src/Accounting/Contact/Contact.php#L506)
- [`setTrackingCategoryName(?string $trackingCategoryName): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L511)
- [`getTrackingCategoryOption(): ?string`](../../src/Accounting/Contact/Contact.php#L518)
- [`setTrackingCategoryOption(?string $trackingCategoryOption): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L523)
- [`getPaymentTerms(): ?\Sujip\Xero\Accounting\Organisation\PaymentTerm`](../../src/Accounting/Contact/Contact.php#L530)
- [`setPaymentTerms(?\Sujip\Xero\Accounting\Organisation\PaymentTerm $paymentTerms): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L535)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Contact/Contact.php#L542)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L547)
- [`getContactGroups(): array`](../../src/Accounting/Contact/Contact.php#L557)
- [`addContactGroup(\Sujip\Xero\Accounting\ContactGroup\ContactGroup $contactGroup): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L562)
- [`getWebsite(): ?string`](../../src/Accounting/Contact/Contact.php#L569)
- [`setWebsite(?string $website): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L574)
- [`getBrandingTheme(): ?\Sujip\Xero\Accounting\BrandingTheme\BrandingTheme`](../../src/Accounting/Contact/Contact.php#L581)
- [`setBrandingTheme(?\Sujip\Xero\Accounting\BrandingTheme\BrandingTheme $brandingTheme): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L586)
- [`getBatchPayments(): ?\Sujip\Xero\Accounting\Contact\BatchPaymentDetails`](../../src/Accounting/Contact/Contact.php#L593)
- [`setBatchPayments(?\Sujip\Xero\Accounting\Contact\BatchPaymentDetails $batchPayments): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L598)
- [`getDiscount(): int\|float\|null`](../../src/Accounting/Contact/Contact.php#L605)
- [`setDiscount(int\|float\|null $discount): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L610)
- [`getBalances(): ?\Sujip\Xero\Accounting\Contact\Balances`](../../src/Accounting/Contact/Contact.php#L617)
- [`setBalances(?\Sujip\Xero\Accounting\Contact\Balances $balances): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L622)
- [`getAttachments(): array`](../../src/Accounting/Contact/Contact.php#L632)
- [`addAttachment(\Sujip\Xero\Support\AttachmentDetail $attachment): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L637)
- [`getHasAttachments(): ?bool`](../../src/Accounting/Contact/Contact.php#L644)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L649)
- [`getValidationErrors(): array`](../../src/Accounting/Contact/Contact.php#L659)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L664)
- [`getHasValidationErrors(): ?bool`](../../src/Accounting/Contact/Contact.php#L671)
- [`setHasValidationErrors(?bool $hasValidationErrors): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L676)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/Contact/Contact.php#L683)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L688)
- [`toRequest(): array`](../../src/Accounting/Contact/Contact.php#L759)
- [`save(): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contact.php#L805)

## Accounting\Contact\ContactPerson

[Source](../../src/Accounting/Contact/ContactPerson.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `FirstName` | string or null | `()` |
| `LastName` | string or null | `()` |
| `EmailAddress` | string or null | `()` |
| `IncludeInEmails` | bool or null | `()` |

### Public methods

- [`getFirstName(): ?string`](../../src/Accounting/Contact/ContactPerson.php#L21)
- [`setFirstName(?string $firstName): Sujip\Xero\Accounting\Contact\ContactPerson`](../../src/Accounting/Contact/ContactPerson.php#L26)
- [`getLastName(): ?string`](../../src/Accounting/Contact/ContactPerson.php#L33)
- [`setLastName(?string $lastName): Sujip\Xero\Accounting\Contact\ContactPerson`](../../src/Accounting/Contact/ContactPerson.php#L38)
- [`getEmailAddress(): ?string`](../../src/Accounting/Contact/ContactPerson.php#L45)
- [`setEmailAddress(?string $emailAddress): Sujip\Xero\Accounting\Contact\ContactPerson`](../../src/Accounting/Contact/ContactPerson.php#L50)
- [`getIncludeInEmails(): ?bool`](../../src/Accounting/Contact/ContactPerson.php#L57)
- [`setIncludeInEmails(?bool $includeInEmails): Sujip\Xero\Accounting\Contact\ContactPerson`](../../src/Accounting/Contact/ContactPerson.php#L62)
- [`toRequest(): array`](../../src/Accounting/Contact/ContactPerson.php#L85)

## Accounting\Contact\Contacts

[Source](../../src/Accounting/Contact/Contacts.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/Contact/Contacts.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Contact/Contacts.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/Contact/Contacts.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Contact/Contacts.php#L26)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Contact/Contacts.php#L31)
- [`ids(string ...$ids): static`](../../src/Accounting/Contact/Contacts.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Contact\Contacts`](../../src/Accounting/Contact/Contacts.php#L39)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Contact/Contacts.php#L43)
- [`orderBy(string $field, string $direction = 'ASC'): Sujip\Xero\Accounting\Contact\Contacts`](../../src/Accounting/Contact/Contacts.php#L47)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Contact/Contacts.php#L51)
- [`includeArchived(bool $includeArchived = true): Sujip\Xero\Accounting\Contact\Contacts`](../../src/Accounting/Contact/Contacts.php#L55)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Contact/Contacts.php#L66)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/Contact/Contacts.php#L86)
- [`find(string $contactId): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contacts.php#L110)
- [`create(): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Contacts.php#L122)
- [`update(string $contactId): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Contacts.php#L127)
- [`history(string $contactId): Sujip\Xero\Accounting\History`](../../src/Accounting/Contact/Contacts.php#L132)
- [`attachments(string $contactId): Sujip\Xero\Accounting\Attachments`](../../src/Accounting/Contact/Contacts.php#L137)
- [`cisSettings(string $contactId): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Contact/Contacts.php#L145)
- [`mapContact(array $payload): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Contacts.php#L174)
- [`mapAddress(array $payload): Sujip\Xero\Accounting\Contact\Address`](../../src/Accounting/Contact/Contacts.php#L182)
- [`mapPhone(array $payload): Sujip\Xero\Accounting\Contact\Phone`](../../src/Accounting/Contact/Contacts.php#L190)

## Accounting\Contact\Payload

[Source](../../src/Accounting/Contact/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Contact/Payload.php#L14)
- [`setName(?string $name): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L20)
- [`setFirstName(?string $firstName): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L29)
- [`setLastName(?string $lastName): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L38)
- [`setEmailAddress(?string $emailAddress): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L47)
- [`setContactID(?string $contactID): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L56)
- [`name(string $name): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L65)
- [`firstName(string $firstName): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L70)
- [`lastName(string $lastName): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L75)
- [`email(string $email): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L80)
- [`id(string $contactId): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L85)
- [`using(\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\Contact\Payload`](../../src/Accounting/Contact/Payload.php#L90)
- [`save(): Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Contact/Payload.php#L98)

## Accounting\Contact\Phone

[Source](../../src/Accounting/Contact/Phone.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PhoneType` | string or null | `()` |
| `PhoneNumber` | string or null | `()` |
| `PhoneAreaCode` | string or null | `()` |
| `PhoneCountryCode` | string or null | `()` |

### Public methods

- [`getPhoneType(): ?string`](../../src/Accounting/Contact/Phone.php#L21)
- [`setPhoneType(?string $phoneType): Sujip\Xero\Accounting\Contact\Phone`](../../src/Accounting/Contact/Phone.php#L26)
- [`getPhoneNumber(): ?string`](../../src/Accounting/Contact/Phone.php#L33)
- [`setPhoneNumber(?string $phoneNumber): Sujip\Xero\Accounting\Contact\Phone`](../../src/Accounting/Contact/Phone.php#L38)
- [`getPhoneAreaCode(): ?string`](../../src/Accounting/Contact/Phone.php#L45)
- [`setPhoneAreaCode(?string $phoneAreaCode): Sujip\Xero\Accounting\Contact\Phone`](../../src/Accounting/Contact/Phone.php#L50)
- [`getPhoneCountryCode(): ?string`](../../src/Accounting/Contact/Phone.php#L57)
- [`setPhoneCountryCode(?string $phoneCountryCode): Sujip\Xero\Accounting\Contact\Phone`](../../src/Accounting/Contact/Phone.php#L62)
- [`toRequest(): array`](../../src/Accounting/Contact/Phone.php#L85)

## Accounting\Contact\SalesTrackingCategory

[Source](../../src/Accounting/Contact/SalesTrackingCategory.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `TrackingCategoryName` | string or null | `()` |
| `TrackingOptionName` | string or null | `()` |

### Public methods

- [`getTrackingCategoryName(): ?string`](../../src/Accounting/Contact/SalesTrackingCategory.php#L17)
- [`setTrackingCategoryName(?string $trackingCategoryName): Sujip\Xero\Accounting\Contact\SalesTrackingCategory`](../../src/Accounting/Contact/SalesTrackingCategory.php#L22)
- [`getTrackingOptionName(): ?string`](../../src/Accounting/Contact/SalesTrackingCategory.php#L29)
- [`setTrackingOptionName(?string $trackingOptionName): Sujip\Xero\Accounting\Contact\SalesTrackingCategory`](../../src/Accounting/Contact/SalesTrackingCategory.php#L34)
- [`toRequest(): array`](../../src/Accounting/Contact/SalesTrackingCategory.php#L55)

## Accounting\CreditNote\Attachment

[Source](../../src/Accounting/CreditNote/Attachment.php)

### Public methods

- [`__construct(?string $id, ?string $fileName, ?string $mimeType, ?bool $includeOnline, array $raw = array (
))`](../../src/Accounting/CreditNote/Attachment.php#L12)

## Accounting\CreditNote\Attachments

[Source](../../src/Accounting/CreditNote/Attachments.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $creditNoteId)`](../../src/Accounting/CreditNote/Attachments.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/CreditNote/Attachments.php#L22)
- [`upload(string $fileName, string $content): Sujip\Xero\Accounting\CreditNote\Upload`](../../src/Accounting/CreditNote/Attachments.php#L43)
- [`download(string $fileName, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/CreditNote/Attachments.php#L48)
- [`downloadById(string $attachmentId, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/CreditNote/Attachments.php#L60)

## Accounting\CreditNote\CreditNote

[Source](../../src/Accounting/CreditNote/CreditNote.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `CreditNoteID` | string or null | `()` |
| `Type` | string or null | `()` |
| `Status` | string or null | `()` |
| `Reference` | string or null | `()` |
| `Total` | int, float, or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `Date` | string or null | `()` |
| `DueDate` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `CISDeduction` | int, float, or null | `()` |
| `CISRate` | int, float, or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `UpdatedDateUTCString` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `FullyPaidOnDate` | string or null | `()` |
| `CreditNoteNumber` | string or null | `()` |
| `SentToContact` | bool or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `RemainingCredit` | int, float, or null | `()` |
| `Allocations` | list of objects ([Accounting\Allocation](accounting.md#accountingallocation)) | `()` |
| `AppliedAmount` | int, float, or null | `()` |
| `Payments` | list of objects ([Accounting\Payment\Payment](accounting.md#accountingpaymentpayment)) | `()` |
| `BrandingThemeID` | string or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `HasErrors` | bool or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `Warnings` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `InvoiceAddresses` | list of objects ([Support\InvoiceAddress](support.md#supportinvoiceaddress)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/CreditNote/CreditNote.php#L21)
- [`getCreditNoteID(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L108)
- [`setCreditNoteID(?string $creditNoteID): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L113)
- [`getType(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L120)
- [`setType(?string $type): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L125)
- [`getStatus(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L132)
- [`setStatus(?string $status): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L137)
- [`getReference(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L144)
- [`setReference(?string $reference): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L149)
- [`getTotal(): int\|float\|null`](../../src/Accounting/CreditNote/CreditNote.php#L156)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L161)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/CreditNote/CreditNote.php#L168)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L173)
- [`getLineItems(): array`](../../src/Accounting/CreditNote/CreditNote.php#L183)
- [`setLineItems(array $lineItems): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L191)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L198)
- [`getDate(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L205)
- [`setDate(?string $date): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L210)
- [`getDueDate(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L217)
- [`setDueDate(?string $dueDate): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L222)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L229)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L234)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/CreditNote/CreditNote.php#L241)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L246)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/CreditNote/CreditNote.php#L253)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L258)
- [`getCISDeduction(): int\|float\|null`](../../src/Accounting/CreditNote/CreditNote.php#L265)
- [`setCISDeduction(int\|float\|null $cisDeduction): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L270)
- [`getCISRate(): int\|float\|null`](../../src/Accounting/CreditNote/CreditNote.php#L277)
- [`setCISRate(int\|float\|null $cisRate): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L282)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L289)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L294)
- [`getUpdatedDateUTCString(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L301)
- [`setUpdatedDateUTCString(?string $updatedDateUTCString): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L306)
- [`getCurrencyCode(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L313)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L318)
- [`getFullyPaidOnDate(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L325)
- [`setFullyPaidOnDate(?string $fullyPaidOnDate): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L330)
- [`getCreditNoteNumber(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L337)
- [`setCreditNoteNumber(?string $creditNoteNumber): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L342)
- [`getSentToContact(): ?bool`](../../src/Accounting/CreditNote/CreditNote.php#L349)
- [`setSentToContact(?bool $sentToContact): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L354)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/CreditNote/CreditNote.php#L361)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L366)
- [`getRemainingCredit(): int\|float\|null`](../../src/Accounting/CreditNote/CreditNote.php#L373)
- [`setRemainingCredit(int\|float\|null $remainingCredit): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L378)
- [`getAllocations(): array`](../../src/Accounting/CreditNote/CreditNote.php#L388)
- [`addAllocation(\Sujip\Xero\Accounting\Allocation $allocation): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L393)
- [`getAppliedAmount(): int\|float\|null`](../../src/Accounting/CreditNote/CreditNote.php#L400)
- [`setAppliedAmount(int\|float\|null $appliedAmount): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L405)
- [`getPayments(): array`](../../src/Accounting/CreditNote/CreditNote.php#L415)
- [`addPayment(\Sujip\Xero\Accounting\Payment\Payment $payment): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L420)
- [`getBrandingThemeID(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L427)
- [`setBrandingThemeID(?string $brandingThemeID): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L432)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/CreditNote/CreditNote.php#L439)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L444)
- [`getHasAttachments(): ?bool`](../../src/Accounting/CreditNote/CreditNote.php#L451)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L456)
- [`getHasErrors(): ?bool`](../../src/Accounting/CreditNote/CreditNote.php#L463)
- [`setHasErrors(?bool $hasErrors): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L468)
- [`getValidationErrors(): array`](../../src/Accounting/CreditNote/CreditNote.php#L478)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L483)
- [`getWarnings(): array`](../../src/Accounting/CreditNote/CreditNote.php#L493)
- [`addWarning(\Sujip\Xero\Support\ValidationError $warning): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L498)
- [`getInvoiceAddresses(): array`](../../src/Accounting/CreditNote/CreditNote.php#L508)
- [`addInvoiceAddress(\Sujip\Xero\Support\InvoiceAddress $invoiceAddress): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L513)
- [`toRequest(): array`](../../src/Accounting/CreditNote/CreditNote.php#L577)
- [`reference(string $reference): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L605)
- [`type(string $type): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L610)
- [`contact(string $contactId): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L615)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L623)
- [`save(): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNote.php#L633)
- [`attachments(): Sujip\Xero\Accounting\CreditNote\Attachments`](../../src/Accounting/CreditNote/CreditNote.php#L644)
- [`history(): Sujip\Xero\Accounting\CreditNote\History`](../../src/Accounting/CreditNote/CreditNote.php#L653)
- [`pdf(): string`](../../src/Accounting/CreditNote/CreditNote.php#L662)

## Accounting\CreditNote\CreditNotes

[Source](../../src/Accounting/CreditNote/CreditNotes.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/CreditNote/CreditNotes.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/CreditNote/CreditNotes.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/CreditNote/CreditNotes.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/CreditNote/CreditNotes.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/CreditNote/CreditNotes.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/CreditNote/CreditNotes.php#L30)
- [`ids(string ...$ids): static`](../../src/Accounting/CreditNote/CreditNotes.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\CreditNote\CreditNotes`](../../src/Accounting/CreditNote/CreditNotes.php#L38)
- [`unitDp(int $unitDp): static`](../../src/Accounting/CreditNote/CreditNotes.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/CreditNote/CreditNotes.php#L49)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/CreditNote/CreditNotes.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/CreditNote/CreditNotes.php#L69)
- [`find(string $creditNoteId): ?\Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNotes.php#L84)
- [`create(): Sujip\Xero\Accounting\CreditNote\Payload`](../../src/Accounting/CreditNote/CreditNotes.php#L96)
- [`update(string $creditNoteId): Sujip\Xero\Accounting\CreditNote\Payload`](../../src/Accounting/CreditNote/CreditNotes.php#L101)
- [`attachments(string $creditNoteId): Sujip\Xero\Accounting\CreditNote\Attachments`](../../src/Accounting/CreditNote/CreditNotes.php#L106)
- [`history(string $creditNoteId): Sujip\Xero\Accounting\CreditNote\History`](../../src/Accounting/CreditNote/CreditNotes.php#L111)
- [`allocations(string $creditNoteId): Sujip\Xero\Accounting\Allocations`](../../src/Accounting/CreditNote/CreditNotes.php#L116)
- [`pdf(string $creditNoteId): string`](../../src/Accounting/CreditNote/CreditNotes.php#L121)
- [`mapCreditNote(array $payload): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/CreditNotes.php#L134)

## Accounting\CreditNote\History

[Source](../../src/Accounting/CreditNote/History.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $creditNoteId)`](../../src/Accounting/CreditNote/History.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/CreditNote/History.php#L22)
- [`record(string $details): Sujip\Xero\Accounting\CreditNote\HistoryRecord`](../../src/Accounting/CreditNote/History.php#L42)

## Accounting\CreditNote\HistoryRecord

[Source](../../src/Accounting/CreditNote/HistoryRecord.php)

### Public methods

- [`__construct(?string $details, ?string $user, ?string $changes, array $raw = array (
))`](../../src/Accounting/CreditNote/HistoryRecord.php#L12)

## Accounting\CreditNote\Payload

[Source](../../src/Accounting/CreditNote/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/CreditNote/Payload.php#L16)
- [`id(string $creditNoteId): Sujip\Xero\Accounting\CreditNote\Payload`](../../src/Accounting/CreditNote/Payload.php#L22)
- [`type(string $type): Sujip\Xero\Accounting\CreditNote\Payload`](../../src/Accounting/CreditNote/Payload.php#L31)
- [`contact(string $contactId): Sujip\Xero\Accounting\CreditNote\Payload`](../../src/Accounting/CreditNote/Payload.php#L40)
- [`reference(string $reference): Sujip\Xero\Accounting\CreditNote\Payload`](../../src/Accounting/CreditNote/Payload.php#L52)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\CreditNote\Payload`](../../src/Accounting/CreditNote/Payload.php#L61)
- [`using(\Sujip\Xero\Accounting\CreditNote\CreditNote $creditNote): Sujip\Xero\Accounting\CreditNote\Payload`](../../src/Accounting/CreditNote/Payload.php#L75)
- [`save(): Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/CreditNote/Payload.php#L83)

## Accounting\CreditNote\Upload

[Source](../../src/Accounting/CreditNote/Upload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $creditNoteId, string $fileName, string $content)`](../../src/Accounting/CreditNote/Upload.php#L16)
- [`mimeType(string $mimeType): Sujip\Xero\Accounting\CreditNote\Upload`](../../src/Accounting/CreditNote/Upload.php#L24)
- [`includeOnline(bool $includeOnline = true): Sujip\Xero\Accounting\CreditNote\Upload`](../../src/Accounting/CreditNote/Upload.php#L32)
- [`save(): Sujip\Xero\Accounting\CreditNote\Attachment`](../../src/Accounting/CreditNote/Upload.php#L40)

## Accounting\Currency\Currencies

[Source](../../src/Accounting/Currency/Currencies.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Currency/Currencies.php#L15)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Currency/Currencies.php#L20)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Currency/Currencies.php#L31)
- [`create(): Sujip\Xero\Accounting\Currency\Payload`](../../src/Accounting/Currency/Currencies.php#L46)
- [`mapCurrency(array $payload): Sujip\Xero\Accounting\Currency\Currency`](../../src/Accounting/Currency/Currencies.php#L54)

## Accounting\Currency\Currency

[Source](../../src/Accounting/Currency/Currency.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Code` | string or null | `()` |
| `Description` | string or null | `()` |
| `Status` | string or null | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Currency/Currency.php#L15)
- [`getCode(): ?string`](../../src/Accounting/Currency/Currency.php#L26)
- [`setCode(?string $code): Sujip\Xero\Accounting\Currency\Currency`](../../src/Accounting/Currency/Currency.php#L31)
- [`getDescription(): ?string`](../../src/Accounting/Currency/Currency.php#L38)
- [`setDescription(?string $description): Sujip\Xero\Accounting\Currency\Currency`](../../src/Accounting/Currency/Currency.php#L43)
- [`getStatus(): ?string`](../../src/Accounting/Currency/Currency.php#L50)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Currency\Currency`](../../src/Accounting/Currency/Currency.php#L55)
- [`toRequest(): array`](../../src/Accounting/Currency/Currency.php#L77)
- [`description(string $description): Sujip\Xero\Accounting\Currency\Currency`](../../src/Accounting/Currency/Currency.php#L86)
- [`save(): Sujip\Xero\Accounting\Currency\Currency`](../../src/Accounting/Currency/Currency.php#L91)

## Accounting\Currency\Payload

[Source](../../src/Accounting/Currency/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Currency/Payload.php#L16)
- [`code(string $code): Sujip\Xero\Accounting\Currency\Payload`](../../src/Accounting/Currency/Payload.php#L22)
- [`description(string $description): Sujip\Xero\Accounting\Currency\Payload`](../../src/Accounting/Currency/Payload.php#L31)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\Currency\Payload`](../../src/Accounting/Currency/Payload.php#L40)
- [`using(\Sujip\Xero\Accounting\Currency\Currency $currency): Sujip\Xero\Accounting\Currency\Payload`](../../src/Accounting/Currency/Payload.php#L48)
- [`save(): Sujip\Xero\Accounting\Currency\Currency`](../../src/Accounting/Currency/Payload.php#L56)

## Accounting\Employee\Employee

[Source](../../src/Accounting/Employee/Employee.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `EmployeeID` | string or null | `()` |
| `FirstName` | string or null | `()` |
| `LastName` | string or null | `()` |
| `Status` | string or null | `()` |
| `EmailAddress` | string or null | `()` |
| `ExternalLink` | object or null ([Accounting\Employee\ExternalLink](accounting.md#accountingemployeeexternallink)) | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Employee/Employee.php#L36)
- [`getEmployeeID(): ?string`](../../src/Accounting/Employee/Employee.php#L41)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L46)
- [`getFirstName(): ?string`](../../src/Accounting/Employee/Employee.php#L53)
- [`setFirstName(?string $firstName): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L58)
- [`getLastName(): ?string`](../../src/Accounting/Employee/Employee.php#L65)
- [`setLastName(?string $lastName): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L70)
- [`getStatus(): ?string`](../../src/Accounting/Employee/Employee.php#L77)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L82)
- [`getEmailAddress(): ?string`](../../src/Accounting/Employee/Employee.php#L89)
- [`setEmailAddress(?string $emailAddress): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L94)
- [`getExternalLink(): ?\Sujip\Xero\Accounting\Employee\ExternalLink`](../../src/Accounting/Employee/Employee.php#L101)
- [`setExternalLink(?\Sujip\Xero\Accounting\Employee\ExternalLink $externalLink): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L106)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Employee/Employee.php#L113)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L118)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/Employee/Employee.php#L125)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L130)
- [`getValidationErrors(): array`](../../src/Accounting/Employee/Employee.php#L140)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L145)
- [`firstName(string $firstName): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L170)
- [`lastName(string $lastName): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L175)
- [`email(string $emailAddress): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L180)
- [`save(): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employee.php#L185)

## Accounting\Employee\Employees

[Source](../../src/Accounting/Employee/Employees.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Employee/Employees.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Employee/Employees.php#L20)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Employee/Employees.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Employee/Employees.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Employee\Employees`](../../src/Accounting/Employee/Employees.php#L33)
- [`ids(string ...$ids): static`](../../src/Accounting/Employee/Employees.php#L35)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Employee/Employees.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Employee/Employees.php#L44)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Employee/Employees.php#L51)
- [`find(string $employeeId): ?\Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employees.php#L61)
- [`create(): Sujip\Xero\Accounting\Employee\Payload`](../../src/Accounting/Employee/Employees.php#L73)
- [`update(string $employeeId): Sujip\Xero\Accounting\Employee\Payload`](../../src/Accounting/Employee/Employees.php#L78)
- [`mapEmployee(array $payload): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Employees.php#L86)

## Accounting\Employee\ExternalLink

[Source](../../src/Accounting/Employee/ExternalLink.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `LinkType` | string or null | `()` |
| `Url` | string or null | `()` |
| `Description` | string or null | `()` |

### Public methods

- [`__construct(?string $linkType = NULL, ?string $url = NULL, ?string $description = NULL)`](../../src/Accounting/Employee/ExternalLink.php#L12)
- [`getLinkType(): ?string`](../../src/Accounting/Employee/ExternalLink.php#L19)
- [`setLinkType(?string $linkType): Sujip\Xero\Accounting\Employee\ExternalLink`](../../src/Accounting/Employee/ExternalLink.php#L24)
- [`getUrl(): ?string`](../../src/Accounting/Employee/ExternalLink.php#L31)
- [`setUrl(?string $url): Sujip\Xero\Accounting\Employee\ExternalLink`](../../src/Accounting/Employee/ExternalLink.php#L36)
- [`getDescription(): ?string`](../../src/Accounting/Employee/ExternalLink.php#L43)
- [`setDescription(?string $description): Sujip\Xero\Accounting\Employee\ExternalLink`](../../src/Accounting/Employee/ExternalLink.php#L48)

## Accounting\Employee\Payload

[Source](../../src/Accounting/Employee/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Employee/Payload.php#L21)
- [`id(string $employeeId): Sujip\Xero\Accounting\Employee\Payload`](../../src/Accounting/Employee/Payload.php#L26)
- [`firstName(string $firstName): Sujip\Xero\Accounting\Employee\Payload`](../../src/Accounting/Employee/Payload.php#L34)
- [`lastName(string $lastName): Sujip\Xero\Accounting\Employee\Payload`](../../src/Accounting/Employee/Payload.php#L42)
- [`email(string $emailAddress): Sujip\Xero\Accounting\Employee\Payload`](../../src/Accounting/Employee/Payload.php#L50)
- [`status(string $status): Sujip\Xero\Accounting\Employee\Payload`](../../src/Accounting/Employee/Payload.php#L58)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\Employee\Payload`](../../src/Accounting/Employee/Payload.php#L66)
- [`save(): Sujip\Xero\Accounting\Employee\Employee`](../../src/Accounting/Employee/Payload.php#L74)

## Accounting\ExpenseClaim\ExpenseClaim

[Source](../../src/Accounting/ExpenseClaim/ExpenseClaim.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `ExpenseClaimID` | string or null | `()` |
| `Status` | string or null | `()` |
| `Total` | int, float, or null | `()` |
| `AmountDue` | int, float, or null | `()` |
| `AmountPaid` | int, float, or null | `()` |
| `PaymentDueDate` | string or null | `()` |
| `ReportingDate` | string or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `ReceiptID` | string or null | `()` |
| `User` | object or null ([Accounting\User\User](accounting.md#accountinguseruser)) | `()` |
| `Payments` | list of objects ([Accounting\Payment\Payment](accounting.md#accountingpaymentpayment)) | `()` |
| `Receipts` | list of objects ([Accounting\Receipt\Receipt](accounting.md#accountingreceiptreceipt)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L54)
- [`getExpenseClaimID(): ?string`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L59)
- [`setExpenseClaimID(?string $expenseClaimID): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L64)
- [`getStatus(): ?string`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L71)
- [`setStatus(?string $status): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L76)
- [`getEmployeeID(): ?string`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L83)
- [`setEmployeeID(?string $employeeID): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L88)
- [`getReceiptIDs(): array`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L98)
- [`setReceiptIDs(array $receiptIDs): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L106)
- [`addReceiptID(string $receiptID): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L113)
- [`getTotal(): int\|float\|null`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L120)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L125)
- [`getAmountDue(): int\|float\|null`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L132)
- [`setAmountDue(int\|float\|null $amountDue): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L137)
- [`getAmountPaid(): int\|float\|null`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L144)
- [`setAmountPaid(int\|float\|null $amountPaid): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L149)
- [`getPaymentDueDate(): ?string`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L156)
- [`setPaymentDueDate(?string $paymentDueDate): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L161)
- [`getReportingDate(): ?string`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L168)
- [`setReportingDate(?string $reportingDate): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L173)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L180)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L185)
- [`getReceiptID(): ?string`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L192)
- [`setReceiptID(?string $receiptID): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L197)
- [`getUser(): ?\Sujip\Xero\Accounting\User\User`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L204)
- [`setUser(?\Sujip\Xero\Accounting\User\User $user): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L209)
- [`getPayments(): array`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L219)
- [`addPayment(\Sujip\Xero\Accounting\Payment\Payment $payment): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L224)
- [`getReceipts(): array`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L234)
- [`addReceipt(\Sujip\Xero\Accounting\Receipt\Receipt $receipt): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L239)
- [`fill(array $payload): static`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L267)
- [`status(string $status): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L292)
- [`save(): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaim.php#L297)

## Accounting\ExpenseClaim\ExpenseClaims

[Source](../../src/Accounting/ExpenseClaim/ExpenseClaims.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L26)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaims`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L34)
- [`ids(string ...$ids): static`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L35)
- [`unitDp(int $unitDp): static`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L45)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L51)
- [`find(string $expenseClaimId): ?\Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L62)
- [`create(): Sujip\Xero\Accounting\ExpenseClaim\Payload`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L74)
- [`update(string $expenseClaimId): Sujip\Xero\Accounting\ExpenseClaim\Payload`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L79)
- [`history(string $expenseClaimId): Sujip\Xero\Accounting\History`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L84)
- [`mapExpenseClaim(array $payload): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/ExpenseClaims.php#L92)

## Accounting\ExpenseClaim\Payload

[Source](../../src/Accounting/ExpenseClaim/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/ExpenseClaim/Payload.php#L21)
- [`id(string $expenseClaimId): Sujip\Xero\Accounting\ExpenseClaim\Payload`](../../src/Accounting/ExpenseClaim/Payload.php#L26)
- [`status(string $status): Sujip\Xero\Accounting\ExpenseClaim\Payload`](../../src/Accounting/ExpenseClaim/Payload.php#L34)
- [`employee(string $employeeId): Sujip\Xero\Accounting\ExpenseClaim\Payload`](../../src/Accounting/ExpenseClaim/Payload.php#L42)
- [`receipt(string $receiptId): Sujip\Xero\Accounting\ExpenseClaim\Payload`](../../src/Accounting/ExpenseClaim/Payload.php#L50)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\ExpenseClaim\Payload`](../../src/Accounting/ExpenseClaim/Payload.php#L60)
- [`save(): Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim`](../../src/Accounting/ExpenseClaim/Payload.php#L68)

## Accounting\History

[Source](../../src/Accounting/History.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $path)`](../../src/Accounting/History.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/History.php#L22)
- [`record(string $details): Sujip\Xero\Accounting\HistoryRecord`](../../src/Accounting/History.php#L42)

## Accounting\HistoryRecord

[Source](../../src/Accounting/HistoryRecord.php)

### Public methods

- [`__construct(?string $details, ?string $dateUtc, ?string $user, array $raw = array (
))`](../../src/Accounting/HistoryRecord.php#L12)

## Accounting\InvoiceReminder\InvoiceReminderSettings

[Source](../../src/Accounting/InvoiceReminder/InvoiceReminderSettings.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Enabled` | bool or null | `()` |

### Public methods

- [`getEnabled(): bool`](../../src/Accounting/InvoiceReminder/InvoiceReminderSettings.php#L19)
- [`setEnabled(bool $enabled): Sujip\Xero\Accounting\InvoiceReminder\InvoiceReminderSettings`](../../src/Accounting/InvoiceReminder/InvoiceReminderSettings.php#L24)
- [`getDays(): array`](../../src/Accounting/InvoiceReminder/InvoiceReminderSettings.php#L34)
- [`setDays(array $days): Sujip\Xero\Accounting\InvoiceReminder\InvoiceReminderSettings`](../../src/Accounting/InvoiceReminder/InvoiceReminderSettings.php#L42)
- [`fill(array $payload): static`](../../src/Accounting/InvoiceReminder/InvoiceReminderSettings.php#L59)

## Accounting\InvoiceReminder\InvoiceReminders

[Source](../../src/Accounting/InvoiceReminder/InvoiceReminders.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/InvoiceReminder/InvoiceReminders.php#L14)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/InvoiceReminder/InvoiceReminders.php#L19)
- [`settings(): Sujip\Xero\Accounting\InvoiceReminder\InvoiceReminderSettings`](../../src/Accounting/InvoiceReminder/InvoiceReminders.php#L27)
- [`mapInvoiceReminderSettings(array $payload): Sujip\Xero\Accounting\InvoiceReminder\InvoiceReminderSettings`](../../src/Accounting/InvoiceReminder/InvoiceReminders.php#L43)

## Accounting\Invoice\Attachment

[Source](../../src/Accounting/Invoice/Attachment.php)

### Public methods

- [`__construct(?string $id, ?string $fileName, ?string $mimeType, ?bool $includeOnline, array $raw = array (
))`](../../src/Accounting/Invoice/Attachment.php#L12)

## Accounting\Invoice\Attachments

[Source](../../src/Accounting/Invoice/Attachments.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $invoiceId)`](../../src/Accounting/Invoice/Attachments.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Invoice/Attachments.php#L22)
- [`upload(string $fileName, string $content): Sujip\Xero\Accounting\Invoice\Upload`](../../src/Accounting/Invoice/Attachments.php#L43)
- [`download(string $fileName, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/Invoice/Attachments.php#L48)
- [`downloadById(string $attachmentId, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/Invoice/Attachments.php#L60)

## Accounting\Invoice\Draft

[Source](../../src/Accounting/Invoice/Draft.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Invoice/Draft.php#L20)
- [`draft(): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L28)
- [`contact(string $contactId): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L37)
- [`type(string $type): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L46)
- [`id(string $invoiceId): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L55)
- [`reference(string $reference): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L64)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L73)
- [`using(\Sujip\Xero\Accounting\Invoice\Invoice $invoice): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L90)
- [`save(): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Draft.php#L98)
- [`allowBackorders(bool $allow = true): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L125)
- [`unitDp(int $unitDp): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L133)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Draft.php#L141)

## Accounting\Invoice\History

[Source](../../src/Accounting/Invoice/History.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $invoiceId)`](../../src/Accounting/Invoice/History.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Invoice/History.php#L22)
- [`record(string $details): Sujip\Xero\Accounting\Invoice\HistoryRecord`](../../src/Accounting/Invoice/History.php#L42)

## Accounting\Invoice\HistoryRecord

[Source](../../src/Accounting/Invoice/HistoryRecord.php)

### Public methods

- [`__construct(?string $details, ?string $user, ?string $dateUtc, array $raw = array (
))`](../../src/Accounting/Invoice/HistoryRecord.php#L12)

## Accounting\Invoice\Invoice

[Source](../../src/Accounting/Invoice/Invoice.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `InvoiceID` | string or null | `()` |
| `Status` | string or null | `()` |
| `Reference` | string or null | `()` |
| `Type` | string or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `Date` | string or null | `()` |
| `DueDate` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `InvoiceNumber` | string or null | `()` |
| `BrandingThemeID` | string or null | `()` |
| `Url` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `SentToContact` | bool or null | `()` |
| `ExpectedPaymentDate` | string or null | `()` |
| `PlannedPaymentDate` | string or null | `()` |
| `CISDeduction` | int, float, or null | `()` |
| `CISRate` | int, float, or null | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `Total` | int, float, or null | `()` |
| `RoundingAmount` | int, float, or null | `()` |
| `EnteredTotal` | int, float, or null | `()` |
| `TotalDiscount` | int, float, or null | `()` |
| `RepeatingInvoiceID` | string or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `IsDiscounted` | bool or null | `()` |
| `Payments` | list of objects ([Accounting\Payment\Payment](accounting.md#accountingpaymentpayment)) | `()` |
| `Prepayments` | list of objects ([Accounting\Prepayment\Prepayment](accounting.md#accountingprepaymentprepayment)) | `()` |
| `Overpayments` | list of objects ([Accounting\Overpayment\Overpayment](accounting.md#accountingoverpaymentoverpayment)) | `()` |
| `AmountDue` | int, float, or null | `()` |
| `AmountPaid` | int, float, or null | `()` |
| `FullyPaidOnDate` | string or null | `()` |
| `AmountCredited` | int, float, or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `UpdatedDateUTCString` | string or null | `()` |
| `CreditNotes` | list of objects ([Accounting\CreditNote\CreditNote](accounting.md#accountingcreditnotecreditnote)) | `()` |
| `Attachments` | list of objects ([Support\AttachmentDetail](support.md#supportattachmentdetail)) | `()` |
| `HasErrors` | bool or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `Warnings` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `InvoiceAddresses` | list of objects ([Support\InvoiceAddress](support.md#supportinvoiceaddress)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Invoice/Invoice.php#L138)
- [`getInvoiceID(): ?string`](../../src/Accounting/Invoice/Invoice.php#L143)
- [`setInvoiceID(?string $invoiceID): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L148)
- [`getStatus(): ?string`](../../src/Accounting/Invoice/Invoice.php#L155)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L160)
- [`getReference(): ?string`](../../src/Accounting/Invoice/Invoice.php#L167)
- [`setReference(?string $reference): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L172)
- [`getType(): ?string`](../../src/Accounting/Invoice/Invoice.php#L179)
- [`setType(?string $type): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L184)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Invoice/Invoice.php#L191)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L196)
- [`getContactID(): ?string`](../../src/Accounting/Invoice/Invoice.php#L203)
- [`setContactID(?string $contactID): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L208)
- [`getLineItems(): array`](../../src/Accounting/Invoice/Invoice.php#L220)
- [`setLineItems(array $lineItems): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L228)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L235)
- [`getDate(): ?string`](../../src/Accounting/Invoice/Invoice.php#L242)
- [`setDate(?string $date): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L247)
- [`getDueDate(): ?string`](../../src/Accounting/Invoice/Invoice.php#L254)
- [`setDueDate(?string $dueDate): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L259)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/Invoice/Invoice.php#L266)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L271)
- [`getInvoiceNumber(): ?string`](../../src/Accounting/Invoice/Invoice.php#L278)
- [`setInvoiceNumber(?string $invoiceNumber): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L283)
- [`getBrandingThemeID(): ?string`](../../src/Accounting/Invoice/Invoice.php#L290)
- [`setBrandingThemeID(?string $brandingThemeID): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L295)
- [`getUrl(): ?string`](../../src/Accounting/Invoice/Invoice.php#L302)
- [`setUrl(?string $url): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L307)
- [`getCurrencyCode(): ?string`](../../src/Accounting/Invoice/Invoice.php#L314)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L319)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L326)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L331)
- [`getSentToContact(): ?bool`](../../src/Accounting/Invoice/Invoice.php#L338)
- [`setSentToContact(?bool $sentToContact): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L343)
- [`getExpectedPaymentDate(): ?string`](../../src/Accounting/Invoice/Invoice.php#L350)
- [`setExpectedPaymentDate(?string $expectedPaymentDate): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L355)
- [`getPlannedPaymentDate(): ?string`](../../src/Accounting/Invoice/Invoice.php#L362)
- [`setPlannedPaymentDate(?string $plannedPaymentDate): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L367)
- [`getCISDeduction(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L374)
- [`setCISDeduction(int\|float\|null $cisDeduction): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L379)
- [`getCISRate(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L386)
- [`setCISRate(int\|float\|null $cisRate): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L391)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L398)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L403)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L410)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L415)
- [`getTotal(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L422)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L427)
- [`getRoundingAmount(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L434)
- [`setRoundingAmount(int\|float\|null $roundingAmount): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L439)
- [`getEnteredTotal(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L446)
- [`setEnteredTotal(int\|float\|null $enteredTotal): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L451)
- [`getTotalDiscount(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L458)
- [`setTotalDiscount(int\|float\|null $totalDiscount): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L463)
- [`getRepeatingInvoiceID(): ?string`](../../src/Accounting/Invoice/Invoice.php#L470)
- [`setRepeatingInvoiceID(?string $repeatingInvoiceID): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L475)
- [`getHasAttachments(): ?bool`](../../src/Accounting/Invoice/Invoice.php#L482)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L487)
- [`getIsDiscounted(): ?bool`](../../src/Accounting/Invoice/Invoice.php#L494)
- [`setIsDiscounted(?bool $isDiscounted): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L499)
- [`getPayments(): array`](../../src/Accounting/Invoice/Invoice.php#L509)
- [`addPayment(\Sujip\Xero\Accounting\Payment\Payment $payment): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L514)
- [`getPrepayments(): array`](../../src/Accounting/Invoice/Invoice.php#L524)
- [`addPrepayment(\Sujip\Xero\Accounting\Prepayment\Prepayment $prepayment): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L529)
- [`getOverpayments(): array`](../../src/Accounting/Invoice/Invoice.php#L539)
- [`addOverpayment(\Sujip\Xero\Accounting\Overpayment\Overpayment $overpayment): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L544)
- [`getAmountDue(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L551)
- [`setAmountDue(int\|float\|null $amountDue): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L556)
- [`getAmountPaid(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L563)
- [`setAmountPaid(int\|float\|null $amountPaid): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L568)
- [`getFullyPaidOnDate(): ?string`](../../src/Accounting/Invoice/Invoice.php#L575)
- [`setFullyPaidOnDate(?string $fullyPaidOnDate): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L580)
- [`getAmountCredited(): int\|float\|null`](../../src/Accounting/Invoice/Invoice.php#L587)
- [`setAmountCredited(int\|float\|null $amountCredited): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L592)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Invoice/Invoice.php#L599)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L604)
- [`getUpdatedDateUTCString(): ?string`](../../src/Accounting/Invoice/Invoice.php#L611)
- [`setUpdatedDateUTCString(?string $updatedDateUTCString): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L616)
- [`getCreditNotes(): array`](../../src/Accounting/Invoice/Invoice.php#L626)
- [`addCreditNote(\Sujip\Xero\Accounting\CreditNote\CreditNote $creditNote): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L631)
- [`getAttachments(): array`](../../src/Accounting/Invoice/Invoice.php#L641)
- [`addAttachment(\Sujip\Xero\Support\AttachmentDetail $attachment): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L646)
- [`getHasErrors(): ?bool`](../../src/Accounting/Invoice/Invoice.php#L653)
- [`setHasErrors(?bool $hasErrors): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L658)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/Invoice/Invoice.php#L665)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L670)
- [`getValidationErrors(): array`](../../src/Accounting/Invoice/Invoice.php#L680)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L685)
- [`getWarnings(): array`](../../src/Accounting/Invoice/Invoice.php#L695)
- [`addWarning(\Sujip\Xero\Support\ValidationError $warning): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L700)
- [`getInvoiceAddresses(): array`](../../src/Accounting/Invoice/Invoice.php#L710)
- [`addInvoiceAddress(\Sujip\Xero\Support\InvoiceAddress $invoiceAddress): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L715)
- [`toRequest(): array`](../../src/Accounting/Invoice/Invoice.php#L795)
- [`reference(string $reference): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L833)
- [`type(string $type): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L838)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L843)
- [`draft(): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L853)
- [`save(): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoice.php#L858)
- [`attachments(): Sujip\Xero\Accounting\Invoice\Attachments`](../../src/Accounting/Invoice/Invoice.php#L869)
- [`history(): Sujip\Xero\Accounting\Invoice\History`](../../src/Accounting/Invoice/Invoice.php#L878)
- [`pdf(): string`](../../src/Accounting/Invoice/Invoice.php#L887)
- [`email(?string $idempotencyKey = NULL): void`](../../src/Accounting/Invoice/Invoice.php#L896)
- [`onlineInvoiceUrl(): ?string`](../../src/Accounting/Invoice/Invoice.php#L905)

## Accounting\Invoice\Invoices

[Source](../../src/Accounting/Invoice/Invoices.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/Invoice/Invoices.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Invoice/Invoices.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/Invoice/Invoices.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Invoice/Invoices.php#L24)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Invoice/Invoices.php#L27)
- [`create(): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Invoices.php#L29)
- [`update(string $invoiceId): Sujip\Xero\Accounting\Invoice\Draft`](../../src/Accounting/Invoice/Invoices.php#L34)
- [`ids(string ...$ids): static`](../../src/Accounting/Invoice/Invoices.php#L35)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Invoice/Invoices.php#L39)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Invoice/Invoices.php#L43)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Invoice\Invoices`](../../src/Accounting/Invoice/Invoices.php#L47)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Invoice/Invoices.php#L51)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Invoice/Invoices.php#L58)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/Invoice/Invoices.php#L78)
- [`find(string $invoiceId): ?\Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoices.php#L100)
- [`attachments(string $invoiceId): Sujip\Xero\Accounting\Invoice\Attachments`](../../src/Accounting/Invoice/Invoices.php#L112)
- [`history(string $invoiceId): Sujip\Xero\Accounting\Invoice\History`](../../src/Accounting/Invoice/Invoices.php#L117)
- [`email(string $invoiceId, ?string $idempotencyKey = NULL): void`](../../src/Accounting/Invoice/Invoices.php#L122)
- [`onlineInvoiceUrl(string $invoiceId): ?string`](../../src/Accounting/Invoice/Invoices.php#L134)
- [`pdf(string $invoiceId): string`](../../src/Accounting/Invoice/Invoices.php#L147)
- [`mapInvoice(array $payload): Sujip\Xero\Accounting\Invoice\Invoice`](../../src/Accounting/Invoice/Invoices.php#L160)
- [`mapLineItem(array $payload): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/Invoices.php#L168)

## Accounting\Invoice\LineItem

[Source](../../src/Accounting/Invoice/LineItem.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `LineItemID` | string or null | `()` |
| `Description` | string or null | `()` |
| `Quantity` | int, float, or null | `()` |
| `UnitAmount` | int, float, or null | `()` |
| `ItemCode` | string or null | `()` |
| `AccountCode` | string or null | `()` |
| `AccountID` | string or null | `()` |
| `TaxType` | string or null | `()` |
| `TaxAmount` | int, float, or null | `()` |
| `Item` | object or null ([Accounting\Invoice\LineItemItem](accounting.md#accountinginvoicelineitemitem)) | `()` |
| `LineAmount` | int, float, or null | `()` |
| `Tracking` | list of objects ([Accounting\Invoice\LineItemTracking](accounting.md#accountinginvoicelineitemtracking)) | `()` |
| `DiscountRate` | int, float, or null | `()` |
| `DiscountAmount` | int, float, or null | `()` |
| `RepeatingInvoiceID` | string or null | `()` |
| `Taxability` | string or null | `()` |
| `SalesTaxCodeId` | int, float, or null | `()` |
| `TaxBreakdown` | list of objects ([Accounting\Invoice\TaxBreakdownComponent](accounting.md#accountinginvoicetaxbreakdowncomponent)) | `()` |

### Public methods

- [`getLineItemID(): ?string`](../../src/Accounting/Invoice/LineItem.php#L55)
- [`setLineItemID(?string $lineItemID): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L60)
- [`getDescription(): ?string`](../../src/Accounting/Invoice/LineItem.php#L67)
- [`setDescription(?string $description): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L72)
- [`getQuantity(): int\|float\|null`](../../src/Accounting/Invoice/LineItem.php#L79)
- [`setQuantity(int\|float\|null $quantity): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L84)
- [`getUnitAmount(): int\|float\|null`](../../src/Accounting/Invoice/LineItem.php#L91)
- [`setUnitAmount(int\|float\|null $unitAmount): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L96)
- [`getItemCode(): ?string`](../../src/Accounting/Invoice/LineItem.php#L103)
- [`setItemCode(?string $itemCode): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L108)
- [`getAccountCode(): ?string`](../../src/Accounting/Invoice/LineItem.php#L115)
- [`setAccountCode(?string $accountCode): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L120)
- [`getAccountID(): ?string`](../../src/Accounting/Invoice/LineItem.php#L127)
- [`setAccountID(?string $accountID): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L132)
- [`getTaxType(): ?string`](../../src/Accounting/Invoice/LineItem.php#L139)
- [`setTaxType(?string $taxType): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L144)
- [`getTaxAmount(): int\|float\|null`](../../src/Accounting/Invoice/LineItem.php#L151)
- [`setTaxAmount(int\|float\|null $taxAmount): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L156)
- [`getItem(): ?\Sujip\Xero\Accounting\Invoice\LineItemItem`](../../src/Accounting/Invoice/LineItem.php#L163)
- [`setItem(?\Sujip\Xero\Accounting\Invoice\LineItemItem $item): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L168)
- [`getLineAmount(): int\|float\|null`](../../src/Accounting/Invoice/LineItem.php#L175)
- [`setLineAmount(int\|float\|null $lineAmount): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L180)
- [`getTracking(): array`](../../src/Accounting/Invoice/LineItem.php#L190)
- [`setTracking(array $tracking): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L198)
- [`addTracking(\Sujip\Xero\Accounting\Invoice\LineItemTracking $tracking): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L205)
- [`getDiscountRate(): int\|float\|null`](../../src/Accounting/Invoice/LineItem.php#L212)
- [`setDiscountRate(int\|float\|null $discountRate): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L217)
- [`getDiscountAmount(): int\|float\|null`](../../src/Accounting/Invoice/LineItem.php#L224)
- [`setDiscountAmount(int\|float\|null $discountAmount): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L229)
- [`getRepeatingInvoiceID(): ?string`](../../src/Accounting/Invoice/LineItem.php#L236)
- [`setRepeatingInvoiceID(?string $repeatingInvoiceID): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L241)
- [`getTaxability(): ?string`](../../src/Accounting/Invoice/LineItem.php#L248)
- [`setTaxability(?string $taxability): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L253)
- [`getSalesTaxCodeId(): int\|float\|null`](../../src/Accounting/Invoice/LineItem.php#L260)
- [`setSalesTaxCodeId(int\|float\|null $salesTaxCodeId): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L265)
- [`getTaxBreakdown(): array`](../../src/Accounting/Invoice/LineItem.php#L275)
- [`addTaxBreakdown(\Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent $taxBreakdownComponent): Sujip\Xero\Accounting\Invoice\LineItem`](../../src/Accounting/Invoice/LineItem.php#L280)
- [`toRequest(): array`](../../src/Accounting/Invoice/LineItem.php#L317)

## Accounting\Invoice\LineItemItem

[Source](../../src/Accounting/Invoice/LineItemItem.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Code` | string or null | `()` |
| `Name` | string or null | `()` |
| `ItemID` | string or null | `()` |

### Public methods

- [`getCode(): ?string`](../../src/Accounting/Invoice/LineItemItem.php#L18)
- [`setCode(?string $code): Sujip\Xero\Accounting\Invoice\LineItemItem`](../../src/Accounting/Invoice/LineItemItem.php#L23)
- [`getName(): ?string`](../../src/Accounting/Invoice/LineItemItem.php#L30)
- [`setName(?string $name): Sujip\Xero\Accounting\Invoice\LineItemItem`](../../src/Accounting/Invoice/LineItemItem.php#L35)
- [`getItemID(): ?string`](../../src/Accounting/Invoice/LineItemItem.php#L42)
- [`setItemID(?string $itemID): Sujip\Xero\Accounting\Invoice\LineItemItem`](../../src/Accounting/Invoice/LineItemItem.php#L47)

## Accounting\Invoice\LineItemTracking

[Source](../../src/Accounting/Invoice/LineItemTracking.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `TrackingCategoryID` | string or null | `()` |
| `TrackingOptionID` | string or null | `()` |
| `Name` | string or null | `()` |
| `Option` | string or null | `()` |

### Public methods

- [`getTrackingCategoryID(): ?string`](../../src/Accounting/Invoice/LineItemTracking.php#L21)
- [`setTrackingCategoryID(?string $trackingCategoryID): Sujip\Xero\Accounting\Invoice\LineItemTracking`](../../src/Accounting/Invoice/LineItemTracking.php#L26)
- [`getTrackingOptionID(): ?string`](../../src/Accounting/Invoice/LineItemTracking.php#L33)
- [`setTrackingOptionID(?string $trackingOptionID): Sujip\Xero\Accounting\Invoice\LineItemTracking`](../../src/Accounting/Invoice/LineItemTracking.php#L38)
- [`getName(): ?string`](../../src/Accounting/Invoice/LineItemTracking.php#L45)
- [`setName(?string $name): Sujip\Xero\Accounting\Invoice\LineItemTracking`](../../src/Accounting/Invoice/LineItemTracking.php#L50)
- [`getOption(): ?string`](../../src/Accounting/Invoice/LineItemTracking.php#L57)
- [`setOption(?string $option): Sujip\Xero\Accounting\Invoice\LineItemTracking`](../../src/Accounting/Invoice/LineItemTracking.php#L62)
- [`toRequest(): array`](../../src/Accounting/Invoice/LineItemTracking.php#L85)

## Accounting\Invoice\TaxBreakdownComponent

[Source](../../src/Accounting/Invoice/TaxBreakdownComponent.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `TaxComponentId` | string or null | `()` |
| `Type` | string or null | `()` |
| `Name` | string or null | `()` |
| `TaxPercentage` | int, float, or null | `()` |
| `TaxAmount` | int, float, or null | `()` |
| `TaxableAmount` | int, float, or null | `()` |
| `NonTaxableAmount` | int, float, or null | `()` |
| `ExemptAmount` | int, float, or null | `()` |
| `StateAssignedNo` | string or null | `()` |
| `JurisdictionRegion` | string or null | `()` |

### Public methods

- [`getTaxComponentId(): ?string`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L32)
- [`setTaxComponentId(?string $taxComponentId): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L37)
- [`getType(): ?string`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L44)
- [`setType(?string $type): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L49)
- [`getName(): ?string`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L56)
- [`setName(?string $name): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L61)
- [`getTaxPercentage(): int\|float\|null`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L68)
- [`setTaxPercentage(int\|float\|null $taxPercentage): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L73)
- [`getTaxAmount(): int\|float\|null`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L80)
- [`setTaxAmount(int\|float\|null $taxAmount): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L85)
- [`getTaxableAmount(): int\|float\|null`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L92)
- [`setTaxableAmount(int\|float\|null $taxableAmount): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L97)
- [`getNonTaxableAmount(): int\|float\|null`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L104)
- [`setNonTaxableAmount(int\|float\|null $nonTaxableAmount): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L109)
- [`getExemptAmount(): int\|float\|null`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L116)
- [`setExemptAmount(int\|float\|null $exemptAmount): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L121)
- [`getStateAssignedNo(): ?string`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L128)
- [`setStateAssignedNo(?string $stateAssignedNo): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L133)
- [`getJurisdictionRegion(): ?string`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L140)
- [`setJurisdictionRegion(?string $jurisdictionRegion): Sujip\Xero\Accounting\Invoice\TaxBreakdownComponent`](../../src/Accounting/Invoice/TaxBreakdownComponent.php#L145)

## Accounting\Invoice\Upload

[Source](../../src/Accounting/Invoice/Upload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $invoiceId, string $fileName, string $content)`](../../src/Accounting/Invoice/Upload.php#L16)
- [`mimeType(string $mimeType): Sujip\Xero\Accounting\Invoice\Upload`](../../src/Accounting/Invoice/Upload.php#L24)
- [`includeOnline(bool $includeOnline = true): Sujip\Xero\Accounting\Invoice\Upload`](../../src/Accounting/Invoice/Upload.php#L32)
- [`save(): Sujip\Xero\Accounting\Invoice\Attachment`](../../src/Accounting/Invoice/Upload.php#L40)

## Accounting\Item\Item

[Source](../../src/Accounting/Item/Item.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `ItemID` | string or null | `()` |
| `Code` | string or null | `()` |
| `Name` | string or null | `()` |
| `Description` | string or null | `()` |
| `InventoryAssetAccountCode` | string or null | `()` |
| `IsPurchased` | bool or null | `()` |
| `IsSold` | bool or null | `()` |
| `IsTrackedAsInventory` | bool or null | `()` |
| `PurchaseDescription` | string or null | `()` |
| `PurchaseDetails` | object or null ([Accounting\Item\Purchase](accounting.md#accountingitempurchase)) | `()` |
| `SalesDetails` | object or null ([Accounting\Item\Purchase](accounting.md#accountingitempurchase)) | `()` |
| `QuantityOnHand` | int, float, or null | `()` |
| `QuantityAvailable` | int, float, or null | `()` |
| `QuantityOnBackOrder` | int, float, or null | `()` |
| `TotalCostPool` | int, float, or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Item/Item.php#L17)
- [`getItemID(): ?string`](../../src/Accounting/Item/Item.php#L61)
- [`setItemID(?string $itemID): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L66)
- [`getCode(): ?string`](../../src/Accounting/Item/Item.php#L73)
- [`setCode(?string $code): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L78)
- [`getName(): ?string`](../../src/Accounting/Item/Item.php#L85)
- [`setName(?string $name): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L90)
- [`getDescription(): ?string`](../../src/Accounting/Item/Item.php#L97)
- [`setDescription(?string $description): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L102)
- [`getInventoryAssetAccountCode(): ?string`](../../src/Accounting/Item/Item.php#L109)
- [`setInventoryAssetAccountCode(?string $inventoryAssetAccountCode): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L114)
- [`getIsPurchased(): ?bool`](../../src/Accounting/Item/Item.php#L121)
- [`setIsPurchased(?bool $isPurchased): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L126)
- [`getIsSold(): ?bool`](../../src/Accounting/Item/Item.php#L133)
- [`setIsSold(?bool $isSold): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L138)
- [`getIsTrackedAsInventory(): ?bool`](../../src/Accounting/Item/Item.php#L145)
- [`setIsTrackedAsInventory(?bool $isTrackedAsInventory): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L150)
- [`getPurchaseDescription(): ?string`](../../src/Accounting/Item/Item.php#L157)
- [`setPurchaseDescription(?string $purchaseDescription): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L162)
- [`getPurchaseDetails(): ?\Sujip\Xero\Accounting\Item\Purchase`](../../src/Accounting/Item/Item.php#L169)
- [`setPurchaseDetails(?\Sujip\Xero\Accounting\Item\Purchase $purchaseDetails): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L174)
- [`getSalesDetails(): ?\Sujip\Xero\Accounting\Item\Purchase`](../../src/Accounting/Item/Item.php#L181)
- [`setSalesDetails(?\Sujip\Xero\Accounting\Item\Purchase $salesDetails): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L186)
- [`getQuantityOnHand(): int\|float\|null`](../../src/Accounting/Item/Item.php#L193)
- [`setQuantityOnHand(int\|float\|null $quantityOnHand): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L198)
- [`getQuantityAvailable(): int\|float\|null`](../../src/Accounting/Item/Item.php#L205)
- [`setQuantityAvailable(int\|float\|null $quantityAvailable): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L210)
- [`getQuantityOnBackOrder(): int\|float\|null`](../../src/Accounting/Item/Item.php#L217)
- [`setQuantityOnBackOrder(int\|float\|null $quantityOnBackOrder): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L222)
- [`getTotalCostPool(): int\|float\|null`](../../src/Accounting/Item/Item.php#L229)
- [`setTotalCostPool(int\|float\|null $totalCostPool): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L234)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/Item/Item.php#L241)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L246)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Item/Item.php#L253)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L258)
- [`getValidationErrors(): array`](../../src/Accounting/Item/Item.php#L268)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L273)
- [`toRequest(): array`](../../src/Accounting/Item/Item.php#L310)
- [`code(string $code): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L327)
- [`name(string $name): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L332)
- [`description(string $description): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L337)
- [`save(): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Item.php#L342)
- [`history(): Sujip\Xero\Accounting\History`](../../src/Accounting/Item/Item.php#L353)

## Accounting\Item\Items

[Source](../../src/Accounting/Item/Items.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/Item/Items.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Item/Items.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/Item/Items.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Item/Items.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Item/Items.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Item/Items.php#L30)
- [`ids(string ...$ids): static`](../../src/Accounting/Item/Items.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Item\Items`](../../src/Accounting/Item/Items.php#L38)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Item/Items.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Item/Items.php#L49)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Item/Items.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/Item/Items.php#L69)
- [`find(string $itemId): ?\Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Items.php#L89)
- [`create(): Sujip\Xero\Accounting\Item\Payload`](../../src/Accounting/Item/Items.php#L103)
- [`update(string $itemId): Sujip\Xero\Accounting\Item\Payload`](../../src/Accounting/Item/Items.php#L108)
- [`history(string $itemId): Sujip\Xero\Accounting\History`](../../src/Accounting/Item/Items.php#L113)
- [`mapItem(array $payload): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Items.php#L121)

## Accounting\Item\Payload

[Source](../../src/Accounting/Item/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Item/Payload.php#L16)
- [`id(string $itemId): Sujip\Xero\Accounting\Item\Payload`](../../src/Accounting/Item/Payload.php#L22)
- [`code(string $code): Sujip\Xero\Accounting\Item\Payload`](../../src/Accounting/Item/Payload.php#L31)
- [`name(string $name): Sujip\Xero\Accounting\Item\Payload`](../../src/Accounting/Item/Payload.php#L40)
- [`description(string $description): Sujip\Xero\Accounting\Item\Payload`](../../src/Accounting/Item/Payload.php#L49)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\Item\Payload`](../../src/Accounting/Item/Payload.php#L58)
- [`using(\Sujip\Xero\Accounting\Item\Item $item): Sujip\Xero\Accounting\Item\Payload`](../../src/Accounting/Item/Payload.php#L66)
- [`save(): Sujip\Xero\Accounting\Item\Item`](../../src/Accounting/Item/Payload.php#L74)

## Accounting\Item\Purchase

[Source](../../src/Accounting/Item/Purchase.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `UnitPrice` | int, float, or null | `()` |
| `AccountCode` | string or null | `()` |
| `COGSAccountCode` | string or null | `()` |
| `TaxType` | string or null | `()` |

### Public methods

- [`getUnitPrice(): int\|float\|null`](../../src/Accounting/Item/Purchase.php#L21)
- [`setUnitPrice(int\|float\|null $unitPrice): Sujip\Xero\Accounting\Item\Purchase`](../../src/Accounting/Item/Purchase.php#L26)
- [`getAccountCode(): ?string`](../../src/Accounting/Item/Purchase.php#L33)
- [`setAccountCode(?string $accountCode): Sujip\Xero\Accounting\Item\Purchase`](../../src/Accounting/Item/Purchase.php#L38)
- [`getCOGSAccountCode(): ?string`](../../src/Accounting/Item/Purchase.php#L45)
- [`setCOGSAccountCode(?string $cOGSAccountCode): Sujip\Xero\Accounting\Item\Purchase`](../../src/Accounting/Item/Purchase.php#L50)
- [`getTaxType(): ?string`](../../src/Accounting/Item/Purchase.php#L57)
- [`setTaxType(?string $taxType): Sujip\Xero\Accounting\Item\Purchase`](../../src/Accounting/Item/Purchase.php#L62)
- [`toRequest(): array`](../../src/Accounting/Item/Purchase.php#L85)

## Accounting\Journal\Journal

[Source](../../src/Accounting/Journal/Journal.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `JournalID` | string or null | `()` |
| `JournalDate` | string or null | `()` |
| `JournalNumber` | int, float, or null | `()` |
| `CreatedDateUTC` | string or null | `()` |
| `Reference` | string or null | `()` |
| `SourceType` | string or null | `()` |
| `SourceID` | string or null | `()` |
| `JournalLines` | list of objects ([Accounting\Journal\JournalLine](accounting.md#accountingjournaljournalline)) | `()` |

### Public methods

- [`getJournalID(): ?string`](../../src/Accounting/Journal/Journal.php#L31)
- [`setJournalID(?string $journalID): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journal.php#L36)
- [`getJournalDate(): ?string`](../../src/Accounting/Journal/Journal.php#L43)
- [`setJournalDate(?string $journalDate): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journal.php#L48)
- [`getJournalNumber(): ?int`](../../src/Accounting/Journal/Journal.php#L55)
- [`setJournalNumber(?int $journalNumber): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journal.php#L60)
- [`getCreatedDateUTC(): ?string`](../../src/Accounting/Journal/Journal.php#L67)
- [`setCreatedDateUTC(?string $createdDateUTC): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journal.php#L72)
- [`getReference(): ?string`](../../src/Accounting/Journal/Journal.php#L79)
- [`setReference(?string $reference): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journal.php#L84)
- [`getSourceType(): ?string`](../../src/Accounting/Journal/Journal.php#L91)
- [`setSourceType(?string $sourceType): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journal.php#L96)
- [`getSourceID(): ?string`](../../src/Accounting/Journal/Journal.php#L103)
- [`setSourceID(?string $sourceID): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journal.php#L108)
- [`getJournalLines(): array`](../../src/Accounting/Journal/Journal.php#L118)
- [`addJournalLine(\Sujip\Xero\Accounting\Journal\JournalLine $journalLine): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journal.php#L123)

## Accounting\Journal\JournalLine

[Source](../../src/Accounting/Journal/JournalLine.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `JournalLineID` | string or null | `()` |
| `AccountID` | string or null | `()` |
| `AccountCode` | string or null | `()` |
| `AccountType` | string or null | `()` |
| `AccountName` | string or null | `()` |
| `Description` | string or null | `()` |
| `NetAmount` | int, float, or null | `()` |
| `GrossAmount` | int, float, or null | `()` |
| `TaxAmount` | int, float, or null | `()` |
| `TaxType` | string or null | `()` |
| `TaxName` | string or null | `()` |
| `TrackingCategories` | list of objects ([Accounting\TrackingCategory\TrackingCategory](accounting.md#accountingtrackingcategorytrackingcategory)) | `()` |

### Public methods

- [`getJournalLineID(): ?string`](../../src/Accounting/Journal/JournalLine.php#L40)
- [`setJournalLineID(?string $journalLineID): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L45)
- [`getAccountID(): ?string`](../../src/Accounting/Journal/JournalLine.php#L52)
- [`setAccountID(?string $accountID): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L57)
- [`getAccountCode(): ?string`](../../src/Accounting/Journal/JournalLine.php#L64)
- [`setAccountCode(?string $accountCode): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L69)
- [`getAccountType(): ?string`](../../src/Accounting/Journal/JournalLine.php#L76)
- [`setAccountType(?string $accountType): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L81)
- [`getAccountName(): ?string`](../../src/Accounting/Journal/JournalLine.php#L88)
- [`setAccountName(?string $accountName): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L93)
- [`getDescription(): ?string`](../../src/Accounting/Journal/JournalLine.php#L100)
- [`setDescription(?string $description): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L105)
- [`getNetAmount(): int\|float\|null`](../../src/Accounting/Journal/JournalLine.php#L112)
- [`setNetAmount(int\|float\|null $netAmount): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L117)
- [`getGrossAmount(): int\|float\|null`](../../src/Accounting/Journal/JournalLine.php#L124)
- [`setGrossAmount(int\|float\|null $grossAmount): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L129)
- [`getTaxAmount(): int\|float\|null`](../../src/Accounting/Journal/JournalLine.php#L136)
- [`setTaxAmount(int\|float\|null $taxAmount): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L141)
- [`getTaxType(): ?string`](../../src/Accounting/Journal/JournalLine.php#L148)
- [`setTaxType(?string $taxType): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L153)
- [`getTaxName(): ?string`](../../src/Accounting/Journal/JournalLine.php#L160)
- [`setTaxName(?string $taxName): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L165)
- [`getTrackingCategories(): array`](../../src/Accounting/Journal/JournalLine.php#L175)
- [`addTrackingCategory(\Sujip\Xero\Accounting\TrackingCategory\TrackingCategory $trackingCategory): Sujip\Xero\Accounting\Journal\JournalLine`](../../src/Accounting/Journal/JournalLine.php#L180)

## Accounting\Journal\Journals

[Source](../../src/Accounting/Journal/Journals.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Journal/Journals.php#L18)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Journal/Journals.php#L19)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Journal/Journals.php#L23)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Journal/Journals.php#L27)
- [`offset(int $journalNumber): Sujip\Xero\Accounting\Journal\Journals`](../../src/Accounting/Journal/Journals.php#L31)
- [`ids(string ...$ids): static`](../../src/Accounting/Journal/Journals.php#L35)
- [`paymentsOnly(bool $paymentsOnly = true): Sujip\Xero\Accounting\Journal\Journals`](../../src/Accounting/Journal/Journals.php#L39)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Journal/Journals.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Journal/Journals.php#L50)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Journal/Journals.php#L51)
- [`find(string $journalId): ?\Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journals.php#L67)
- [`number(int $journalNumber): ?\Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journals.php#L79)
- [`mapJournal(array $payload): Sujip\Xero\Accounting\Journal\Journal`](../../src/Accounting/Journal/Journals.php#L94)

## Accounting\LinkedTransaction\LinkedTransaction

[Source](../../src/Accounting/LinkedTransaction/LinkedTransaction.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `LinkedTransactionID` | string or null | `()` |
| `SourceTransactionID` | string or null | `()` |
| `SourceLineItemID` | string or null | `()` |
| `TargetTransactionID` | string or null | `()` |
| `TargetLineItemID` | string or null | `()` |
| `ContactID` | string or null | `()` |
| `Status` | string or null | `()` |
| `Type` | string or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `SourceTransactionTypeCode` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`getLinkedTransactionID(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L39)
- [`setLinkedTransactionID(?string $linkedTransactionID): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L44)
- [`getSourceTransactionID(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L51)
- [`setSourceTransactionID(?string $sourceTransactionID): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L56)
- [`getSourceLineItemID(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L63)
- [`setSourceLineItemID(?string $sourceLineItemID): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L68)
- [`getTargetTransactionID(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L75)
- [`setTargetTransactionID(?string $targetTransactionID): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L80)
- [`getTargetLineItemID(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L87)
- [`setTargetLineItemID(?string $targetLineItemID): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L92)
- [`getContactID(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L99)
- [`setContactID(?string $contactID): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L104)
- [`getStatus(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L111)
- [`setStatus(?string $status): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L116)
- [`getType(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L123)
- [`setType(?string $type): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L128)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L135)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L140)
- [`getSourceTransactionTypeCode(): ?string`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L147)
- [`setSourceTransactionTypeCode(?string $sourceTransactionTypeCode): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L152)
- [`getValidationErrors(): array`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L162)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L167)
- [`toRequest(): array`](../../src/Accounting/LinkedTransaction/LinkedTransaction.php#L197)

## Accounting\LinkedTransaction\LinkedTransactions

[Source](../../src/Accounting/LinkedTransaction/LinkedTransactions.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L13)
- [`perPage(int $perPage): static`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L23)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L28)
- [`linkedTransactionId(string $id): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransactions`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L36)
- [`sourceTransaction(string $id): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransactions`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L44)
- [`targetTransaction(string $id): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransactions`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L52)
- [`contact(string $contactId): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransactions`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L60)
- [`status(string $status): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransactions`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L68)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L79)
- [`find(string $linkedTransactionId): ?\Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L95)
- [`create(): Sujip\Xero\Accounting\LinkedTransaction\Payload`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L107)
- [`update(string $linkedTransactionId): Sujip\Xero\Accounting\LinkedTransaction\Payload`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L112)
- [`delete(string $linkedTransactionId): void`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L117)
- [`mapLinkedTransaction(array $payload): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/LinkedTransactions.php#L127)

## Accounting\LinkedTransaction\Payload

[Source](../../src/Accounting/LinkedTransaction/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/LinkedTransaction/Payload.php#L16)
- [`id(string $id): Sujip\Xero\Accounting\LinkedTransaction\Payload`](../../src/Accounting/LinkedTransaction/Payload.php#L22)
- [`sourceTransaction(string $id): Sujip\Xero\Accounting\LinkedTransaction\Payload`](../../src/Accounting/LinkedTransaction/Payload.php#L30)
- [`targetTransaction(string $id): Sujip\Xero\Accounting\LinkedTransaction\Payload`](../../src/Accounting/LinkedTransaction/Payload.php#L39)
- [`contact(string $contactId): Sujip\Xero\Accounting\LinkedTransaction\Payload`](../../src/Accounting/LinkedTransaction/Payload.php#L48)
- [`using(\Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction $linkedTransaction): Sujip\Xero\Accounting\LinkedTransaction\Payload`](../../src/Accounting/LinkedTransaction/Payload.php#L57)
- [`save(): Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction`](../../src/Accounting/LinkedTransaction/Payload.php#L65)

## Accounting\ManualJournal\Attachment

[Source](../../src/Accounting/ManualJournal/Attachment.php)

### Public methods

- [`__construct(?string $fileName, ?string $url, array $raw = array (
))`](../../src/Accounting/ManualJournal/Attachment.php#L12)

## Accounting\ManualJournal\Attachments

[Source](../../src/Accounting/ManualJournal/Attachments.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $manualJournalId)`](../../src/Accounting/ManualJournal/Attachments.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/ManualJournal/Attachments.php#L22)
- [`upload(string $fileName, string $content): Sujip\Xero\Accounting\ManualJournal\Upload`](../../src/Accounting/ManualJournal/Attachments.php#L41)
- [`download(string $fileName, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/ManualJournal/Attachments.php#L46)
- [`downloadById(string $attachmentId, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/ManualJournal/Attachments.php#L58)

## Accounting\ManualJournal\JournalLine

[Source](../../src/Accounting/ManualJournal/JournalLine.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `LineAmount` | int, float, or null | `()` |
| `AccountCode` | string or null | `()` |
| `AccountID` | string or null | `()` |
| `Description` | string or null | `()` |
| `TaxType` | string or null | `()` |
| `TaxAmount` | int, float, or null | `()` |
| `IsBlank` | bool or null | `()` |
| `Tracking` | list of objects ([Accounting\TrackingCategory\TrackingCategory](accounting.md#accountingtrackingcategorytrackingcategory)) | `()` |

### Public methods

- [`getLineAmount(): int\|float\|null`](../../src/Accounting/ManualJournal/JournalLine.php#L33)
- [`setLineAmount(int\|float\|null $lineAmount): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/JournalLine.php#L38)
- [`getAccountCode(): ?string`](../../src/Accounting/ManualJournal/JournalLine.php#L45)
- [`setAccountCode(?string $accountCode): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/JournalLine.php#L50)
- [`getAccountID(): ?string`](../../src/Accounting/ManualJournal/JournalLine.php#L57)
- [`setAccountID(?string $accountID): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/JournalLine.php#L62)
- [`getDescription(): ?string`](../../src/Accounting/ManualJournal/JournalLine.php#L69)
- [`setDescription(?string $description): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/JournalLine.php#L74)
- [`getTaxType(): ?string`](../../src/Accounting/ManualJournal/JournalLine.php#L81)
- [`setTaxType(?string $taxType): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/JournalLine.php#L86)
- [`getTaxAmount(): int\|float\|null`](../../src/Accounting/ManualJournal/JournalLine.php#L93)
- [`setTaxAmount(int\|float\|null $taxAmount): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/JournalLine.php#L98)
- [`getIsBlank(): ?bool`](../../src/Accounting/ManualJournal/JournalLine.php#L105)
- [`setIsBlank(?bool $isBlank): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/JournalLine.php#L110)
- [`getTracking(): array`](../../src/Accounting/ManualJournal/JournalLine.php#L120)
- [`addTracking(\Sujip\Xero\Accounting\TrackingCategory\TrackingCategory $tracking): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/JournalLine.php#L125)
- [`toRequest(): array`](../../src/Accounting/ManualJournal/JournalLine.php#L152)

## Accounting\ManualJournal\ManualJournal

[Source](../../src/Accounting/ManualJournal/ManualJournal.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `ManualJournalID` | string or null | `()` |
| `Status` | string or null | `()` |
| `Narration` | string or null | `()` |
| `JournalLines` | list of objects ([Accounting\ManualJournal\JournalLine](accounting.md#accountingmanualjournaljournalline)) | `()` |
| `Date` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `Url` | string or null | `()` |
| `ShowOnCashBasisReports` | bool or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `Warnings` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `Attachments` | list of objects ([Support\AttachmentDetail](support.md#supportattachmentdetail)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/ManualJournal/ManualJournal.php#L18)
- [`getManualJournalID(): ?string`](../../src/Accounting/ManualJournal/ManualJournal.php#L63)
- [`setManualJournalID(?string $manualJournalID): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L68)
- [`getStatus(): ?string`](../../src/Accounting/ManualJournal/ManualJournal.php#L75)
- [`setStatus(?string $status): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L80)
- [`getNarration(): ?string`](../../src/Accounting/ManualJournal/ManualJournal.php#L87)
- [`setNarration(?string $narration): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L92)
- [`getJournalLines(): array`](../../src/Accounting/ManualJournal/ManualJournal.php#L102)
- [`setJournalLines(array $journalLines): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L110)
- [`addJournalLine(\Sujip\Xero\Accounting\ManualJournal\JournalLine $journalLine): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L117)
- [`getDate(): ?string`](../../src/Accounting/ManualJournal/ManualJournal.php#L124)
- [`setDate(?string $date): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L129)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/ManualJournal/ManualJournal.php#L136)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L141)
- [`getUrl(): ?string`](../../src/Accounting/ManualJournal/ManualJournal.php#L148)
- [`setUrl(?string $url): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L153)
- [`getShowOnCashBasisReports(): ?bool`](../../src/Accounting/ManualJournal/ManualJournal.php#L160)
- [`setShowOnCashBasisReports(?bool $showOnCashBasisReports): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L165)
- [`getHasAttachments(): ?bool`](../../src/Accounting/ManualJournal/ManualJournal.php#L172)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L177)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/ManualJournal/ManualJournal.php#L184)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L189)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/ManualJournal/ManualJournal.php#L196)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L201)
- [`getWarnings(): array`](../../src/Accounting/ManualJournal/ManualJournal.php#L211)
- [`addWarning(\Sujip\Xero\Support\ValidationError $warning): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L216)
- [`getValidationErrors(): array`](../../src/Accounting/ManualJournal/ManualJournal.php#L226)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L231)
- [`getAttachments(): array`](../../src/Accounting/ManualJournal/ManualJournal.php#L241)
- [`addAttachment(\Sujip\Xero\Support\AttachmentDetail $attachment): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L246)
- [`toRequest(): array`](../../src/Accounting/ManualJournal/ManualJournal.php#L279)
- [`narration(string $narration): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L296)
- [`line(int\|float $lineAmount, string $accountCode, bool $isDebit = true): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L301)
- [`save(): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournal.php#L310)
- [`attachments(): Sujip\Xero\Accounting\ManualJournal\Attachments`](../../src/Accounting/ManualJournal/ManualJournal.php#L321)
- [`history(): Sujip\Xero\Accounting\History`](../../src/Accounting/ManualJournal/ManualJournal.php#L330)

## Accounting\ManualJournal\ManualJournals

[Source](../../src/Accounting/ManualJournal/ManualJournals.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/ManualJournal/ManualJournals.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/ManualJournal/ManualJournals.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/ManualJournal/ManualJournals.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/ManualJournal/ManualJournals.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/ManualJournal/ManualJournals.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/ManualJournal/ManualJournals.php#L30)
- [`ids(string ...$ids): static`](../../src/Accounting/ManualJournal/ManualJournals.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\ManualJournal\ManualJournals`](../../src/Accounting/ManualJournal/ManualJournals.php#L38)
- [`unitDp(int $unitDp): static`](../../src/Accounting/ManualJournal/ManualJournals.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/ManualJournal/ManualJournals.php#L49)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/ManualJournal/ManualJournals.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/ManualJournal/ManualJournals.php#L69)
- [`find(string $manualJournalId): ?\Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournals.php#L81)
- [`create(): Sujip\Xero\Accounting\ManualJournal\Payload`](../../src/Accounting/ManualJournal/ManualJournals.php#L93)
- [`update(string $manualJournalId): Sujip\Xero\Accounting\ManualJournal\Payload`](../../src/Accounting/ManualJournal/ManualJournals.php#L98)
- [`attachments(string $manualJournalId): Sujip\Xero\Accounting\ManualJournal\Attachments`](../../src/Accounting/ManualJournal/ManualJournals.php#L103)
- [`history(string $manualJournalId): Sujip\Xero\Accounting\History`](../../src/Accounting/ManualJournal/ManualJournals.php#L108)
- [`mapManualJournal(array $payload): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/ManualJournals.php#L116)
- [`mapJournalLine(array $payload): Sujip\Xero\Accounting\ManualJournal\JournalLine`](../../src/Accounting/ManualJournal/ManualJournals.php#L124)

## Accounting\ManualJournal\Payload

[Source](../../src/Accounting/ManualJournal/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/ManualJournal/Payload.php#L14)
- [`id(string $manualJournalId): Sujip\Xero\Accounting\ManualJournal\Payload`](../../src/Accounting/ManualJournal/Payload.php#L20)
- [`narration(string $narration): Sujip\Xero\Accounting\ManualJournal\Payload`](../../src/Accounting/ManualJournal/Payload.php#L29)
- [`line(int\|float $lineAmount, string $accountCode, bool $isDebit = true): Sujip\Xero\Accounting\ManualJournal\Payload`](../../src/Accounting/ManualJournal/Payload.php#L38)
- [`using(\Sujip\Xero\Accounting\ManualJournal\ManualJournal $manualJournal): Sujip\Xero\Accounting\ManualJournal\Payload`](../../src/Accounting/ManualJournal/Payload.php#L51)
- [`save(): Sujip\Xero\Accounting\ManualJournal\ManualJournal`](../../src/Accounting/ManualJournal/Payload.php#L59)

## Accounting\ManualJournal\Upload

[Source](../../src/Accounting/ManualJournal/Upload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $manualJournalId, string $fileName, string $content, ?string $mimeType = NULL)`](../../src/Accounting/ManualJournal/Upload.php#L12)
- [`mimeType(string $mimeType): Sujip\Xero\Accounting\ManualJournal\Upload`](../../src/Accounting/ManualJournal/Upload.php#L21)
- [`save(): Sujip\Xero\Accounting\ManualJournal\Attachment`](../../src/Accounting/ManualJournal/Upload.php#L26)

## Accounting\Organisation\Bill

[Source](../../src/Accounting/Organisation/Bill.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Day` | int, float, or null | `()` |
| `Type` | string or null | `()` |

### Public methods

- [`getDay(): ?int`](../../src/Accounting/Organisation/Bill.php#L17)
- [`setDay(?int $day): Sujip\Xero\Accounting\Organisation\Bill`](../../src/Accounting/Organisation/Bill.php#L22)
- [`getType(): ?string`](../../src/Accounting/Organisation/Bill.php#L29)
- [`setType(?string $type): Sujip\Xero\Accounting\Organisation\Bill`](../../src/Accounting/Organisation/Bill.php#L34)
- [`toRequest(): array`](../../src/Accounting/Organisation/Bill.php#L55)

## Accounting\Organisation\CisOrgSetting

[Source](../../src/Accounting/Organisation/CisOrgSetting.php)

### Public methods

- [`__construct(?bool $cisContractorEnabled, ?bool $cisSubContractorEnabled, ?float $rate, array $raw = array (
))`](../../src/Accounting/Organisation/CisOrgSetting.php#L12)

## Accounting\Organisation\ExternalLink

[Source](../../src/Accounting/Organisation/ExternalLink.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `LinkType` | string or null | `()` |
| `Url` | string or null | `()` |
| `Description` | string or null | `()` |

### Public methods

- [`getLinkType(): ?string`](../../src/Accounting/Organisation/ExternalLink.php#L18)
- [`setLinkType(?string $linkType): Sujip\Xero\Accounting\Organisation\ExternalLink`](../../src/Accounting/Organisation/ExternalLink.php#L23)
- [`getUrl(): ?string`](../../src/Accounting/Organisation/ExternalLink.php#L30)
- [`setUrl(?string $url): Sujip\Xero\Accounting\Organisation\ExternalLink`](../../src/Accounting/Organisation/ExternalLink.php#L35)
- [`getDescription(): ?string`](../../src/Accounting/Organisation/ExternalLink.php#L42)
- [`setDescription(?string $description): Sujip\Xero\Accounting\Organisation\ExternalLink`](../../src/Accounting/Organisation/ExternalLink.php#L47)

## Accounting\Organisation\Organisation

[Source](../../src/Accounting/Organisation/Organisation.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `OrganisationID` | string or null | `()` |
| `APIKey` | string or null | `()` |
| `Name` | string or null | `()` |
| `LegalName` | string or null | `()` |
| `PaysTax` | bool or null | `()` |
| `Version` | string or null | `()` |
| `OrganisationType` | string or null | `()` |
| `BaseCurrency` | string or null | `()` |
| `CountryCode` | string or null | `()` |
| `IsDemoCompany` | bool or null | `()` |
| `OrganisationStatus` | string or null | `()` |
| `RegistrationNumber` | string or null | `()` |
| `EmployerIdentificationNumber` | string or null | `()` |
| `TaxNumber` | string or null | `()` |
| `FinancialYearEndDay` | int, float, or null | `()` |
| `FinancialYearEndMonth` | int, float, or null | `()` |
| `SalesTaxBasis` | string or null | `()` |
| `SalesTaxPeriod` | string or null | `()` |
| `DefaultSalesTax` | string or null | `()` |
| `DefaultPurchasesTax` | string or null | `()` |
| `PeriodLockDate` | string or null | `()` |
| `EndOfYearLockDate` | string or null | `()` |
| `CreatedDateUTC` | string or null | `()` |
| `Timezone` | string or null | `()` |
| `OrganisationEntityType` | string or null | `()` |
| `Class` | string or null | `()` |
| `Edition` | string or null | `()` |
| `LineOfBusiness` | string or null | `()` |
| `ShortCode` | string or null | `()` |
| `Addresses` | list of objects ([Accounting\Contact\Address](accounting.md#accountingcontactaddress)) | `()` |
| `Phones` | list of objects ([Accounting\Contact\Phone](accounting.md#accountingcontactphone)) | `()` |
| `ExternalLinks` | list of objects ([Accounting\Organisation\ExternalLink](accounting.md#accountingorganisationexternallink)) | `()` |
| `PaymentTerms` | object or null ([Accounting\Organisation\PaymentTerm](accounting.md#accountingorganisationpaymentterm)) | `()` |

### Public methods

- [`getOrganisationID(): ?string`](../../src/Accounting/Organisation/Organisation.php#L89)
- [`setOrganisationID(?string $organisationID): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L94)
- [`getApiKey(): ?string`](../../src/Accounting/Organisation/Organisation.php#L101)
- [`setApiKey(?string $apiKey): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L106)
- [`getName(): ?string`](../../src/Accounting/Organisation/Organisation.php#L113)
- [`setName(?string $name): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L118)
- [`getLegalName(): ?string`](../../src/Accounting/Organisation/Organisation.php#L125)
- [`setLegalName(?string $legalName): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L130)
- [`getPaysTax(): ?bool`](../../src/Accounting/Organisation/Organisation.php#L137)
- [`setPaysTax(?bool $paysTax): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L142)
- [`getVersion(): ?string`](../../src/Accounting/Organisation/Organisation.php#L149)
- [`setVersion(?string $version): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L154)
- [`getOrganisationType(): ?string`](../../src/Accounting/Organisation/Organisation.php#L161)
- [`setOrganisationType(?string $organisationType): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L166)
- [`getBaseCurrency(): ?string`](../../src/Accounting/Organisation/Organisation.php#L173)
- [`setBaseCurrency(?string $baseCurrency): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L178)
- [`getCountryCode(): ?string`](../../src/Accounting/Organisation/Organisation.php#L185)
- [`setCountryCode(?string $countryCode): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L190)
- [`getIsDemoCompany(): ?bool`](../../src/Accounting/Organisation/Organisation.php#L197)
- [`setIsDemoCompany(?bool $isDemoCompany): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L202)
- [`getOrganisationStatus(): ?string`](../../src/Accounting/Organisation/Organisation.php#L209)
- [`setOrganisationStatus(?string $organisationStatus): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L214)
- [`getRegistrationNumber(): ?string`](../../src/Accounting/Organisation/Organisation.php#L221)
- [`setRegistrationNumber(?string $registrationNumber): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L226)
- [`getEmployerIdentificationNumber(): ?string`](../../src/Accounting/Organisation/Organisation.php#L233)
- [`setEmployerIdentificationNumber(?string $employerIdentificationNumber): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L238)
- [`getTaxNumber(): ?string`](../../src/Accounting/Organisation/Organisation.php#L245)
- [`setTaxNumber(?string $taxNumber): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L250)
- [`getFinancialYearEndDay(): ?int`](../../src/Accounting/Organisation/Organisation.php#L257)
- [`setFinancialYearEndDay(?int $financialYearEndDay): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L262)
- [`getFinancialYearEndMonth(): ?int`](../../src/Accounting/Organisation/Organisation.php#L269)
- [`setFinancialYearEndMonth(?int $financialYearEndMonth): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L274)
- [`getSalesTaxBasis(): ?string`](../../src/Accounting/Organisation/Organisation.php#L281)
- [`setSalesTaxBasis(?string $salesTaxBasis): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L286)
- [`getSalesTaxPeriod(): ?string`](../../src/Accounting/Organisation/Organisation.php#L293)
- [`setSalesTaxPeriod(?string $salesTaxPeriod): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L298)
- [`getDefaultSalesTax(): ?string`](../../src/Accounting/Organisation/Organisation.php#L305)
- [`setDefaultSalesTax(?string $defaultSalesTax): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L310)
- [`getDefaultPurchasesTax(): ?string`](../../src/Accounting/Organisation/Organisation.php#L317)
- [`setDefaultPurchasesTax(?string $defaultPurchasesTax): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L322)
- [`getPeriodLockDate(): ?string`](../../src/Accounting/Organisation/Organisation.php#L329)
- [`setPeriodLockDate(?string $periodLockDate): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L334)
- [`getEndOfYearLockDate(): ?string`](../../src/Accounting/Organisation/Organisation.php#L341)
- [`setEndOfYearLockDate(?string $endOfYearLockDate): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L346)
- [`getCreatedDateUTC(): ?string`](../../src/Accounting/Organisation/Organisation.php#L353)
- [`setCreatedDateUTC(?string $createdDateUTC): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L358)
- [`getTimezone(): ?string`](../../src/Accounting/Organisation/Organisation.php#L365)
- [`setTimezone(?string $timezone): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L370)
- [`getOrganisationEntityType(): ?string`](../../src/Accounting/Organisation/Organisation.php#L377)
- [`setOrganisationEntityType(?string $organisationEntityType): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L382)
- [`getClass(): ?string`](../../src/Accounting/Organisation/Organisation.php#L389)
- [`setClass(?string $class): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L394)
- [`getEdition(): ?string`](../../src/Accounting/Organisation/Organisation.php#L401)
- [`setEdition(?string $edition): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L406)
- [`getLineOfBusiness(): ?string`](../../src/Accounting/Organisation/Organisation.php#L413)
- [`setLineOfBusiness(?string $lineOfBusiness): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L418)
- [`getShortCode(): ?string`](../../src/Accounting/Organisation/Organisation.php#L425)
- [`setShortCode(?string $shortCode): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L430)
- [`getAddresses(): array`](../../src/Accounting/Organisation/Organisation.php#L440)
- [`addAddress(\Sujip\Xero\Accounting\Contact\Address $address): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L445)
- [`getPhones(): array`](../../src/Accounting/Organisation/Organisation.php#L455)
- [`addPhone(\Sujip\Xero\Accounting\Contact\Phone $phone): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L460)
- [`getExternalLinks(): array`](../../src/Accounting/Organisation/Organisation.php#L470)
- [`addExternalLink(\Sujip\Xero\Accounting\Organisation\ExternalLink $externalLink): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L475)
- [`getPaymentTerms(): ?\Sujip\Xero\Accounting\Organisation\PaymentTerm`](../../src/Accounting/Organisation/Organisation.php#L482)
- [`setPaymentTerms(?\Sujip\Xero\Accounting\Organisation\PaymentTerm $paymentTerms): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisation.php#L487)

## Accounting\Organisation\OrganisationAction

[Source](../../src/Accounting/Organisation/OrganisationAction.php)

### Public methods

- [`__construct(?string $name, ?string $status)`](../../src/Accounting/Organisation/OrganisationAction.php#L9)
- [`isAllowed(): bool`](../../src/Accounting/Organisation/OrganisationAction.php#L15)

## Accounting\Organisation\Organisations

[Source](../../src/Accounting/Organisation/Organisations.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Organisation/Organisations.php#L15)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Organisation/Organisations.php#L20)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Organisation/Organisations.php#L31)
- [`current(): ?\Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisations.php#L46)
- [`actions(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Organisation/Organisations.php#L54)
- [`cisSettings(string $organisationId): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Organisation/Organisations.php#L75)
- [`mapOrganisation(array $payload): Sujip\Xero\Accounting\Organisation\Organisation`](../../src/Accounting/Organisation/Organisations.php#L98)

## Accounting\Organisation\PaymentTerm

[Source](../../src/Accounting/Organisation/PaymentTerm.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Bills` | object or null ([Accounting\Organisation\Bill](accounting.md#accountingorganisationbill)) | `()` |
| `Sales` | object or null ([Accounting\Organisation\Bill](accounting.md#accountingorganisationbill)) | `()` |

### Public methods

- [`getBills(): ?\Sujip\Xero\Accounting\Organisation\Bill`](../../src/Accounting/Organisation/PaymentTerm.php#L17)
- [`setBills(?\Sujip\Xero\Accounting\Organisation\Bill $bills): Sujip\Xero\Accounting\Organisation\PaymentTerm`](../../src/Accounting/Organisation/PaymentTerm.php#L22)
- [`getSales(): ?\Sujip\Xero\Accounting\Organisation\Bill`](../../src/Accounting/Organisation/PaymentTerm.php#L29)
- [`setSales(?\Sujip\Xero\Accounting\Organisation\Bill $sales): Sujip\Xero\Accounting\Organisation\PaymentTerm`](../../src/Accounting/Organisation/PaymentTerm.php#L34)
- [`toRequest(): array`](../../src/Accounting/Organisation/PaymentTerm.php#L55)

## Accounting\Overpayment\Overpayment

[Source](../../src/Accounting/Overpayment/Overpayment.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `OverpaymentID` | string or null | `()` |
| `Type` | string or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `Date` | string or null | `()` |
| `Status` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `Total` | int, float, or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `UpdatedDateUTCString` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `RemainingCredit` | int, float, or null | `()` |
| `Allocations` | list of objects ([Accounting\Allocation](accounting.md#accountingallocation)) | `()` |
| `AppliedAmount` | int, float, or null | `()` |
| `Payments` | list of objects ([Accounting\Payment\Payment](accounting.md#accountingpaymentpayment)) | `()` |
| `HasAttachments` | bool or null | `()` |
| `Reference` | string or null | `()` |
| `Attachments` | list of objects ([Support\AttachmentDetail](support.md#supportattachmentdetail)) | `()` |

### Public methods

- [`getOverpaymentID(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L71)
- [`setOverpaymentID(?string $overpaymentID): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L76)
- [`getType(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L83)
- [`setType(?string $type): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L88)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Overpayment/Overpayment.php#L95)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L100)
- [`getDate(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L107)
- [`setDate(?string $date): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L112)
- [`getStatus(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L119)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L124)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L131)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L136)
- [`getLineItems(): array`](../../src/Accounting/Overpayment/Overpayment.php#L146)
- [`setLineItems(array $lineItems): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L154)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L161)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/Overpayment/Overpayment.php#L168)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L173)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/Overpayment/Overpayment.php#L180)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L185)
- [`getTotal(): int\|float\|null`](../../src/Accounting/Overpayment/Overpayment.php#L192)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L197)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L204)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L209)
- [`getUpdatedDateUTCString(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L216)
- [`setUpdatedDateUTCString(?string $updatedDateUTCString): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L221)
- [`getCurrencyCode(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L228)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L233)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/Overpayment/Overpayment.php#L240)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L245)
- [`getRemainingCredit(): int\|float\|null`](../../src/Accounting/Overpayment/Overpayment.php#L252)
- [`setRemainingCredit(int\|float\|null $remainingCredit): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L257)
- [`getAllocations(): array`](../../src/Accounting/Overpayment/Overpayment.php#L267)
- [`addAllocation(\Sujip\Xero\Accounting\Allocation $allocation): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L272)
- [`getAppliedAmount(): int\|float\|null`](../../src/Accounting/Overpayment/Overpayment.php#L279)
- [`setAppliedAmount(int\|float\|null $appliedAmount): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L284)
- [`getPayments(): array`](../../src/Accounting/Overpayment/Overpayment.php#L294)
- [`addPayment(\Sujip\Xero\Accounting\Payment\Payment $payment): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L299)
- [`getHasAttachments(): ?bool`](../../src/Accounting/Overpayment/Overpayment.php#L306)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L311)
- [`getReference(): ?string`](../../src/Accounting/Overpayment/Overpayment.php#L318)
- [`setReference(?string $reference): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L323)
- [`getAttachments(): array`](../../src/Accounting/Overpayment/Overpayment.php#L333)
- [`addAttachment(\Sujip\Xero\Support\AttachmentDetail $attachment): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayment.php#L338)

## Accounting\Overpayment\Overpayments

[Source](../../src/Accounting/Overpayment/Overpayments.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/Overpayment/Overpayments.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Overpayment/Overpayments.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/Overpayment/Overpayments.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Overpayment/Overpayments.php#L26)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Overpayment/Overpayments.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Overpayment/Overpayments.php#L31)
- [`ids(string ...$ids): static`](../../src/Accounting/Overpayment/Overpayments.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Overpayment\Overpayments`](../../src/Accounting/Overpayment/Overpayments.php#L39)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Overpayment/Overpayments.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Overpayment/Overpayments.php#L50)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Overpayment/Overpayments.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/Overpayment/Overpayments.php#L70)
- [`find(string $overpaymentId): ?\Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayments.php#L82)
- [`allocations(string $overpaymentId): Sujip\Xero\Accounting\Allocations`](../../src/Accounting/Overpayment/Overpayments.php#L94)
- [`history(string $overpaymentId): Sujip\Xero\Accounting\History`](../../src/Accounting/Overpayment/Overpayments.php#L99)
- [`mapOverpayment(array $payload): Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Overpayment/Overpayments.php#L107)

## Accounting\PaymentService\Payload

[Source](../../src/Accounting/PaymentService/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/PaymentService/Payload.php#L19)
- [`name(string $name): Sujip\Xero\Accounting\PaymentService\Payload`](../../src/Accounting/PaymentService/Payload.php#L24)
- [`url(string $url): Sujip\Xero\Accounting\PaymentService\Payload`](../../src/Accounting/PaymentService/Payload.php#L32)
- [`payNowText(string $payNowText): Sujip\Xero\Accounting\PaymentService\Payload`](../../src/Accounting/PaymentService/Payload.php#L40)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\PaymentService\Payload`](../../src/Accounting/PaymentService/Payload.php#L48)
- [`save(): Sujip\Xero\Accounting\PaymentService\PaymentService`](../../src/Accounting/PaymentService/Payload.php#L56)

## Accounting\PaymentService\PaymentService

[Source](../../src/Accounting/PaymentService/PaymentService.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PaymentServiceID` | string or null | `()` |
| `PaymentServiceType` | string or null | `()` |
| `PaymentServiceName` | string or null | `()` |
| `PaymentServiceUrl` | string or null | `()` |
| `PayNowText` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`getPaymentServiceID(): ?string`](../../src/Accounting/PaymentService/PaymentService.php#L28)
- [`setPaymentServiceID(?string $paymentServiceID): Sujip\Xero\Accounting\PaymentService\PaymentService`](../../src/Accounting/PaymentService/PaymentService.php#L33)
- [`getPaymentServiceType(): ?string`](../../src/Accounting/PaymentService/PaymentService.php#L40)
- [`setPaymentServiceType(?string $paymentServiceType): Sujip\Xero\Accounting\PaymentService\PaymentService`](../../src/Accounting/PaymentService/PaymentService.php#L45)
- [`getPaymentServiceName(): ?string`](../../src/Accounting/PaymentService/PaymentService.php#L52)
- [`setPaymentServiceName(?string $paymentServiceName): Sujip\Xero\Accounting\PaymentService\PaymentService`](../../src/Accounting/PaymentService/PaymentService.php#L57)
- [`getPaymentServiceUrl(): ?string`](../../src/Accounting/PaymentService/PaymentService.php#L64)
- [`setPaymentServiceUrl(?string $paymentServiceUrl): Sujip\Xero\Accounting\PaymentService\PaymentService`](../../src/Accounting/PaymentService/PaymentService.php#L69)
- [`getPayNowText(): ?string`](../../src/Accounting/PaymentService/PaymentService.php#L76)
- [`setPayNowText(?string $payNowText): Sujip\Xero\Accounting\PaymentService\PaymentService`](../../src/Accounting/PaymentService/PaymentService.php#L81)
- [`getValidationErrors(): array`](../../src/Accounting/PaymentService/PaymentService.php#L90)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\PaymentService\PaymentService`](../../src/Accounting/PaymentService/PaymentService.php#L95)

## Accounting\PaymentService\PaymentServices

[Source](../../src/Accounting/PaymentService/PaymentServices.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/PaymentService/PaymentServices.php#L15)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/PaymentService/PaymentServices.php#L20)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/PaymentService/PaymentServices.php#L31)
- [`create(): Sujip\Xero\Accounting\PaymentService\Payload`](../../src/Accounting/PaymentService/PaymentServices.php#L46)
- [`mapPaymentService(array $payload): Sujip\Xero\Accounting\PaymentService\PaymentService`](../../src/Accounting/PaymentService/PaymentServices.php#L54)

## Accounting\Payment\InvoiceReference

[Source](../../src/Accounting/Payment/InvoiceReference.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `InvoiceID` | string or null | `()` |

### Public methods

- [`getInvoiceID(): ?string`](../../src/Accounting/Payment/InvoiceReference.php#L14)
- [`setInvoiceID(?string $invoiceID): Sujip\Xero\Accounting\Payment\InvoiceReference`](../../src/Accounting/Payment/InvoiceReference.php#L19)

## Accounting\Payment\Payload

[Source](../../src/Accounting/Payment/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Payment/Payload.php#L14)
- [`invoice(string $invoiceId): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payload.php#L20)
- [`account(string $accountId): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payload.php#L29)
- [`date(string $date): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payload.php#L38)
- [`amount(int\|float $amount): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payload.php#L47)
- [`reference(string $reference): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payload.php#L56)
- [`id(string $paymentId): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payload.php#L65)
- [`setPaymentID(?string $paymentId): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payload.php#L74)
- [`using(\Sujip\Xero\Accounting\Payment\Payment $payment): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payload.php#L79)
- [`save(): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payload.php#L87)

## Accounting\Payment\Payment

[Source](../../src/Accounting/Payment/Payment.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PaymentID` | string or null | `()` |
| `Amount` | int, float, or null | `()` |
| `Date` | string or null | `()` |
| `Reference` | string or null | `()` |
| `Account` | object or null ([Accounting\Account\Account](accounting.md#accountingaccountaccount)) | `()` |
| `Invoice` | object or null ([Accounting\Payment\InvoiceReference](accounting.md#accountingpaymentinvoicereference)) | `applyInvoiceReference()` |
| `CreditNote` | object or null ([Accounting\CreditNote\CreditNote](accounting.md#accountingcreditnotecreditnote)) | `()` |
| `Prepayment` | object or null ([Accounting\Prepayment\Prepayment](accounting.md#accountingprepaymentprepayment)) | `()` |
| `Overpayment` | object or null ([Accounting\Overpayment\Overpayment](accounting.md#accountingoverpaymentoverpayment)) | `()` |
| `InvoiceNumber` | string or null | `()` |
| `CreditNoteNumber` | string or null | `()` |
| `BatchPayment` | object or null ([Accounting\BatchPayment\BatchPayment](accounting.md#accountingbatchpaymentbatchpayment)) | `()` |
| `BatchPaymentID` | string or null | `()` |
| `Code` | string or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `BankAmount` | int, float, or null | `()` |
| `IsReconciled` | bool or null | `()` |
| `Status` | string or null | `()` |
| `PaymentType` | string or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `UpdatedDateUTCString` | string or null | `()` |
| `BankAccountNumber` | string or null | `()` |
| `Particulars` | string or null | `()` |
| `Details` | string or null | `()` |
| `HasAccount` | bool or null | `()` |
| `HasValidationErrors` | bool or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `Warnings` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Payment/Payment.php#L86)
- [`getPaymentID(): ?string`](../../src/Accounting/Payment/Payment.php#L91)
- [`setPaymentID(?string $paymentID): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L96)
- [`getAmount(): ?float`](../../src/Accounting/Payment/Payment.php#L103)
- [`setAmount(int\|float\|null $amount): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L108)
- [`getDate(): ?string`](../../src/Accounting/Payment/Payment.php#L115)
- [`setDate(?string $date): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L120)
- [`getReference(): ?string`](../../src/Accounting/Payment/Payment.php#L127)
- [`setReference(?string $reference): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L132)
- [`getInvoiceID(): ?string`](../../src/Accounting/Payment/Payment.php#L139)
- [`setInvoiceID(?string $invoiceID): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L144)
- [`getAccount(): ?\Sujip\Xero\Accounting\Account\Account`](../../src/Accounting/Payment/Payment.php#L151)
- [`setAccount(?\Sujip\Xero\Accounting\Account\Account $account): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L156)
- [`getAccountID(): ?string`](../../src/Accounting/Payment/Payment.php#L163)
- [`setAccountID(?string $accountID): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L168)
- [`getCreditNote(): ?\Sujip\Xero\Accounting\CreditNote\CreditNote`](../../src/Accounting/Payment/Payment.php#L177)
- [`setCreditNote(?\Sujip\Xero\Accounting\CreditNote\CreditNote $creditNote): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L182)
- [`getPrepayment(): ?\Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Payment/Payment.php#L189)
- [`setPrepayment(?\Sujip\Xero\Accounting\Prepayment\Prepayment $prepayment): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L194)
- [`getOverpayment(): ?\Sujip\Xero\Accounting\Overpayment\Overpayment`](../../src/Accounting/Payment/Payment.php#L201)
- [`setOverpayment(?\Sujip\Xero\Accounting\Overpayment\Overpayment $overpayment): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L206)
- [`getInvoiceNumber(): ?string`](../../src/Accounting/Payment/Payment.php#L213)
- [`setInvoiceNumber(?string $invoiceNumber): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L218)
- [`getCreditNoteNumber(): ?string`](../../src/Accounting/Payment/Payment.php#L225)
- [`setCreditNoteNumber(?string $creditNoteNumber): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L230)
- [`getBatchPayment(): ?\Sujip\Xero\Accounting\BatchPayment\BatchPayment`](../../src/Accounting/Payment/Payment.php#L237)
- [`setBatchPayment(?\Sujip\Xero\Accounting\BatchPayment\BatchPayment $batchPayment): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L242)
- [`getBatchPaymentID(): ?string`](../../src/Accounting/Payment/Payment.php#L249)
- [`setBatchPaymentID(?string $batchPaymentID): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L254)
- [`getCode(): ?string`](../../src/Accounting/Payment/Payment.php#L261)
- [`setCode(?string $code): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L266)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/Payment/Payment.php#L273)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L278)
- [`getBankAmount(): int\|float\|null`](../../src/Accounting/Payment/Payment.php#L285)
- [`setBankAmount(int\|float\|null $bankAmount): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L290)
- [`getIsReconciled(): ?bool`](../../src/Accounting/Payment/Payment.php#L297)
- [`setIsReconciled(?bool $isReconciled): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L302)
- [`getStatus(): ?string`](../../src/Accounting/Payment/Payment.php#L309)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L314)
- [`getPaymentType(): ?string`](../../src/Accounting/Payment/Payment.php#L321)
- [`setPaymentType(?string $paymentType): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L326)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Payment/Payment.php#L333)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L338)
- [`getUpdatedDateUTCString(): ?string`](../../src/Accounting/Payment/Payment.php#L345)
- [`setUpdatedDateUTCString(?string $updatedDateUTCString): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L350)
- [`getBankAccountNumber(): ?string`](../../src/Accounting/Payment/Payment.php#L357)
- [`setBankAccountNumber(?string $bankAccountNumber): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L362)
- [`getParticulars(): ?string`](../../src/Accounting/Payment/Payment.php#L369)
- [`setParticulars(?string $particulars): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L374)
- [`getDetails(): ?string`](../../src/Accounting/Payment/Payment.php#L381)
- [`setDetails(?string $details): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L386)
- [`getHasAccount(): ?bool`](../../src/Accounting/Payment/Payment.php#L393)
- [`setHasAccount(?bool $hasAccount): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L398)
- [`getHasValidationErrors(): ?bool`](../../src/Accounting/Payment/Payment.php#L405)
- [`setHasValidationErrors(?bool $hasValidationErrors): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L410)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/Payment/Payment.php#L417)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L422)
- [`getValidationErrors(): array`](../../src/Accounting/Payment/Payment.php#L432)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L437)
- [`getWarnings(): array`](../../src/Accounting/Payment/Payment.php#L447)
- [`addWarning(\Sujip\Xero\Support\ValidationError $warning): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L452)
- [`applyInvoiceReference(?\Sujip\Xero\Accounting\Payment\InvoiceReference $reference): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L497)
- [`toRequest(): array`](../../src/Accounting/Payment/Payment.php#L522)
- [`amount(int\|float $amount): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L548)
- [`date(string $date): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L553)
- [`save(): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payment.php#L558)
- [`history(): Sujip\Xero\Accounting\History`](../../src/Accounting/Payment/Payment.php#L569)

## Accounting\Payment\Payments

[Source](../../src/Accounting/Payment/Payments.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/Payment/Payments.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Payment/Payments.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/Payment/Payments.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Payment/Payments.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Payment/Payments.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Payment/Payments.php#L30)
- [`ids(string ...$ids): static`](../../src/Accounting/Payment/Payments.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Payment\Payments`](../../src/Accounting/Payment/Payments.php#L38)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Payment/Payments.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Payment/Payments.php#L49)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Payment/Payments.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/Payment/Payments.php#L69)
- [`find(string $paymentId): ?\Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payments.php#L89)
- [`create(): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payments.php#L101)
- [`update(string $paymentId): Sujip\Xero\Accounting\Payment\Payload`](../../src/Accounting/Payment/Payments.php#L106)
- [`history(string $paymentId): Sujip\Xero\Accounting\History`](../../src/Accounting/Payment/Payments.php#L111)
- [`mapPayment(array $payload): Sujip\Xero\Accounting\Payment\Payment`](../../src/Accounting/Payment/Payments.php#L119)

## Accounting\Prepayment\Prepayment

[Source](../../src/Accounting/Prepayment/Prepayment.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PrepaymentID` | string or null | `()` |
| `Type` | string or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `Date` | string or null | `()` |
| `Status` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `Total` | int, float, or null | `()` |
| `Reference` | string or null | `()` |
| `InvoiceNumber` | string or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `UpdatedDateUTCString` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `BrandingThemeID` | string or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `RemainingCredit` | int, float, or null | `()` |
| `Allocations` | list of objects ([Accounting\Allocation](accounting.md#accountingallocation)) | `()` |
| `Payments` | list of objects ([Accounting\Payment\Payment](accounting.md#accountingpaymentpayment)) | `()` |
| `AppliedAmount` | int, float, or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `Attachments` | list of objects ([Support\AttachmentDetail](support.md#supportattachmentdetail)) | `()` |

### Public methods

- [`getPrepaymentID(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L75)
- [`setPrepaymentID(?string $prepaymentID): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L80)
- [`getType(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L87)
- [`setType(?string $type): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L92)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Prepayment/Prepayment.php#L99)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L104)
- [`getDate(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L111)
- [`setDate(?string $date): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L116)
- [`getStatus(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L123)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L128)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L135)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L140)
- [`getLineItems(): array`](../../src/Accounting/Prepayment/Prepayment.php#L150)
- [`setLineItems(array $lineItems): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L158)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L165)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/Prepayment/Prepayment.php#L172)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L177)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/Prepayment/Prepayment.php#L184)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L189)
- [`getTotal(): int\|float\|null`](../../src/Accounting/Prepayment/Prepayment.php#L196)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L201)
- [`getReference(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L208)
- [`setReference(?string $reference): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L213)
- [`getInvoiceNumber(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L220)
- [`setInvoiceNumber(?string $invoiceNumber): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L225)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L232)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L237)
- [`getUpdatedDateUTCString(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L244)
- [`setUpdatedDateUTCString(?string $updatedDateUTCString): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L249)
- [`getCurrencyCode(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L256)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L261)
- [`getBrandingThemeID(): ?string`](../../src/Accounting/Prepayment/Prepayment.php#L268)
- [`setBrandingThemeID(?string $brandingThemeID): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L273)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/Prepayment/Prepayment.php#L280)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L285)
- [`getRemainingCredit(): int\|float\|null`](../../src/Accounting/Prepayment/Prepayment.php#L292)
- [`setRemainingCredit(int\|float\|null $remainingCredit): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L297)
- [`getAllocations(): array`](../../src/Accounting/Prepayment/Prepayment.php#L307)
- [`addAllocation(\Sujip\Xero\Accounting\Allocation $allocation): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L312)
- [`getPayments(): array`](../../src/Accounting/Prepayment/Prepayment.php#L322)
- [`addPayment(\Sujip\Xero\Accounting\Payment\Payment $payment): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L327)
- [`getAppliedAmount(): int\|float\|null`](../../src/Accounting/Prepayment/Prepayment.php#L334)
- [`setAppliedAmount(int\|float\|null $appliedAmount): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L339)
- [`getHasAttachments(): ?bool`](../../src/Accounting/Prepayment/Prepayment.php#L346)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L351)
- [`getAttachments(): array`](../../src/Accounting/Prepayment/Prepayment.php#L361)
- [`addAttachment(\Sujip\Xero\Support\AttachmentDetail $attachment): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayment.php#L366)

## Accounting\Prepayment\Prepayments

[Source](../../src/Accounting/Prepayment/Prepayments.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/Prepayment/Prepayments.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Prepayment/Prepayments.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/Prepayment/Prepayments.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Prepayment/Prepayments.php#L26)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Prepayment/Prepayments.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Prepayment/Prepayments.php#L31)
- [`ids(string ...$ids): static`](../../src/Accounting/Prepayment/Prepayments.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Prepayment\Prepayments`](../../src/Accounting/Prepayment/Prepayments.php#L39)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Prepayment/Prepayments.php#L43)
- [`references(string ...$references): Sujip\Xero\Accounting\Prepayment\Prepayments`](../../src/Accounting/Prepayment/Prepayments.php#L47)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Prepayment/Prepayments.php#L51)
- [`invoiceNumbers(string ...$invoiceNumbers): Sujip\Xero\Accounting\Prepayment\Prepayments`](../../src/Accounting/Prepayment/Prepayments.php#L55)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Prepayment/Prepayments.php#L66)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/Prepayment/Prepayments.php#L86)
- [`find(string $prepaymentId): ?\Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayments.php#L98)
- [`allocations(string $prepaymentId): Sujip\Xero\Accounting\Allocations`](../../src/Accounting/Prepayment/Prepayments.php#L110)
- [`history(string $prepaymentId): Sujip\Xero\Accounting\History`](../../src/Accounting/Prepayment/Prepayments.php#L115)
- [`mapPrepayment(array $payload): Sujip\Xero\Accounting\Prepayment\Prepayment`](../../src/Accounting/Prepayment/Prepayments.php#L123)

## Accounting\PurchaseOrder\Attachment

[Source](../../src/Accounting/PurchaseOrder/Attachment.php)

### Public methods

- [`__construct(?string $id, ?string $fileName, ?string $mimeType, ?bool $includeOnline, array $raw = array (
))`](../../src/Accounting/PurchaseOrder/Attachment.php#L12)

## Accounting\PurchaseOrder\Attachments

[Source](../../src/Accounting/PurchaseOrder/Attachments.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $purchaseOrderId)`](../../src/Accounting/PurchaseOrder/Attachments.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/PurchaseOrder/Attachments.php#L22)
- [`upload(string $fileName, string $content): Sujip\Xero\Accounting\PurchaseOrder\Upload`](../../src/Accounting/PurchaseOrder/Attachments.php#L43)
- [`download(string $fileName, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/PurchaseOrder/Attachments.php#L48)
- [`downloadById(string $attachmentId, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/PurchaseOrder/Attachments.php#L60)

## Accounting\PurchaseOrder\Payload

[Source](../../src/Accounting/PurchaseOrder/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/PurchaseOrder/Payload.php#L16)
- [`id(string $purchaseOrderId): Sujip\Xero\Accounting\PurchaseOrder\Payload`](../../src/Accounting/PurchaseOrder/Payload.php#L22)
- [`contact(string $contactId): Sujip\Xero\Accounting\PurchaseOrder\Payload`](../../src/Accounting/PurchaseOrder/Payload.php#L31)
- [`reference(string $reference): Sujip\Xero\Accounting\PurchaseOrder\Payload`](../../src/Accounting/PurchaseOrder/Payload.php#L43)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\PurchaseOrder\Payload`](../../src/Accounting/PurchaseOrder/Payload.php#L52)
- [`using(\Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder $purchaseOrder): Sujip\Xero\Accounting\PurchaseOrder\Payload`](../../src/Accounting/PurchaseOrder/Payload.php#L66)
- [`save(): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/Payload.php#L74)

## Accounting\PurchaseOrder\PurchaseOrder

[Source](../../src/Accounting/PurchaseOrder/PurchaseOrder.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `PurchaseOrderID` | string or null | `()` |
| `PurchaseOrderNumber` | string or null | `()` |
| `Status` | string or null | `()` |
| `Reference` | string or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `Date` | string or null | `()` |
| `DeliveryDate` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `BrandingThemeID` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `SentToContact` | bool or null | `()` |
| `DeliveryAddress` | string or null | `()` |
| `AttentionTo` | string or null | `()` |
| `Telephone` | string or null | `()` |
| `DeliveryInstructions` | string or null | `()` |
| `ExpectedArrivalDate` | string or null | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `Total` | int, float, or null | `()` |
| `TotalDiscount` | int, float, or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `Warnings` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `Attachments` | list of objects ([Support\AttachmentDetail](support.md#supportattachmentdetail)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L20)
- [`getPurchaseOrderID(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L93)
- [`setPurchaseOrderID(?string $purchaseOrderID): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L98)
- [`getPurchaseOrderNumber(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L105)
- [`setPurchaseOrderNumber(?string $purchaseOrderNumber): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L110)
- [`getStatus(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L117)
- [`setStatus(?string $status): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L122)
- [`getReference(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L129)
- [`setReference(?string $reference): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L134)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L141)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L146)
- [`getLineItems(): array`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L156)
- [`setLineItems(array $lineItems): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L164)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L171)
- [`getDate(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L178)
- [`setDate(?string $date): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L183)
- [`getDeliveryDate(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L190)
- [`setDeliveryDate(?string $deliveryDate): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L195)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L202)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L207)
- [`getBrandingThemeID(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L214)
- [`setBrandingThemeID(?string $brandingThemeID): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L219)
- [`getCurrencyCode(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L226)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L231)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L238)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L243)
- [`getSentToContact(): ?bool`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L250)
- [`setSentToContact(?bool $sentToContact): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L255)
- [`getDeliveryAddress(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L262)
- [`setDeliveryAddress(?string $deliveryAddress): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L267)
- [`getAttentionTo(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L274)
- [`setAttentionTo(?string $attentionTo): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L279)
- [`getTelephone(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L286)
- [`setTelephone(?string $telephone): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L291)
- [`getDeliveryInstructions(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L298)
- [`setDeliveryInstructions(?string $deliveryInstructions): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L303)
- [`getExpectedArrivalDate(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L310)
- [`setExpectedArrivalDate(?string $expectedArrivalDate): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L315)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L322)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L327)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L334)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L339)
- [`getTotal(): int\|float\|null`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L346)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L351)
- [`getTotalDiscount(): int\|float\|null`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L358)
- [`setTotalDiscount(int\|float\|null $totalDiscount): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L363)
- [`getHasAttachments(): ?bool`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L370)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L375)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L382)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L387)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L394)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L399)
- [`getValidationErrors(): array`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L409)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L414)
- [`getWarnings(): array`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L424)
- [`addWarning(\Sujip\Xero\Support\ValidationError $warning): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L429)
- [`getAttachments(): array`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L439)
- [`addAttachment(\Sujip\Xero\Support\AttachmentDetail $attachment): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L444)
- [`toRequest(): array`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L500)
- [`reference(string $reference): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L527)
- [`contact(string $contactId): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L532)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L540)
- [`save(): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L550)
- [`attachments(): Sujip\Xero\Accounting\PurchaseOrder\Attachments`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L561)
- [`history(): Sujip\Xero\Accounting\History`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L570)
- [`pdf(): string`](../../src/Accounting/PurchaseOrder/PurchaseOrder.php#L579)

## Accounting\PurchaseOrder\PurchaseOrders

[Source](../../src/Accounting/PurchaseOrder/PurchaseOrders.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L30)
- [`ids(string ...$ids): static`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrders`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L38)
- [`unitDp(int $unitDp): static`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L49)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L69)
- [`find(string $purchaseOrderId): ?\Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L82)
- [`create(): Sujip\Xero\Accounting\PurchaseOrder\Payload`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L94)
- [`update(string $purchaseOrderId): Sujip\Xero\Accounting\PurchaseOrder\Payload`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L99)
- [`attachments(string $purchaseOrderId): Sujip\Xero\Accounting\PurchaseOrder\Attachments`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L104)
- [`history(string $purchaseOrderId): Sujip\Xero\Accounting\History`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L109)
- [`pdf(string $purchaseOrderId): string`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L114)
- [`mapPurchaseOrder(array $payload): Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder`](../../src/Accounting/PurchaseOrder/PurchaseOrders.php#L127)

## Accounting\PurchaseOrder\Upload

[Source](../../src/Accounting/PurchaseOrder/Upload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $purchaseOrderId, string $fileName, string $content)`](../../src/Accounting/PurchaseOrder/Upload.php#L16)
- [`mimeType(string $mimeType): Sujip\Xero\Accounting\PurchaseOrder\Upload`](../../src/Accounting/PurchaseOrder/Upload.php#L24)
- [`includeOnline(bool $includeOnline = true): Sujip\Xero\Accounting\PurchaseOrder\Upload`](../../src/Accounting/PurchaseOrder/Upload.php#L32)
- [`save(): Sujip\Xero\Accounting\PurchaseOrder\Attachment`](../../src/Accounting/PurchaseOrder/Upload.php#L40)

## Accounting\Quote\Payload

[Source](../../src/Accounting/Quote/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Quote/Payload.php#L16)
- [`id(string $quoteId): Sujip\Xero\Accounting\Quote\Payload`](../../src/Accounting/Quote/Payload.php#L22)
- [`contact(string $contactId): Sujip\Xero\Accounting\Quote\Payload`](../../src/Accounting/Quote/Payload.php#L31)
- [`title(string $title): Sujip\Xero\Accounting\Quote\Payload`](../../src/Accounting/Quote/Payload.php#L43)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\Quote\Payload`](../../src/Accounting/Quote/Payload.php#L52)
- [`using(\Sujip\Xero\Accounting\Quote\Quote $quote): Sujip\Xero\Accounting\Quote\Payload`](../../src/Accounting/Quote/Payload.php#L66)
- [`save(): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Payload.php#L74)

## Accounting\Quote\Quote

[Source](../../src/Accounting/Quote/Quote.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `QuoteID` | string or null | `()` |
| `QuoteNumber` | string or null | `()` |
| `Reference` | string or null | `()` |
| `Terms` | string or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `Date` | string or null | `()` |
| `DateString` | string or null | `()` |
| `ExpiryDate` | string or null | `()` |
| `ExpiryDateString` | string or null | `()` |
| `Status` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `CurrencyRate` | int, float, or null | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `Total` | int, float, or null | `()` |
| `TotalDiscount` | int, float, or null | `()` |
| `Title` | string or null | `()` |
| `Summary` | string or null | `()` |
| `BrandingThemeID` | string or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `StatusAttributeString` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Quote/Quote.php#L18)
- [`getQuoteID(): ?string`](../../src/Accounting/Quote/Quote.php#L77)
- [`setQuoteID(?string $quoteID): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L82)
- [`getQuoteNumber(): ?string`](../../src/Accounting/Quote/Quote.php#L89)
- [`setQuoteNumber(?string $quoteNumber): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L94)
- [`getStatus(): ?string`](../../src/Accounting/Quote/Quote.php#L101)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L106)
- [`getTitle(): ?string`](../../src/Accounting/Quote/Quote.php#L113)
- [`setTitle(?string $title): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L118)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Quote/Quote.php#L125)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L130)
- [`getLineItems(): array`](../../src/Accounting/Quote/Quote.php#L140)
- [`setLineItems(array $lineItems): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L148)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L155)
- [`getReference(): ?string`](../../src/Accounting/Quote/Quote.php#L162)
- [`setReference(?string $reference): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L167)
- [`getTerms(): ?string`](../../src/Accounting/Quote/Quote.php#L174)
- [`setTerms(?string $terms): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L179)
- [`getDate(): ?string`](../../src/Accounting/Quote/Quote.php#L186)
- [`setDate(?string $date): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L191)
- [`getDateString(): ?string`](../../src/Accounting/Quote/Quote.php#L198)
- [`setDateString(?string $dateString): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L203)
- [`getExpiryDate(): ?string`](../../src/Accounting/Quote/Quote.php#L210)
- [`setExpiryDate(?string $expiryDate): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L215)
- [`getExpiryDateString(): ?string`](../../src/Accounting/Quote/Quote.php#L222)
- [`setExpiryDateString(?string $expiryDateString): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L227)
- [`getCurrencyCode(): ?string`](../../src/Accounting/Quote/Quote.php#L234)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L239)
- [`getCurrencyRate(): int\|float\|null`](../../src/Accounting/Quote/Quote.php#L246)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L251)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/Quote/Quote.php#L258)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L263)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/Quote/Quote.php#L270)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L275)
- [`getTotal(): int\|float\|null`](../../src/Accounting/Quote/Quote.php#L282)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L287)
- [`getTotalDiscount(): int\|float\|null`](../../src/Accounting/Quote/Quote.php#L294)
- [`setTotalDiscount(int\|float\|null $totalDiscount): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L299)
- [`getSummary(): ?string`](../../src/Accounting/Quote/Quote.php#L306)
- [`setSummary(?string $summary): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L311)
- [`getBrandingThemeID(): ?string`](../../src/Accounting/Quote/Quote.php#L318)
- [`setBrandingThemeID(?string $brandingThemeID): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L323)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Quote/Quote.php#L330)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L335)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/Quote/Quote.php#L342)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L347)
- [`getStatusAttributeString(): ?string`](../../src/Accounting/Quote/Quote.php#L354)
- [`setStatusAttributeString(?string $statusAttributeString): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L359)
- [`getValidationErrors(): array`](../../src/Accounting/Quote/Quote.php#L369)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L374)
- [`toRequest(): array`](../../src/Accounting/Quote/Quote.php#L426)
- [`title(string $title): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L452)
- [`contact(string $contactId): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L457)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L465)
- [`save(): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quote.php#L475)
- [`pdf(): string`](../../src/Accounting/Quote/Quote.php#L486)

## Accounting\Quote\Quotes

[Source](../../src/Accounting/Quote/Quotes.php)

### Public methods

- [`page(int $page): static`](../../src/Accounting/Quote/Quotes.php#L13)
- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Quote/Quotes.php#L19)
- [`perPage(int $perPage): static`](../../src/Accounting/Quote/Quotes.php#L21)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Quote/Quotes.php#L26)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Quote/Quotes.php#L27)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Quote/Quotes.php#L31)
- [`ids(string ...$ids): static`](../../src/Accounting/Quote/Quotes.php#L35)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Quote\Quotes`](../../src/Accounting/Quote/Quotes.php#L39)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Quote/Quotes.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Quote/Quotes.php#L50)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Quote/Quotes.php#L51)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Accounting/Quote/Quotes.php#L70)
- [`find(string $quoteId): ?\Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quotes.php#L83)
- [`create(): Sujip\Xero\Accounting\Quote\Payload`](../../src/Accounting/Quote/Quotes.php#L95)
- [`update(string $quoteId): Sujip\Xero\Accounting\Quote\Payload`](../../src/Accounting/Quote/Quotes.php#L100)
- [`history(string $quoteId): Sujip\Xero\Accounting\History`](../../src/Accounting/Quote/Quotes.php#L105)
- [`attachments(string $quoteId): Sujip\Xero\Accounting\Attachments`](../../src/Accounting/Quote/Quotes.php#L110)
- [`pdf(string $quoteId): string`](../../src/Accounting/Quote/Quotes.php#L115)
- [`mapQuote(array $payload): Sujip\Xero\Accounting\Quote\Quote`](../../src/Accounting/Quote/Quotes.php#L128)

## Accounting\Receipt\Attachment

[Source](../../src/Accounting/Receipt/Attachment.php)

### Public methods

- [`__construct(?string $id, ?string $fileName, ?string $mimeType, ?bool $includeOnline, array $raw = array (
))`](../../src/Accounting/Receipt/Attachment.php#L12)

## Accounting\Receipt\Attachments

[Source](../../src/Accounting/Receipt/Attachments.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $receiptId)`](../../src/Accounting/Receipt/Attachments.php#L13)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Receipt/Attachments.php#L22)
- [`upload(string $fileName, string $content): Sujip\Xero\Accounting\Receipt\Upload`](../../src/Accounting/Receipt/Attachments.php#L43)
- [`download(string $fileName, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/Receipt/Attachments.php#L48)
- [`downloadById(string $attachmentId, string $contentType = 'application/octet-stream'): string`](../../src/Accounting/Receipt/Attachments.php#L60)

## Accounting\Receipt\Receipt

[Source](../../src/Accounting/Receipt/Receipt.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `ReceiptID` | string or null | `()` |
| `ReceiptNumber` | string or null | `()` |
| `Status` | string or null | `()` |
| `Total` | int, float, or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `Date` | string or null | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `User` | object or null ([Accounting\User\User](accounting.md#accountinguseruser)) | `()` |
| `Reference` | string or null | `()` |
| `LineAmountTypes` | string or null | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `Url` | string or null | `()` |
| `ValidationErrors` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `Warnings` | list of objects ([Support\ValidationError](support.md#supportvalidationerror)) | `()` |
| `Attachments` | list of objects ([Support\AttachmentDetail](support.md#supportattachmentdetail)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/Receipt/Receipt.php#L68)
- [`getReceiptID(): ?string`](../../src/Accounting/Receipt/Receipt.php#L73)
- [`setReceiptID(?string $receiptID): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L78)
- [`getReceiptNumber(): ?string`](../../src/Accounting/Receipt/Receipt.php#L85)
- [`setReceiptNumber(?string $receiptNumber): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L90)
- [`getStatus(): ?string`](../../src/Accounting/Receipt/Receipt.php#L97)
- [`setStatus(?string $status): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L102)
- [`getTotal(): int\|float\|null`](../../src/Accounting/Receipt/Receipt.php#L109)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L114)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/Receipt/Receipt.php#L121)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L126)
- [`getContactID(): ?string`](../../src/Accounting/Receipt/Receipt.php#L133)
- [`setContactID(?string $contactID): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L138)
- [`getDate(): ?string`](../../src/Accounting/Receipt/Receipt.php#L147)
- [`setDate(?string $date): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L152)
- [`getLineItems(): array`](../../src/Accounting/Receipt/Receipt.php#L162)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L167)
- [`getUser(): ?\Sujip\Xero\Accounting\User\User`](../../src/Accounting/Receipt/Receipt.php#L174)
- [`setUser(?\Sujip\Xero\Accounting\User\User $user): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L179)
- [`getReference(): ?string`](../../src/Accounting/Receipt/Receipt.php#L186)
- [`setReference(?string $reference): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L191)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/Receipt/Receipt.php#L198)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L203)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/Receipt/Receipt.php#L210)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L215)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/Receipt/Receipt.php#L222)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L227)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Receipt/Receipt.php#L234)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L239)
- [`getHasAttachments(): ?bool`](../../src/Accounting/Receipt/Receipt.php#L246)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L251)
- [`getUrl(): ?string`](../../src/Accounting/Receipt/Receipt.php#L258)
- [`setUrl(?string $url): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L263)
- [`getValidationErrors(): array`](../../src/Accounting/Receipt/Receipt.php#L273)
- [`addValidationError(\Sujip\Xero\Support\ValidationError $validationError): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L278)
- [`getWarnings(): array`](../../src/Accounting/Receipt/Receipt.php#L288)
- [`addWarning(\Sujip\Xero\Support\ValidationError $warning): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L293)
- [`getAttachments(): array`](../../src/Accounting/Receipt/Receipt.php#L303)
- [`addAttachment(\Sujip\Xero\Support\AttachmentDetail $attachment): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipt.php#L308)
- [`attachments(): Sujip\Xero\Accounting\Receipt\Attachments`](../../src/Accounting/Receipt/Receipt.php#L351)
- [`history(): Sujip\Xero\Accounting\History`](../../src/Accounting/Receipt/Receipt.php#L360)

## Accounting\Receipt\Receipts

[Source](../../src/Accounting/Receipt/Receipts.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/Receipt/Receipts.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Receipt/Receipts.php#L21)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Receipt/Receipts.php#L26)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/Receipt/Receipts.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\Receipt\Receipts`](../../src/Accounting/Receipt/Receipts.php#L34)
- [`ids(string ...$ids): static`](../../src/Accounting/Receipt/Receipts.php#L35)
- [`unitDp(int $unitDp): static`](../../src/Accounting/Receipt/Receipts.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Receipt/Receipts.php#L45)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/Receipt/Receipts.php#L51)
- [`find(string $receiptId): ?\Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipts.php#L62)
- [`attachments(string $receiptId): Sujip\Xero\Accounting\Receipt\Attachments`](../../src/Accounting/Receipt/Receipts.php#L74)
- [`history(string $receiptId): Sujip\Xero\Accounting\History`](../../src/Accounting/Receipt/Receipts.php#L79)
- [`mapReceipt(array $payload): Sujip\Xero\Accounting\Receipt\Receipt`](../../src/Accounting/Receipt/Receipts.php#L87)

## Accounting\Receipt\Upload

[Source](../../src/Accounting/Receipt/Upload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $receiptId, string $fileName, string $content)`](../../src/Accounting/Receipt/Upload.php#L14)
- [`mimeType(string $mimeType): Sujip\Xero\Accounting\Receipt\Upload`](../../src/Accounting/Receipt/Upload.php#L22)
- [`save(): Sujip\Xero\Accounting\Receipt\Attachment`](../../src/Accounting/Receipt/Upload.php#L30)

## Accounting\RepeatingInvoice\Payload

[Source](../../src/Accounting/RepeatingInvoice/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/RepeatingInvoice/Payload.php#L19)
- [`id(string $repeatingInvoiceId): Sujip\Xero\Accounting\RepeatingInvoice\Payload`](../../src/Accounting/RepeatingInvoice/Payload.php#L24)
- [`type(string $type): Sujip\Xero\Accounting\RepeatingInvoice\Payload`](../../src/Accounting/RepeatingInvoice/Payload.php#L32)
- [`contact(string $contactId): Sujip\Xero\Accounting\RepeatingInvoice\Payload`](../../src/Accounting/RepeatingInvoice/Payload.php#L40)
- [`reference(string $reference): Sujip\Xero\Accounting\RepeatingInvoice\Payload`](../../src/Accounting/RepeatingInvoice/Payload.php#L48)
- [`lineItem(string $description, int\|float $quantity, int\|float $unitAmount): Sujip\Xero\Accounting\RepeatingInvoice\Payload`](../../src/Accounting/RepeatingInvoice/Payload.php#L56)
- [`save(): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/Payload.php#L70)

## Accounting\RepeatingInvoice\RepeatingInvoice

[Source](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `RepeatingInvoiceID` | string or null | `()` |
| `ID` | string or null | `()` |
| `Type` | string or null | `()` |
| `Contact` | object or null ([Accounting\Contact\Contact](accounting.md#accountingcontactcontact)) | `()` |
| `Schedule` | object or null ([Accounting\RepeatingInvoice\Schedule](accounting.md#accountingrepeatinginvoiceschedule)) | `()` |
| `LineItems` | list of objects ([Accounting\Invoice\LineItem](accounting.md#accountinginvoicelineitem)) | `()` |
| `LineAmountTypes` | string or null | `()` |
| `Status` | string or null | `()` |
| `Reference` | string or null | `()` |
| `BrandingThemeID` | string or null | `()` |
| `CurrencyCode` | string or null | `()` |
| `SubTotal` | int, float, or null | `()` |
| `TotalTax` | int, float, or null | `()` |
| `Total` | int, float, or null | `()` |
| `HasAttachments` | bool or null | `()` |
| `Attachments` | list of objects ([Support\AttachmentDetail](support.md#supportattachmentdetail)) | `()` |
| `ApprovedForSending` | bool or null | `()` |
| `SendCopy` | bool or null | `()` |
| `MarkAsSent` | bool or null | `()` |
| `IncludePDF` | bool or null | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L63)
- [`getRepeatingInvoiceID(): ?string`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L68)
- [`setRepeatingInvoiceID(?string $repeatingInvoiceID): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L73)
- [`getID(): ?string`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L80)
- [`setID(?string $id): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L85)
- [`getType(): ?string`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L92)
- [`setType(?string $type): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L97)
- [`getContact(): ?\Sujip\Xero\Accounting\Contact\Contact`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L104)
- [`setContact(?\Sujip\Xero\Accounting\Contact\Contact $contact): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L109)
- [`getSchedule(): ?\Sujip\Xero\Accounting\RepeatingInvoice\Schedule`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L116)
- [`setSchedule(?\Sujip\Xero\Accounting\RepeatingInvoice\Schedule $schedule): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L121)
- [`getLineItems(): array`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L131)
- [`setLineItems(array $lineItems): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L139)
- [`addLineItem(\Sujip\Xero\Accounting\Invoice\LineItem $lineItem): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L146)
- [`getLineAmountTypes(): ?string`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L153)
- [`setLineAmountTypes(?string $lineAmountTypes): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L158)
- [`getStatus(): ?string`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L165)
- [`setStatus(?string $status): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L170)
- [`getReference(): ?string`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L177)
- [`setReference(?string $reference): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L182)
- [`getBrandingThemeID(): ?string`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L189)
- [`setBrandingThemeID(?string $brandingThemeID): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L194)
- [`getCurrencyCode(): ?string`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L201)
- [`setCurrencyCode(?string $currencyCode): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L206)
- [`getSubTotal(): int\|float\|null`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L213)
- [`setSubTotal(int\|float\|null $subTotal): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L218)
- [`getTotalTax(): int\|float\|null`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L225)
- [`setTotalTax(int\|float\|null $totalTax): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L230)
- [`getTotal(): int\|float\|null`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L237)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L242)
- [`getHasAttachments(): ?bool`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L249)
- [`setHasAttachments(?bool $hasAttachments): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L254)
- [`getAttachments(): array`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L264)
- [`addAttachment(\Sujip\Xero\Support\AttachmentDetail $attachment): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L269)
- [`getApprovedForSending(): ?bool`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L276)
- [`setApprovedForSending(?bool $approvedForSending): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L281)
- [`getSendCopy(): ?bool`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L288)
- [`setSendCopy(?bool $sendCopy): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L293)
- [`getMarkAsSent(): ?bool`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L300)
- [`setMarkAsSent(?bool $markAsSent): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L305)
- [`getIncludePDF(): ?bool`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L312)
- [`setIncludePDF(?bool $includePDF): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L317)
- [`reference(string $reference): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L353)
- [`save(): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoice.php#L358)

## Accounting\RepeatingInvoice\RepeatingInvoices

[Source](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L22)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L27)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoices`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L35)
- [`ids(string ...$ids): static`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L35)
- [`unitDp(int $unitDp): static`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L46)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L51)
- [`find(string $repeatingInvoiceId): ?\Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L63)
- [`create(): Sujip\Xero\Accounting\RepeatingInvoice\Payload`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L75)
- [`update(string $repeatingInvoiceId): Sujip\Xero\Accounting\RepeatingInvoice\Payload`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L80)
- [`history(string $repeatingInvoiceId): Sujip\Xero\Accounting\History`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L85)
- [`attachments(string $repeatingInvoiceId): Sujip\Xero\Accounting\Attachments`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L90)
- [`mapRepeatingInvoice(array $payload): Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice`](../../src/Accounting/RepeatingInvoice/RepeatingInvoices.php#L98)

## Accounting\RepeatingInvoice\Schedule

[Source](../../src/Accounting/RepeatingInvoice/Schedule.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Period` | int, float, or null | `()` |
| `Unit` | string or null | `()` |
| `DueDate` | int, float, or null | `()` |
| `DueDateType` | string or null | `()` |
| `StartDate` | string or null | `()` |
| `NextScheduledDate` | string or null | `()` |
| `EndDate` | string or null | `()` |

### Public methods

- [`getPeriod(): ?int`](../../src/Accounting/RepeatingInvoice/Schedule.php#L26)
- [`setPeriod(?int $period): Sujip\Xero\Accounting\RepeatingInvoice\Schedule`](../../src/Accounting/RepeatingInvoice/Schedule.php#L31)
- [`getUnit(): ?string`](../../src/Accounting/RepeatingInvoice/Schedule.php#L38)
- [`setUnit(?string $unit): Sujip\Xero\Accounting\RepeatingInvoice\Schedule`](../../src/Accounting/RepeatingInvoice/Schedule.php#L43)
- [`getDueDate(): ?int`](../../src/Accounting/RepeatingInvoice/Schedule.php#L50)
- [`setDueDate(?int $dueDate): Sujip\Xero\Accounting\RepeatingInvoice\Schedule`](../../src/Accounting/RepeatingInvoice/Schedule.php#L55)
- [`getDueDateType(): ?string`](../../src/Accounting/RepeatingInvoice/Schedule.php#L62)
- [`setDueDateType(?string $dueDateType): Sujip\Xero\Accounting\RepeatingInvoice\Schedule`](../../src/Accounting/RepeatingInvoice/Schedule.php#L67)
- [`getStartDate(): ?string`](../../src/Accounting/RepeatingInvoice/Schedule.php#L74)
- [`setStartDate(?string $startDate): Sujip\Xero\Accounting\RepeatingInvoice\Schedule`](../../src/Accounting/RepeatingInvoice/Schedule.php#L79)
- [`getNextScheduledDate(): ?string`](../../src/Accounting/RepeatingInvoice/Schedule.php#L86)
- [`setNextScheduledDate(?string $nextScheduledDate): Sujip\Xero\Accounting\RepeatingInvoice\Schedule`](../../src/Accounting/RepeatingInvoice/Schedule.php#L91)
- [`getEndDate(): ?string`](../../src/Accounting/RepeatingInvoice/Schedule.php#L98)
- [`setEndDate(?string $endDate): Sujip\Xero\Accounting\RepeatingInvoice\Schedule`](../../src/Accounting/RepeatingInvoice/Schedule.php#L103)

## Accounting\Report\Report

[Source](../../src/Accounting/Report/Report.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `ReportID` | string or null | `()` |
| `ReportName` | string or null | `()` |
| `ReportType` | string or null | `()` |
| `ReportTitle` | string or null | `()` |
| `ReportDate` | string or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `Contacts` | list of objects ([Accounting\Report\TenNinetyNineContact](accounting.md#accountingreporttenninetyninecontact)) | `()` |

### Public methods

- [`getReportID(): ?string`](../../src/Accounting/Report/Report.php#L31)
- [`setReportID(?string $reportID): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Report.php#L36)
- [`getReportName(): ?string`](../../src/Accounting/Report/Report.php#L43)
- [`setReportName(?string $reportName): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Report.php#L48)
- [`getReportType(): ?string`](../../src/Accounting/Report/Report.php#L55)
- [`setReportType(?string $reportType): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Report.php#L60)
- [`getTitle(): ?string`](../../src/Accounting/Report/Report.php#L67)
- [`setTitle(?string $title): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Report.php#L72)
- [`getReportTitle(): ?string`](../../src/Accounting/Report/Report.php#L79)
- [`setReportTitle(?string $reportTitle): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Report.php#L84)
- [`getReportDate(): ?string`](../../src/Accounting/Report/Report.php#L91)
- [`setReportDate(?string $reportDate): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Report.php#L96)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/Report/Report.php#L103)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Report.php#L108)
- [`getContacts(): array`](../../src/Accounting/Report/Report.php#L118)
- [`addContact(\Sujip\Xero\Accounting\Report\TenNinetyNineContact $contact): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Report.php#L123)
- [`fill(array $payload): static`](../../src/Accounting/Report/Report.php#L146)

## Accounting\Report\Reports

[Source](../../src/Accounting/Report/Reports.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Report/Reports.php#L16)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/Report/Reports.php#L21)
- [`list(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/Report/Reports.php#L32)
- [`find(string $reportId): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L47)
- [`profitAndLoss(array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L55)
- [`balanceSheet(array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L63)
- [`trialBalance(array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L71)
- [`bankSummary(array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L79)
- [`budgetSummary(array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L87)
- [`executiveSummary(array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L95)
- [`agedReceivablesByContact(string $contactId, array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L103)
- [`agedPayablesByContact(string $contactId, array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L111)
- [`tenNinetyNine(array $query = array (
)): ?\Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L119)
- [`mapReport(array $payload): Sujip\Xero\Accounting\Report\Report`](../../src/Accounting/Report/Reports.php#L172)

## Accounting\Report\TenNinetyNineContact

[Source](../../src/Accounting/Report/TenNinetyNineContact.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Box1` | int, float, or null | `()` |
| `Box2` | int, float, or null | `()` |
| `Box3` | int, float, or null | `()` |
| `Box4` | int, float, or null | `()` |
| `Box5` | int, float, or null | `()` |
| `Box6` | int, float, or null | `()` |
| `Box7` | int, float, or null | `()` |
| `Box8` | int, float, or null | `()` |
| `Box9` | int, float, or null | `()` |
| `Box10` | int, float, or null | `()` |
| `Box11` | int, float, or null | `()` |
| `Box13` | int, float, or null | `()` |
| `Box14` | int, float, or null | `()` |
| `Name` | string or null | `()` |
| `FederalTaxIDType` | string or null | `()` |
| `City` | string or null | `()` |
| `Zip` | string or null | `()` |
| `State` | string or null | `()` |
| `Email` | string or null | `()` |
| `StreetAddress` | string or null | `()` |
| `TaxID` | string or null | `()` |
| `ContactId` | string or null | `()` |
| `LegalName` | string or null | `()` |
| `BusinessName` | string or null | `()` |
| `FederalTaxClassification` | string or null | `()` |

### Public methods

- [`getBox1(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L62)
- [`setBox1(int\|float\|null $box1): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L67)
- [`getBox2(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L74)
- [`setBox2(int\|float\|null $box2): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L79)
- [`getBox3(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L86)
- [`setBox3(int\|float\|null $box3): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L91)
- [`getBox4(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L98)
- [`setBox4(int\|float\|null $box4): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L103)
- [`getBox5(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L110)
- [`setBox5(int\|float\|null $box5): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L115)
- [`getBox6(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L122)
- [`setBox6(int\|float\|null $box6): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L127)
- [`getBox7(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L134)
- [`setBox7(int\|float\|null $box7): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L139)
- [`getBox8(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L146)
- [`setBox8(int\|float\|null $box8): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L151)
- [`getBox9(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L158)
- [`setBox9(int\|float\|null $box9): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L163)
- [`getBox10(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L170)
- [`setBox10(int\|float\|null $box10): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L175)
- [`getBox11(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L182)
- [`setBox11(int\|float\|null $box11): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L187)
- [`getBox13(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L194)
- [`setBox13(int\|float\|null $box13): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L199)
- [`getBox14(): int\|float\|null`](../../src/Accounting/Report/TenNinetyNineContact.php#L206)
- [`setBox14(int\|float\|null $box14): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L211)
- [`getName(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L218)
- [`setName(?string $name): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L223)
- [`getFederalTaxIDType(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L230)
- [`setFederalTaxIDType(?string $federalTaxIDType): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L235)
- [`getCity(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L242)
- [`setCity(?string $city): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L247)
- [`getZip(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L254)
- [`setZip(?string $zip): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L259)
- [`getState(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L266)
- [`setState(?string $state): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L271)
- [`getEmail(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L278)
- [`setEmail(?string $email): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L283)
- [`getStreetAddress(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L290)
- [`setStreetAddress(?string $streetAddress): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L295)
- [`getTaxID(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L302)
- [`setTaxID(?string $taxID): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L307)
- [`getContactId(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L314)
- [`setContactId(?string $contactId): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L319)
- [`getLegalName(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L326)
- [`setLegalName(?string $legalName): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L331)
- [`getBusinessName(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L338)
- [`setBusinessName(?string $businessName): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L343)
- [`getFederalTaxClassification(): ?string`](../../src/Accounting/Report/TenNinetyNineContact.php#L350)
- [`setFederalTaxClassification(?string $federalTaxClassification): Sujip\Xero\Accounting\Report\TenNinetyNineContact`](../../src/Accounting/Report/TenNinetyNineContact.php#L355)

## Accounting\Setup\ImportSummary

[Source](../../src/Accounting/Setup/ImportSummary.php)

### Public methods

- [`__construct(array $accounts, array $organisation, array $raw = array (
))`](../../src/Accounting/Setup/ImportSummary.php#L14)

## Accounting\Setup\Payload

[Source](../../src/Accounting/Setup/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/Setup/Payload.php#L29)
- [`conversionDate(int $month, int $year): Sujip\Xero\Accounting\Setup\Payload`](../../src/Accounting/Setup/Payload.php#L34)
- [`conversionBalance(string $accountCode, float $balance): Sujip\Xero\Accounting\Setup\Payload`](../../src/Accounting/Setup/Payload.php#L43)
- [`account(\Sujip\Xero\Accounting\Account\Account $account): Sujip\Xero\Accounting\Setup\Payload`](../../src/Accounting/Setup/Payload.php#L54)
- [`idempotencyKey(string $idempotencyKey): Sujip\Xero\Accounting\Setup\Payload`](../../src/Accounting/Setup/Payload.php#L62)
- [`save(): Sujip\Xero\Accounting\Setup\ImportSummary`](../../src/Accounting/Setup/Payload.php#L70)

## Accounting\TaxRate\Component

[Source](../../src/Accounting/TaxRate/Component.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Name` | string or null | `()` |
| `Rate` | int, float, or null | `()` |

### Public methods

- [`getName(): ?string`](../../src/Accounting/TaxRate/Component.php#L17)
- [`setName(?string $name): Sujip\Xero\Accounting\TaxRate\Component`](../../src/Accounting/TaxRate/Component.php#L22)
- [`getRate(): int\|float\|null`](../../src/Accounting/TaxRate/Component.php#L29)
- [`setRate(int\|float\|null $rate): Sujip\Xero\Accounting\TaxRate\Component`](../../src/Accounting/TaxRate/Component.php#L34)
- [`toRequest(): array`](../../src/Accounting/TaxRate/Component.php#L55)

## Accounting\TaxRate\Payload

[Source](../../src/Accounting/TaxRate/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/TaxRate/Payload.php#L16)
- [`taxType(string $taxType): Sujip\Xero\Accounting\TaxRate\Payload`](../../src/Accounting/TaxRate/Payload.php#L22)
- [`name(string $name): Sujip\Xero\Accounting\TaxRate\Payload`](../../src/Accounting/TaxRate/Payload.php#L31)
- [`component(string $name, int\|float $rate): Sujip\Xero\Accounting\TaxRate\Payload`](../../src/Accounting/TaxRate/Payload.php#L40)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\TaxRate\Payload`](../../src/Accounting/TaxRate/Payload.php#L53)
- [`using(\Sujip\Xero\Accounting\TaxRate\TaxRate $taxRate): Sujip\Xero\Accounting\TaxRate\Payload`](../../src/Accounting/TaxRate/Payload.php#L61)
- [`save(): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/Payload.php#L69)

## Accounting\TaxRate\TaxRate

[Source](../../src/Accounting/TaxRate/TaxRate.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Name` | string or null | `()` |
| `TaxType` | string or null | `()` |
| `Status` | string or null | `()` |
| `TaxComponents` | list of objects ([Accounting\TaxRate\Component](accounting.md#accountingtaxratecomponent)) | `()` |
| `ReportTaxType` | string or null | `()` |
| `CanApplyToAssets` | bool or null | `()` |
| `CanApplyToEquity` | bool or null | `()` |
| `CanApplyToExpenses` | bool or null | `()` |
| `CanApplyToLiabilities` | bool or null | `()` |
| `CanApplyToRevenue` | bool or null | `()` |
| `DisplayTaxRate` | int, float, or null | `()` |
| `EffectiveRate` | int, float, or null | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/TaxRate/TaxRate.php#L15)
- [`getName(): ?string`](../../src/Accounting/TaxRate/TaxRate.php#L47)
- [`setName(?string $name): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L52)
- [`getTaxType(): ?string`](../../src/Accounting/TaxRate/TaxRate.php#L59)
- [`setTaxType(?string $taxType): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L64)
- [`getStatus(): ?string`](../../src/Accounting/TaxRate/TaxRate.php#L71)
- [`setStatus(?string $status): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L76)
- [`getTaxComponents(): array`](../../src/Accounting/TaxRate/TaxRate.php#L86)
- [`setTaxComponents(array $taxComponents): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L94)
- [`addTaxComponent(\Sujip\Xero\Accounting\TaxRate\Component $component): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L101)
- [`getReportTaxType(): ?string`](../../src/Accounting/TaxRate/TaxRate.php#L108)
- [`setReportTaxType(?string $reportTaxType): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L113)
- [`getCanApplyToAssets(): ?bool`](../../src/Accounting/TaxRate/TaxRate.php#L120)
- [`setCanApplyToAssets(?bool $canApplyToAssets): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L125)
- [`getCanApplyToEquity(): ?bool`](../../src/Accounting/TaxRate/TaxRate.php#L132)
- [`setCanApplyToEquity(?bool $canApplyToEquity): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L137)
- [`getCanApplyToExpenses(): ?bool`](../../src/Accounting/TaxRate/TaxRate.php#L144)
- [`setCanApplyToExpenses(?bool $canApplyToExpenses): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L149)
- [`getCanApplyToLiabilities(): ?bool`](../../src/Accounting/TaxRate/TaxRate.php#L156)
- [`setCanApplyToLiabilities(?bool $canApplyToLiabilities): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L161)
- [`getCanApplyToRevenue(): ?bool`](../../src/Accounting/TaxRate/TaxRate.php#L168)
- [`setCanApplyToRevenue(?bool $canApplyToRevenue): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L173)
- [`getDisplayTaxRate(): ?float`](../../src/Accounting/TaxRate/TaxRate.php#L180)
- [`setDisplayTaxRate(?float $displayTaxRate): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L185)
- [`getEffectiveRate(): ?float`](../../src/Accounting/TaxRate/TaxRate.php#L192)
- [`setEffectiveRate(?float $effectiveRate): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L197)
- [`toRequest(): array`](../../src/Accounting/TaxRate/TaxRate.php#L228)
- [`name(string $name): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L241)
- [`component(string $name, int\|float $rate): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L246)
- [`save(): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRate.php#L255)

## Accounting\TaxRate\TaxRates

[Source](../../src/Accounting/TaxRate/TaxRates.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/TaxRate/TaxRates.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/TaxRate/TaxRates.php#L20)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/TaxRate/TaxRates.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/TaxRate/TaxRates.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\TaxRate\TaxRates`](../../src/Accounting/TaxRate/TaxRates.php#L33)
- [`ids(string ...$ids): static`](../../src/Accounting/TaxRate/TaxRates.php#L35)
- [`unitDp(int $unitDp): static`](../../src/Accounting/TaxRate/TaxRates.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/TaxRate/TaxRates.php#L44)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/TaxRate/TaxRates.php#L51)
- [`find(string $taxType): ?\Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRates.php#L61)
- [`create(): Sujip\Xero\Accounting\TaxRate\Payload`](../../src/Accounting/TaxRate/TaxRates.php#L73)
- [`update(string $taxType): Sujip\Xero\Accounting\TaxRate\Payload`](../../src/Accounting/TaxRate/TaxRates.php#L78)
- [`mapTaxRate(array $payload): Sujip\Xero\Accounting\TaxRate\TaxRate`](../../src/Accounting/TaxRate/TaxRates.php#L86)
- [`mapComponent(array $payload): Sujip\Xero\Accounting\TaxRate\Component`](../../src/Accounting/TaxRate/TaxRates.php#L94)

## Accounting\TrackingCategory\Option

[Source](../../src/Accounting/TrackingCategory/Option.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `TrackingOptionID` | string or null | `()` |
| `Name` | string or null | `()` |
| `Status` | string or null | `()` |

### Public methods

- [`getTrackingOptionID(): ?string`](../../src/Accounting/TrackingCategory/Option.php#L19)
- [`setTrackingOptionID(?string $trackingOptionID): Sujip\Xero\Accounting\TrackingCategory\Option`](../../src/Accounting/TrackingCategory/Option.php#L24)
- [`getName(): ?string`](../../src/Accounting/TrackingCategory/Option.php#L31)
- [`setName(?string $name): Sujip\Xero\Accounting\TrackingCategory\Option`](../../src/Accounting/TrackingCategory/Option.php#L36)
- [`getStatus(): ?string`](../../src/Accounting/TrackingCategory/Option.php#L43)
- [`setStatus(?string $status): Sujip\Xero\Accounting\TrackingCategory\Option`](../../src/Accounting/TrackingCategory/Option.php#L48)
- [`toRequest(): array`](../../src/Accounting/TrackingCategory/Option.php#L70)

## Accounting\TrackingCategory\Payload

[Source](../../src/Accounting/TrackingCategory/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/TrackingCategory/Payload.php#L16)
- [`id(string $trackingCategoryId): Sujip\Xero\Accounting\TrackingCategory\Payload`](../../src/Accounting/TrackingCategory/Payload.php#L22)
- [`name(string $name): Sujip\Xero\Accounting\TrackingCategory\Payload`](../../src/Accounting/TrackingCategory/Payload.php#L31)
- [`option(string $name): Sujip\Xero\Accounting\TrackingCategory\Payload`](../../src/Accounting/TrackingCategory/Payload.php#L40)
- [`idempotencyKey(string $key): Sujip\Xero\Accounting\TrackingCategory\Payload`](../../src/Accounting/TrackingCategory/Payload.php#L51)
- [`using(\Sujip\Xero\Accounting\TrackingCategory\TrackingCategory $trackingCategory): Sujip\Xero\Accounting\TrackingCategory\Payload`](../../src/Accounting/TrackingCategory/Payload.php#L59)
- [`save(): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/Payload.php#L67)

## Accounting\TrackingCategory\TrackingCategories

[Source](../../src/Accounting/TrackingCategory/TrackingCategories.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L20)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\TrackingCategory\TrackingCategories`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L33)
- [`ids(string ...$ids): static`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L35)
- [`includeArchived(bool $includeArchived = true): Sujip\Xero\Accounting\TrackingCategory\TrackingCategories`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L41)
- [`unitDp(int $unitDp): static`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L43)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L51)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L52)
- [`find(string $trackingCategoryId): ?\Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L69)
- [`create(): Sujip\Xero\Accounting\TrackingCategory\Payload`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L81)
- [`update(string $trackingCategoryId): Sujip\Xero\Accounting\TrackingCategory\Payload`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L86)
- [`createOption(string $trackingCategoryId, string $name, ?string $idempotencyKey = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L94)
- [`updateOption(string $trackingCategoryId, string $trackingOptionId, string $name, ?string $idempotencyKey = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L109)
- [`deleteOption(string $trackingCategoryId, string $trackingOptionId): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L124)
- [`mapTrackingCategory(array $payload): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L137)
- [`mapOption(array $payload): Sujip\Xero\Accounting\TrackingCategory\Option`](../../src/Accounting/TrackingCategory/TrackingCategories.php#L145)

## Accounting\TrackingCategory\TrackingCategory

[Source](../../src/Accounting/TrackingCategory/TrackingCategory.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `TrackingCategoryID` | string or null | `()` |
| `TrackingOptionID` | string or null | `()` |
| `Name` | string or null | `()` |
| `Option` | string or null | `()` |
| `Status` | string or null | `()` |
| `Options` | list of objects ([Accounting\TrackingCategory\Option](accounting.md#accountingtrackingcategoryoption)) | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L15)
- [`getTrackingCategoryID(): ?string`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L35)
- [`setTrackingCategoryID(?string $trackingCategoryID): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L40)
- [`getTrackingOptionID(): ?string`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L47)
- [`setTrackingOptionID(?string $trackingOptionID): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L52)
- [`getName(): ?string`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L59)
- [`setName(?string $name): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L64)
- [`getOption(): ?string`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L71)
- [`setOption(?string $option): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L76)
- [`getStatus(): ?string`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L83)
- [`setStatus(?string $status): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L88)
- [`getOptions(): array`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L98)
- [`setOptions(array $options): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L106)
- [`addOption(\Sujip\Xero\Accounting\TrackingCategory\Option $option): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L113)
- [`toRequest(): array`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L138)
- [`name(string $name): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L153)
- [`option(string $name): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L158)
- [`save(): Sujip\Xero\Accounting\TrackingCategory\TrackingCategory`](../../src/Accounting/TrackingCategory/TrackingCategory.php#L166)

## Accounting\User\User

[Source](../../src/Accounting/User/User.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `UserID` | string or null | `()` |
| `FirstName` | string or null | `()` |
| `LastName` | string or null | `()` |
| `EmailAddress` | string or null | `()` |
| `IsSubscriber` | bool or null | `()` |
| `UpdatedDateUTC` | string or null | `()` |
| `OrganisationRole` | string or null | `()` |

### Public methods

- [`getUserID(): ?string`](../../src/Accounting/User/User.php#L26)
- [`setUserID(?string $userID): Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/User.php#L31)
- [`getFirstName(): ?string`](../../src/Accounting/User/User.php#L38)
- [`setFirstName(?string $firstName): Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/User.php#L43)
- [`getLastName(): ?string`](../../src/Accounting/User/User.php#L50)
- [`setLastName(?string $lastName): Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/User.php#L55)
- [`getEmailAddress(): ?string`](../../src/Accounting/User/User.php#L62)
- [`setEmailAddress(?string $emailAddress): Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/User.php#L67)
- [`getIsSubscriber(): ?bool`](../../src/Accounting/User/User.php#L74)
- [`setIsSubscriber(?bool $isSubscriber): Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/User.php#L79)
- [`getUpdatedDateUTC(): ?string`](../../src/Accounting/User/User.php#L86)
- [`setUpdatedDateUTC(?string $updatedDateUTC): Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/User.php#L91)
- [`getOrganisationRole(): ?string`](../../src/Accounting/User/User.php#L98)
- [`setOrganisationRole(?string $organisationRole): Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/User.php#L103)

## Accounting\User\Users

[Source](../../src/Accounting/User/Users.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Accounting/User/Users.php#L19)
- [`__construct(\Sujip\Xero\Client $client)`](../../src/Accounting/User/Users.php#L20)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Accounting/User/Users.php#L25)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Accounting/User/Users.php#L27)
- [`where(string $expression, mixed ...$bindings): Sujip\Xero\Accounting\User\Users`](../../src/Accounting/User/Users.php#L33)
- [`ids(string ...$ids): static`](../../src/Accounting/User/Users.php#L35)
- [`unitDp(int $unitDp): static`](../../src/Accounting/User/Users.php#L43)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Accounting/User/Users.php#L44)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Accounting/User/Users.php#L51)
- [`find(string $userId): ?\Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/Users.php#L61)
- [`mapUser(array $payload): Sujip\Xero\Accounting\User\User`](../../src/Accounting/User/Users.php#L76)
