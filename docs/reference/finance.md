# Finance reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Finance\BankStatementAccounting\BankStatementAccounting](#financebankstatementaccountingbankstatementaccounting)
- [Finance\BankStatementAccounting\BankStatementAccountingResult](#financebankstatementaccountingbankstatementaccountingresult)
- [Finance\BankStatementAccounting\BankTransaction](#financebankstatementaccountingbanktransaction)
- [Finance\BankStatementAccounting\Contact](#financebankstatementaccountingcontact)
- [Finance\BankStatementAccounting\CreditNote](#financebankstatementaccountingcreditnote)
- [Finance\BankStatementAccounting\Invoice](#financebankstatementaccountinginvoice)
- [Finance\BankStatementAccounting\LineItem](#financebankstatementaccountinglineitem)
- [Finance\BankStatementAccounting\Overpayment](#financebankstatementaccountingoverpayment)
- [Finance\BankStatementAccounting\Payment](#financebankstatementaccountingpayment)
- [Finance\BankStatementAccounting\Prepayment](#financebankstatementaccountingprepayment)
- [Finance\BankStatementAccounting\Statement](#financebankstatementaccountingstatement)
- [Finance\BankStatementAccounting\StatementLine](#financebankstatementaccountingstatementline)
- [Finance\CashValidation\BankStatement](#financecashvalidationbankstatement)
- [Finance\CashValidation\CashAccount](#financecashvalidationcashaccount)
- [Finance\CashValidation\CashValidation](#financecashvalidationcashvalidation)
- [Finance\CashValidation\CashValidationResult](#financecashvalidationcashvalidationresult)
- [Finance\CashValidation\CurrentStatement](#financecashvalidationcurrentstatement)
- [Finance\CashValidation\DataSource](#financecashvalidationdatasource)
- [Finance\CashValidation\StatementBalance](#financecashvalidationstatementbalance)
- [Finance\CashValidation\StatementLines](#financecashvalidationstatementlines)
- [Finance\Finance](#financefinance)
- [Finance\FinancialStatement\BalanceSheet](#financefinancialstatementbalancesheet)
- [Finance\FinancialStatement\BalanceSheetAccountDetail](#financefinancialstatementbalancesheetaccountdetail)
- [Finance\FinancialStatement\BalanceSheetAccountGroup](#financefinancialstatementbalancesheetaccountgroup)
- [Finance\FinancialStatement\BalanceSheetAccountType](#financefinancialstatementbalancesheetaccounttype)
- [Finance\FinancialStatement\CashBalance](#financefinancialstatementcashbalance)
- [Finance\FinancialStatement\Cashflow](#financefinancialstatementcashflow)
- [Finance\FinancialStatement\CashflowAccount](#financefinancialstatementcashflowaccount)
- [Finance\FinancialStatement\CashflowActivity](#financefinancialstatementcashflowactivity)
- [Finance\FinancialStatement\CashflowType](#financefinancialstatementcashflowtype)
- [Finance\FinancialStatement\ContactDetail](#financefinancialstatementcontactdetail)
- [Finance\FinancialStatement\ContactTotalDetail](#financefinancialstatementcontacttotaldetail)
- [Finance\FinancialStatement\ContactTotalOther](#financefinancialstatementcontacttotalother)
- [Finance\FinancialStatement\FinancialStatements](#financefinancialstatementfinancialstatements)
- [Finance\FinancialStatement\IncomeByContact](#financefinancialstatementincomebycontact)
- [Finance\FinancialStatement\ManualJournalTotal](#financefinancialstatementmanualjournaltotal)
- [Finance\FinancialStatement\PnlAccount](#financefinancialstatementpnlaccount)
- [Finance\FinancialStatement\PnlAccountClass](#financefinancialstatementpnlaccountclass)
- [Finance\FinancialStatement\PnlAccountType](#financefinancialstatementpnlaccounttype)
- [Finance\FinancialStatement\ProfitAndLoss](#financefinancialstatementprofitandloss)
- [Finance\FinancialStatement\TotalDetail](#financefinancialstatementtotaldetail)
- [Finance\FinancialStatement\TotalOther](#financefinancialstatementtotalother)
- [Finance\FinancialStatement\TrialBalance](#financefinancialstatementtrialbalance)
- [Finance\FinancialStatement\TrialBalanceAccount](#financefinancialstatementtrialbalanceaccount)
- [Finance\FinancialStatement\TrialBalanceEntry](#financefinancialstatementtrialbalanceentry)
- [Finance\FinancialStatement\TrialBalanceMovement](#financefinancialstatementtrialbalancemovement)

## Finance\BankStatementAccounting\BankStatementAccounting

[Source](../../src/Finance/BankStatementAccounting/BankStatementAccounting.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Finance/BankStatementAccounting/BankStatementAccounting.php#L14)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Finance/BankStatementAccounting/BankStatementAccounting.php#L19)
- [`get(string $bankAccountId, \DateTimeInterface $fromDate, \DateTimeInterface $toDate, ?bool $summaryOnly = NULL): Sujip\Xero\Finance\BankStatementAccounting\BankStatementAccountingResult`](../../src/Finance/BankStatementAccounting/BankStatementAccounting.php#L27)

## Finance\BankStatementAccounting\BankStatementAccountingResult

[Source](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `bankAccountId` | string or null | `()` |
| `bankAccountName` | string or null | `()` |
| `bankAccountCurrencyCode` | string or null | `()` |
| `statements` | list of objects ([Finance\BankStatementAccounting\Statement](finance.md#financebankstatementaccountingstatement)) | `()` |

### Public methods

- [`getBankAccountId(): ?string`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L23)
- [`setBankAccountId(?string $bankAccountId): Sujip\Xero\Finance\BankStatementAccounting\BankStatementAccountingResult`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L28)
- [`getBankAccountName(): ?string`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L35)
- [`setBankAccountName(?string $bankAccountName): Sujip\Xero\Finance\BankStatementAccounting\BankStatementAccountingResult`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L40)
- [`getBankAccountCurrencyCode(): ?string`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L47)
- [`setBankAccountCurrencyCode(?string $bankAccountCurrencyCode): Sujip\Xero\Finance\BankStatementAccounting\BankStatementAccountingResult`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L52)
- [`getStatements(): array`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L62)
- [`setStatements(array $statements): Sujip\Xero\Finance\BankStatementAccounting\BankStatementAccountingResult`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L70)
- [`addStatement(\Sujip\Xero\Finance\BankStatementAccounting\Statement $statement): Sujip\Xero\Finance\BankStatementAccounting\BankStatementAccountingResult`](../../src/Finance/BankStatementAccounting/BankStatementAccountingResult.php#L77)

## Finance\BankStatementAccounting\BankTransaction

[Source](../../src/Finance/BankStatementAccounting/BankTransaction.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `bankTransactionId` | string or null | `()` |
| `batchPaymentId` | string or null | `()` |
| `contact` | object or null ([Finance\BankStatementAccounting\Contact](finance.md#financebankstatementaccountingcontact)) | `()` |
| `date` | string or null | `()` |
| `amount` | int, float, or null | `()` |
| `lineItems` | list of objects ([Finance\BankStatementAccounting\LineItem](finance.md#financebankstatementaccountinglineitem)) | `()` |

### Public methods

- [`getBankTransactionId(): ?string`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L27)
- [`setBankTransactionId(?string $bankTransactionId): Sujip\Xero\Finance\BankStatementAccounting\BankTransaction`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L32)
- [`getBatchPaymentId(): ?string`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L39)
- [`setBatchPaymentId(?string $batchPaymentId): Sujip\Xero\Finance\BankStatementAccounting\BankTransaction`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L44)
- [`getContact(): ?\Sujip\Xero\Finance\BankStatementAccounting\Contact`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L51)
- [`setContact(?\Sujip\Xero\Finance\BankStatementAccounting\Contact $contact): Sujip\Xero\Finance\BankStatementAccounting\BankTransaction`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L56)
- [`getDate(): ?string`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L63)
- [`setDate(?string $date): Sujip\Xero\Finance\BankStatementAccounting\BankTransaction`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L68)
- [`getAmount(): int\|float\|null`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L75)
- [`setAmount(int\|float\|null $amount): Sujip\Xero\Finance\BankStatementAccounting\BankTransaction`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L80)
- [`getLineItems(): array`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L90)
- [`setLineItems(array $lineItems): Sujip\Xero\Finance\BankStatementAccounting\BankTransaction`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L98)
- [`addLineItem(\Sujip\Xero\Finance\BankStatementAccounting\LineItem $lineItem): Sujip\Xero\Finance\BankStatementAccounting\BankTransaction`](../../src/Finance/BankStatementAccounting/BankTransaction.php#L105)

## Finance\BankStatementAccounting\Contact

[Source](../../src/Finance/BankStatementAccounting/Contact.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `contactId` | string or null | `()` |
| `contactName` | string or null | `()` |

### Public methods

- [`getContactId(): ?string`](../../src/Finance/BankStatementAccounting/Contact.php#L16)
- [`setContactId(?string $contactId): Sujip\Xero\Finance\BankStatementAccounting\Contact`](../../src/Finance/BankStatementAccounting/Contact.php#L21)
- [`getContactName(): ?string`](../../src/Finance/BankStatementAccounting/Contact.php#L28)
- [`setContactName(?string $contactName): Sujip\Xero\Finance\BankStatementAccounting\Contact`](../../src/Finance/BankStatementAccounting/Contact.php#L33)

## Finance\BankStatementAccounting\CreditNote

[Source](../../src/Finance/BankStatementAccounting/CreditNote.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `creditNoteId` | string or null | `()` |
| `contact` | object or null ([Finance\BankStatementAccounting\Contact](finance.md#financebankstatementaccountingcontact)) | `()` |
| `total` | int, float, or null | `()` |
| `lineItems` | list of objects ([Finance\BankStatementAccounting\LineItem](finance.md#financebankstatementaccountinglineitem)) | `()` |

### Public methods

- [`getCreditNoteId(): ?string`](../../src/Finance/BankStatementAccounting/CreditNote.php#L23)
- [`setCreditNoteId(?string $creditNoteId): Sujip\Xero\Finance\BankStatementAccounting\CreditNote`](../../src/Finance/BankStatementAccounting/CreditNote.php#L28)
- [`getContact(): ?\Sujip\Xero\Finance\BankStatementAccounting\Contact`](../../src/Finance/BankStatementAccounting/CreditNote.php#L35)
- [`setContact(?\Sujip\Xero\Finance\BankStatementAccounting\Contact $contact): Sujip\Xero\Finance\BankStatementAccounting\CreditNote`](../../src/Finance/BankStatementAccounting/CreditNote.php#L40)
- [`getTotal(): int\|float\|null`](../../src/Finance/BankStatementAccounting/CreditNote.php#L47)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\BankStatementAccounting\CreditNote`](../../src/Finance/BankStatementAccounting/CreditNote.php#L52)
- [`getLineItems(): array`](../../src/Finance/BankStatementAccounting/CreditNote.php#L62)
- [`setLineItems(array $lineItems): Sujip\Xero\Finance\BankStatementAccounting\CreditNote`](../../src/Finance/BankStatementAccounting/CreditNote.php#L70)
- [`addLineItem(\Sujip\Xero\Finance\BankStatementAccounting\LineItem $lineItem): Sujip\Xero\Finance\BankStatementAccounting\CreditNote`](../../src/Finance/BankStatementAccounting/CreditNote.php#L77)

## Finance\BankStatementAccounting\Invoice

[Source](../../src/Finance/BankStatementAccounting/Invoice.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `invoiceId` | string or null | `()` |
| `contact` | object or null ([Finance\BankStatementAccounting\Contact](finance.md#financebankstatementaccountingcontact)) | `()` |
| `total` | int, float, or null | `()` |
| `lineItems` | list of objects ([Finance\BankStatementAccounting\LineItem](finance.md#financebankstatementaccountinglineitem)) | `()` |

### Public methods

- [`getInvoiceId(): ?string`](../../src/Finance/BankStatementAccounting/Invoice.php#L23)
- [`setInvoiceId(?string $invoiceId): Sujip\Xero\Finance\BankStatementAccounting\Invoice`](../../src/Finance/BankStatementAccounting/Invoice.php#L28)
- [`getContact(): ?\Sujip\Xero\Finance\BankStatementAccounting\Contact`](../../src/Finance/BankStatementAccounting/Invoice.php#L35)
- [`setContact(?\Sujip\Xero\Finance\BankStatementAccounting\Contact $contact): Sujip\Xero\Finance\BankStatementAccounting\Invoice`](../../src/Finance/BankStatementAccounting/Invoice.php#L40)
- [`getTotal(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Invoice.php#L47)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\BankStatementAccounting\Invoice`](../../src/Finance/BankStatementAccounting/Invoice.php#L52)
- [`getLineItems(): array`](../../src/Finance/BankStatementAccounting/Invoice.php#L62)
- [`setLineItems(array $lineItems): Sujip\Xero\Finance\BankStatementAccounting\Invoice`](../../src/Finance/BankStatementAccounting/Invoice.php#L70)
- [`addLineItem(\Sujip\Xero\Finance\BankStatementAccounting\LineItem $lineItem): Sujip\Xero\Finance\BankStatementAccounting\Invoice`](../../src/Finance/BankStatementAccounting/Invoice.php#L77)

## Finance\BankStatementAccounting\LineItem

[Source](../../src/Finance/BankStatementAccounting/LineItem.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accountId` | string or null | `()` |
| `reportingCode` | string or null | `()` |
| `lineAmount` | int, float, or null | `()` |
| `accountType` | string or null | `()` |

### Public methods

- [`getAccountId(): ?string`](../../src/Finance/BankStatementAccounting/LineItem.php#L20)
- [`setAccountId(?string $accountId): Sujip\Xero\Finance\BankStatementAccounting\LineItem`](../../src/Finance/BankStatementAccounting/LineItem.php#L25)
- [`getReportingCode(): ?string`](../../src/Finance/BankStatementAccounting/LineItem.php#L32)
- [`setReportingCode(?string $reportingCode): Sujip\Xero\Finance\BankStatementAccounting\LineItem`](../../src/Finance/BankStatementAccounting/LineItem.php#L37)
- [`getLineAmount(): int\|float\|null`](../../src/Finance/BankStatementAccounting/LineItem.php#L44)
- [`setLineAmount(int\|float\|null $lineAmount): Sujip\Xero\Finance\BankStatementAccounting\LineItem`](../../src/Finance/BankStatementAccounting/LineItem.php#L49)
- [`getAccountType(): ?string`](../../src/Finance/BankStatementAccounting/LineItem.php#L56)
- [`setAccountType(?string $accountType): Sujip\Xero\Finance\BankStatementAccounting\LineItem`](../../src/Finance/BankStatementAccounting/LineItem.php#L61)

## Finance\BankStatementAccounting\Overpayment

[Source](../../src/Finance/BankStatementAccounting/Overpayment.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `overpaymentId` | string or null | `()` |
| `contact` | object or null ([Finance\BankStatementAccounting\Contact](finance.md#financebankstatementaccountingcontact)) | `()` |
| `total` | int, float, or null | `()` |
| `lineItems` | list of objects ([Finance\BankStatementAccounting\LineItem](finance.md#financebankstatementaccountinglineitem)) | `()` |

### Public methods

- [`getOverpaymentId(): ?string`](../../src/Finance/BankStatementAccounting/Overpayment.php#L23)
- [`setOverpaymentId(?string $overpaymentId): Sujip\Xero\Finance\BankStatementAccounting\Overpayment`](../../src/Finance/BankStatementAccounting/Overpayment.php#L28)
- [`getContact(): ?\Sujip\Xero\Finance\BankStatementAccounting\Contact`](../../src/Finance/BankStatementAccounting/Overpayment.php#L35)
- [`setContact(?\Sujip\Xero\Finance\BankStatementAccounting\Contact $contact): Sujip\Xero\Finance\BankStatementAccounting\Overpayment`](../../src/Finance/BankStatementAccounting/Overpayment.php#L40)
- [`getTotal(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Overpayment.php#L47)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\BankStatementAccounting\Overpayment`](../../src/Finance/BankStatementAccounting/Overpayment.php#L52)
- [`getLineItems(): array`](../../src/Finance/BankStatementAccounting/Overpayment.php#L62)
- [`setLineItems(array $lineItems): Sujip\Xero\Finance\BankStatementAccounting\Overpayment`](../../src/Finance/BankStatementAccounting/Overpayment.php#L70)
- [`addLineItem(\Sujip\Xero\Finance\BankStatementAccounting\LineItem $lineItem): Sujip\Xero\Finance\BankStatementAccounting\Overpayment`](../../src/Finance/BankStatementAccounting/Overpayment.php#L77)

## Finance\BankStatementAccounting\Payment

[Source](../../src/Finance/BankStatementAccounting/Payment.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `paymentId` | string or null | `()` |
| `batchPaymentId` | string or null | `()` |
| `date` | string or null | `()` |
| `amount` | int, float, or null | `()` |
| `bankAmount` | int, float, or null | `()` |
| `currencyRate` | int, float, or null | `()` |
| `invoice` | object or null ([Finance\BankStatementAccounting\Invoice](finance.md#financebankstatementaccountinginvoice)) | `()` |
| `creditNote` | object or null ([Finance\BankStatementAccounting\CreditNote](finance.md#financebankstatementaccountingcreditnote)) | `()` |
| `prepayment` | object or null ([Finance\BankStatementAccounting\Prepayment](finance.md#financebankstatementaccountingprepayment)) | `()` |
| `overpayment` | object or null ([Finance\BankStatementAccounting\Overpayment](finance.md#financebankstatementaccountingoverpayment)) | `()` |

### Public methods

- [`getPaymentId(): ?string`](../../src/Finance/BankStatementAccounting/Payment.php#L32)
- [`setPaymentId(?string $paymentId): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L37)
- [`getBatchPaymentId(): ?string`](../../src/Finance/BankStatementAccounting/Payment.php#L44)
- [`setBatchPaymentId(?string $batchPaymentId): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L49)
- [`getDate(): ?string`](../../src/Finance/BankStatementAccounting/Payment.php#L56)
- [`setDate(?string $date): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L61)
- [`getAmount(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Payment.php#L68)
- [`setAmount(int\|float\|null $amount): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L73)
- [`getBankAmount(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Payment.php#L80)
- [`setBankAmount(int\|float\|null $bankAmount): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L85)
- [`getCurrencyRate(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Payment.php#L92)
- [`setCurrencyRate(int\|float\|null $currencyRate): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L97)
- [`getInvoice(): ?\Sujip\Xero\Finance\BankStatementAccounting\Invoice`](../../src/Finance/BankStatementAccounting/Payment.php#L104)
- [`setInvoice(?\Sujip\Xero\Finance\BankStatementAccounting\Invoice $invoice): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L109)
- [`getCreditNote(): ?\Sujip\Xero\Finance\BankStatementAccounting\CreditNote`](../../src/Finance/BankStatementAccounting/Payment.php#L116)
- [`setCreditNote(?\Sujip\Xero\Finance\BankStatementAccounting\CreditNote $creditNote): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L121)
- [`getPrepayment(): ?\Sujip\Xero\Finance\BankStatementAccounting\Prepayment`](../../src/Finance/BankStatementAccounting/Payment.php#L128)
- [`setPrepayment(?\Sujip\Xero\Finance\BankStatementAccounting\Prepayment $prepayment): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L133)
- [`getOverpayment(): ?\Sujip\Xero\Finance\BankStatementAccounting\Overpayment`](../../src/Finance/BankStatementAccounting/Payment.php#L140)
- [`setOverpayment(?\Sujip\Xero\Finance\BankStatementAccounting\Overpayment $overpayment): Sujip\Xero\Finance\BankStatementAccounting\Payment`](../../src/Finance/BankStatementAccounting/Payment.php#L145)

## Finance\BankStatementAccounting\Prepayment

[Source](../../src/Finance/BankStatementAccounting/Prepayment.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `prepaymentId` | string or null | `()` |
| `contact` | object or null ([Finance\BankStatementAccounting\Contact](finance.md#financebankstatementaccountingcontact)) | `()` |
| `total` | int, float, or null | `()` |
| `lineItems` | list of objects ([Finance\BankStatementAccounting\LineItem](finance.md#financebankstatementaccountinglineitem)) | `()` |

### Public methods

- [`getPrepaymentId(): ?string`](../../src/Finance/BankStatementAccounting/Prepayment.php#L23)
- [`setPrepaymentId(?string $prepaymentId): Sujip\Xero\Finance\BankStatementAccounting\Prepayment`](../../src/Finance/BankStatementAccounting/Prepayment.php#L28)
- [`getContact(): ?\Sujip\Xero\Finance\BankStatementAccounting\Contact`](../../src/Finance/BankStatementAccounting/Prepayment.php#L35)
- [`setContact(?\Sujip\Xero\Finance\BankStatementAccounting\Contact $contact): Sujip\Xero\Finance\BankStatementAccounting\Prepayment`](../../src/Finance/BankStatementAccounting/Prepayment.php#L40)
- [`getTotal(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Prepayment.php#L47)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\BankStatementAccounting\Prepayment`](../../src/Finance/BankStatementAccounting/Prepayment.php#L52)
- [`getLineItems(): array`](../../src/Finance/BankStatementAccounting/Prepayment.php#L62)
- [`setLineItems(array $lineItems): Sujip\Xero\Finance\BankStatementAccounting\Prepayment`](../../src/Finance/BankStatementAccounting/Prepayment.php#L70)
- [`addLineItem(\Sujip\Xero\Finance\BankStatementAccounting\LineItem $lineItem): Sujip\Xero\Finance\BankStatementAccounting\Prepayment`](../../src/Finance/BankStatementAccounting/Prepayment.php#L77)

## Finance\BankStatementAccounting\Statement

[Source](../../src/Finance/BankStatementAccounting/Statement.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `statementId` | string or null | `()` |
| `startDate` | string or null | `()` |
| `endDate` | string or null | `()` |
| `importedDateTimeUtc` | string or null | `()` |
| `importSource` | string or null | `()` |
| `startBalance` | int, float, or null | `()` |
| `endBalance` | int, float, or null | `()` |
| `indicativeStartBalance` | int, float, or null | `()` |
| `indicativeEndBalance` | int, float, or null | `()` |
| `statementLines` | list of objects ([Finance\BankStatementAccounting\StatementLine](finance.md#financebankstatementaccountingstatementline)) | `()` |

### Public methods

- [`getStatementId(): ?string`](../../src/Finance/BankStatementAccounting/Statement.php#L35)
- [`setStatementId(?string $statementId): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L40)
- [`getStartDate(): ?string`](../../src/Finance/BankStatementAccounting/Statement.php#L47)
- [`setStartDate(?string $startDate): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L52)
- [`getEndDate(): ?string`](../../src/Finance/BankStatementAccounting/Statement.php#L59)
- [`setEndDate(?string $endDate): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L64)
- [`getImportedDateTimeUtc(): ?string`](../../src/Finance/BankStatementAccounting/Statement.php#L71)
- [`setImportedDateTimeUtc(?string $importedDateTimeUtc): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L76)
- [`getImportSource(): ?string`](../../src/Finance/BankStatementAccounting/Statement.php#L83)
- [`setImportSource(?string $importSource): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L88)
- [`getStartBalance(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Statement.php#L95)
- [`setStartBalance(int\|float\|null $startBalance): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L100)
- [`getEndBalance(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Statement.php#L107)
- [`setEndBalance(int\|float\|null $endBalance): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L112)
- [`getIndicativeStartBalance(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Statement.php#L119)
- [`setIndicativeStartBalance(int\|float\|null $indicativeStartBalance): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L124)
- [`getIndicativeEndBalance(): int\|float\|null`](../../src/Finance/BankStatementAccounting/Statement.php#L131)
- [`setIndicativeEndBalance(int\|float\|null $indicativeEndBalance): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L136)
- [`getStatementLines(): array`](../../src/Finance/BankStatementAccounting/Statement.php#L146)
- [`setStatementLines(array $statementLines): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L154)
- [`addStatementLine(\Sujip\Xero\Finance\BankStatementAccounting\StatementLine $statementLine): Sujip\Xero\Finance\BankStatementAccounting\Statement`](../../src/Finance/BankStatementAccounting/Statement.php#L161)

## Finance\BankStatementAccounting\StatementLine

[Source](../../src/Finance/BankStatementAccounting/StatementLine.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `statementLineId` | string or null | `()` |
| `postedDate` | string or null | `()` |
| `payee` | string or null | `()` |
| `reference` | string or null | `()` |
| `notes` | string or null | `()` |
| `chequeNo` | string or null | `()` |
| `amount` | int, float, or null | `()` |
| `transactionDate` | string or null | `()` |
| `type` | string or null | `()` |
| `isReconciled` | bool or null | `()` |
| `isDuplicate` | bool or null | `()` |
| `isDeleted` | bool or null | `()` |
| `payments` | list of objects ([Finance\BankStatementAccounting\Payment](finance.md#financebankstatementaccountingpayment)) | `()` |
| `bankTransactions` | list of objects ([Finance\BankStatementAccounting\BankTransaction](finance.md#financebankstatementaccountingbanktransaction)) | `()` |

### Public methods

- [`getStatementLineId(): ?string`](../../src/Finance/BankStatementAccounting/StatementLine.php#L46)
- [`setStatementLineId(?string $statementLineId): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L51)
- [`getPostedDate(): ?string`](../../src/Finance/BankStatementAccounting/StatementLine.php#L58)
- [`setPostedDate(?string $postedDate): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L63)
- [`getPayee(): ?string`](../../src/Finance/BankStatementAccounting/StatementLine.php#L70)
- [`setPayee(?string $payee): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L75)
- [`getReference(): ?string`](../../src/Finance/BankStatementAccounting/StatementLine.php#L82)
- [`setReference(?string $reference): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L87)
- [`getNotes(): ?string`](../../src/Finance/BankStatementAccounting/StatementLine.php#L94)
- [`setNotes(?string $notes): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L99)
- [`getChequeNo(): ?string`](../../src/Finance/BankStatementAccounting/StatementLine.php#L106)
- [`setChequeNo(?string $chequeNo): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L111)
- [`getAmount(): int\|float\|null`](../../src/Finance/BankStatementAccounting/StatementLine.php#L118)
- [`setAmount(int\|float\|null $amount): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L123)
- [`getTransactionDate(): ?string`](../../src/Finance/BankStatementAccounting/StatementLine.php#L130)
- [`setTransactionDate(?string $transactionDate): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L135)
- [`getType(): ?string`](../../src/Finance/BankStatementAccounting/StatementLine.php#L142)
- [`setType(?string $type): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L147)
- [`getIsReconciled(): ?bool`](../../src/Finance/BankStatementAccounting/StatementLine.php#L154)
- [`setIsReconciled(?bool $isReconciled): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L159)
- [`getIsDuplicate(): ?bool`](../../src/Finance/BankStatementAccounting/StatementLine.php#L166)
- [`setIsDuplicate(?bool $isDuplicate): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L171)
- [`getIsDeleted(): ?bool`](../../src/Finance/BankStatementAccounting/StatementLine.php#L178)
- [`setIsDeleted(?bool $isDeleted): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L183)
- [`getPayments(): array`](../../src/Finance/BankStatementAccounting/StatementLine.php#L193)
- [`setPayments(array $payments): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L201)
- [`addPayment(\Sujip\Xero\Finance\BankStatementAccounting\Payment $payment): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L208)
- [`getBankTransactions(): array`](../../src/Finance/BankStatementAccounting/StatementLine.php#L218)
- [`setBankTransactions(array $bankTransactions): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L226)
- [`addBankTransaction(\Sujip\Xero\Finance\BankStatementAccounting\BankTransaction $bankTransaction): Sujip\Xero\Finance\BankStatementAccounting\StatementLine`](../../src/Finance/BankStatementAccounting/StatementLine.php#L233)

## Finance\CashValidation\BankStatement

[Source](../../src/Finance/CashValidation/BankStatement.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `statementLines` | object or null ([Finance\CashValidation\StatementLines](finance.md#financecashvalidationstatementlines)) | `()` |
| `currentStatement` | object or null ([Finance\CashValidation\CurrentStatement](finance.md#financecashvalidationcurrentstatement)) | `()` |

### Public methods

- [`getStatementLines(): ?\Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/BankStatement.php#L16)
- [`setStatementLines(?\Sujip\Xero\Finance\CashValidation\StatementLines $statementLines): Sujip\Xero\Finance\CashValidation\BankStatement`](../../src/Finance/CashValidation/BankStatement.php#L21)
- [`getCurrentStatement(): ?\Sujip\Xero\Finance\CashValidation\CurrentStatement`](../../src/Finance/CashValidation/BankStatement.php#L28)
- [`setCurrentStatement(?\Sujip\Xero\Finance\CashValidation\CurrentStatement $currentStatement): Sujip\Xero\Finance\CashValidation\BankStatement`](../../src/Finance/CashValidation/BankStatement.php#L33)

## Finance\CashValidation\CashAccount

[Source](../../src/Finance/CashValidation/CashAccount.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `unreconciledAmountPos` | int, float, or null | `()` |
| `unreconciledAmountNeg` | int, float, or null | `()` |
| `startingBalance` | int, float, or null | `()` |
| `accountBalance` | int, float, or null | `()` |
| `balanceCurrency` | string or null | `()` |

### Public methods

- [`getUnreconciledAmountPos(): int\|float\|null`](../../src/Finance/CashValidation/CashAccount.php#L22)
- [`setUnreconciledAmountPos(int\|float\|null $unreconciledAmountPos): Sujip\Xero\Finance\CashValidation\CashAccount`](../../src/Finance/CashValidation/CashAccount.php#L27)
- [`getUnreconciledAmountNeg(): int\|float\|null`](../../src/Finance/CashValidation/CashAccount.php#L34)
- [`setUnreconciledAmountNeg(int\|float\|null $unreconciledAmountNeg): Sujip\Xero\Finance\CashValidation\CashAccount`](../../src/Finance/CashValidation/CashAccount.php#L39)
- [`getStartingBalance(): int\|float\|null`](../../src/Finance/CashValidation/CashAccount.php#L46)
- [`setStartingBalance(int\|float\|null $startingBalance): Sujip\Xero\Finance\CashValidation\CashAccount`](../../src/Finance/CashValidation/CashAccount.php#L51)
- [`getAccountBalance(): int\|float\|null`](../../src/Finance/CashValidation/CashAccount.php#L58)
- [`setAccountBalance(int\|float\|null $accountBalance): Sujip\Xero\Finance\CashValidation\CashAccount`](../../src/Finance/CashValidation/CashAccount.php#L63)
- [`getBalanceCurrency(): ?string`](../../src/Finance/CashValidation/CashAccount.php#L70)
- [`setBalanceCurrency(?string $balanceCurrency): Sujip\Xero\Finance\CashValidation\CashAccount`](../../src/Finance/CashValidation/CashAccount.php#L75)

## Finance\CashValidation\CashValidation

[Source](../../src/Finance/CashValidation/CashValidation.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Finance/CashValidation/CashValidation.php#L16)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Finance/CashValidation/CashValidation.php#L21)
- [`get(?\DateTimeInterface $balanceDate = NULL, ?\DateTimeInterface $asAtSystemDate = NULL, ?\DateTimeInterface $beginDate = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Finance/CashValidation/CashValidation.php#L32)

## Finance\CashValidation\CashValidationResult

[Source](../../src/Finance/CashValidation/CashValidationResult.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accountId` | string or null | `()` |
| `statementBalance` | object or null ([Finance\CashValidation\StatementBalance](finance.md#financecashvalidationstatementbalance)) | `()` |
| `statementBalanceDate` | string or null | `()` |
| `bankStatement` | object or null ([Finance\CashValidation\BankStatement](finance.md#financecashvalidationbankstatement)) | `()` |
| `cashAccount` | object or null ([Finance\CashValidation\CashAccount](finance.md#financecashvalidationcashaccount)) | `()` |

### Public methods

- [`getAccountId(): ?string`](../../src/Finance/CashValidation/CashValidationResult.php#L22)
- [`setAccountId(?string $accountId): Sujip\Xero\Finance\CashValidation\CashValidationResult`](../../src/Finance/CashValidation/CashValidationResult.php#L27)
- [`getStatementBalance(): ?\Sujip\Xero\Finance\CashValidation\StatementBalance`](../../src/Finance/CashValidation/CashValidationResult.php#L34)
- [`setStatementBalance(?\Sujip\Xero\Finance\CashValidation\StatementBalance $statementBalance): Sujip\Xero\Finance\CashValidation\CashValidationResult`](../../src/Finance/CashValidation/CashValidationResult.php#L39)
- [`getStatementBalanceDate(): ?string`](../../src/Finance/CashValidation/CashValidationResult.php#L46)
- [`setStatementBalanceDate(?string $statementBalanceDate): Sujip\Xero\Finance\CashValidation\CashValidationResult`](../../src/Finance/CashValidation/CashValidationResult.php#L51)
- [`getBankStatement(): ?\Sujip\Xero\Finance\CashValidation\BankStatement`](../../src/Finance/CashValidation/CashValidationResult.php#L58)
- [`setBankStatement(?\Sujip\Xero\Finance\CashValidation\BankStatement $bankStatement): Sujip\Xero\Finance\CashValidation\CashValidationResult`](../../src/Finance/CashValidation/CashValidationResult.php#L63)
- [`getCashAccount(): ?\Sujip\Xero\Finance\CashValidation\CashAccount`](../../src/Finance/CashValidation/CashValidationResult.php#L70)
- [`setCashAccount(?\Sujip\Xero\Finance\CashValidation\CashAccount $cashAccount): Sujip\Xero\Finance\CashValidation\CashValidationResult`](../../src/Finance/CashValidation/CashValidationResult.php#L75)

## Finance\CashValidation\CurrentStatement

[Source](../../src/Finance/CashValidation/CurrentStatement.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `startDate` | string or null | `()` |
| `endDate` | string or null | `()` |
| `startBalance` | int, float, or null | `()` |
| `endBalance` | int, float, or null | `()` |
| `importedDateTimeUtc` | string or null | `()` |
| `importSourceType` | string or null | `()` |

### Public methods

- [`getStartDate(): ?string`](../../src/Finance/CashValidation/CurrentStatement.php#L24)
- [`setStartDate(?string $startDate): Sujip\Xero\Finance\CashValidation\CurrentStatement`](../../src/Finance/CashValidation/CurrentStatement.php#L29)
- [`getEndDate(): ?string`](../../src/Finance/CashValidation/CurrentStatement.php#L36)
- [`setEndDate(?string $endDate): Sujip\Xero\Finance\CashValidation\CurrentStatement`](../../src/Finance/CashValidation/CurrentStatement.php#L41)
- [`getStartBalance(): int\|float\|null`](../../src/Finance/CashValidation/CurrentStatement.php#L48)
- [`setStartBalance(int\|float\|null $startBalance): Sujip\Xero\Finance\CashValidation\CurrentStatement`](../../src/Finance/CashValidation/CurrentStatement.php#L53)
- [`getEndBalance(): int\|float\|null`](../../src/Finance/CashValidation/CurrentStatement.php#L60)
- [`setEndBalance(int\|float\|null $endBalance): Sujip\Xero\Finance\CashValidation\CurrentStatement`](../../src/Finance/CashValidation/CurrentStatement.php#L65)
- [`getImportedDateTimeUtc(): ?string`](../../src/Finance/CashValidation/CurrentStatement.php#L72)
- [`setImportedDateTimeUtc(?string $importedDateTimeUtc): Sujip\Xero\Finance\CashValidation\CurrentStatement`](../../src/Finance/CashValidation/CurrentStatement.php#L77)
- [`getImportSourceType(): ?string`](../../src/Finance/CashValidation/CurrentStatement.php#L84)
- [`setImportSourceType(?string $importSourceType): Sujip\Xero\Finance\CashValidation\CurrentStatement`](../../src/Finance/CashValidation/CurrentStatement.php#L89)

## Finance\CashValidation\DataSource

[Source](../../src/Finance/CashValidation/DataSource.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `directBankFeed` | int, float, or null | `()` |
| `fileUpload` | int, float, or null | `()` |
| `manual` | int, float, or null | `()` |
| `directBankFeedPos` | int, float, or null | `()` |
| `fileUploadPos` | int, float, or null | `()` |
| `manualPos` | int, float, or null | `()` |
| `directBankFeedNeg` | int, float, or null | `()` |
| `fileUploadNeg` | int, float, or null | `()` |
| `manualNeg` | int, float, or null | `()` |
| `otherPos` | int, float, or null | `()` |
| `otherNeg` | int, float, or null | `()` |
| `other` | int, float, or null | `()` |

### Public methods

- [`getDirectBankFeed(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L36)
- [`setDirectBankFeed(int\|float\|null $directBankFeed): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L41)
- [`getFileUpload(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L48)
- [`setFileUpload(int\|float\|null $fileUpload): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L53)
- [`getManual(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L60)
- [`setManual(int\|float\|null $manual): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L65)
- [`getDirectBankFeedPos(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L72)
- [`setDirectBankFeedPos(int\|float\|null $directBankFeedPos): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L77)
- [`getFileUploadPos(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L84)
- [`setFileUploadPos(int\|float\|null $fileUploadPos): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L89)
- [`getManualPos(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L96)
- [`setManualPos(int\|float\|null $manualPos): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L101)
- [`getDirectBankFeedNeg(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L108)
- [`setDirectBankFeedNeg(int\|float\|null $directBankFeedNeg): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L113)
- [`getFileUploadNeg(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L120)
- [`setFileUploadNeg(int\|float\|null $fileUploadNeg): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L125)
- [`getManualNeg(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L132)
- [`setManualNeg(int\|float\|null $manualNeg): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L137)
- [`getOtherPos(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L144)
- [`setOtherPos(int\|float\|null $otherPos): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L149)
- [`getOtherNeg(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L156)
- [`setOtherNeg(int\|float\|null $otherNeg): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L161)
- [`getOther(): int\|float\|null`](../../src/Finance/CashValidation/DataSource.php#L168)
- [`setOther(int\|float\|null $other): Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/DataSource.php#L173)

## Finance\CashValidation\StatementBalance

[Source](../../src/Finance/CashValidation/StatementBalance.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `value` | int, float, or null | `()` |
| `type` | string or null | `()` |

### Public methods

- [`getValue(): int\|float\|null`](../../src/Finance/CashValidation/StatementBalance.php#L16)
- [`setValue(int\|float\|null $value): Sujip\Xero\Finance\CashValidation\StatementBalance`](../../src/Finance/CashValidation/StatementBalance.php#L21)
- [`getType(): ?string`](../../src/Finance/CashValidation/StatementBalance.php#L28)
- [`setType(?string $type): Sujip\Xero\Finance\CashValidation\StatementBalance`](../../src/Finance/CashValidation/StatementBalance.php#L33)

## Finance\CashValidation\StatementLines

[Source](../../src/Finance/CashValidation/StatementLines.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `unreconciledAmountPos` | int, float, or null | `()` |
| `unreconciledAmountNeg` | int, float, or null | `()` |
| `unreconciledLines` | int, float, or null | `()` |
| `avgDaysUnreconciledPos` | int, float, or null | `()` |
| `avgDaysUnreconciledNeg` | int, float, or null | `()` |
| `earliestUnreconciledTransaction` | string or null | `()` |
| `latestUnreconciledTransaction` | string or null | `()` |
| `deletedAmount` | int, float, or null | `()` |
| `totalAmount` | int, float, or null | `()` |
| `dataSource` | object or null ([Finance\CashValidation\DataSource](finance.md#financecashvalidationdatasource)) | `()` |
| `earliestReconciledTransaction` | string or null | `()` |
| `latestReconciledTransaction` | string or null | `()` |
| `reconciledAmountPos` | int, float, or null | `()` |
| `reconciledAmountNeg` | int, float, or null | `()` |
| `reconciledLines` | int, float, or null | `()` |
| `totalAmountPos` | int, float, or null | `()` |
| `totalAmountNeg` | int, float, or null | `()` |

### Public methods

- [`getUnreconciledAmountPos(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L46)
- [`setUnreconciledAmountPos(int\|float\|null $unreconciledAmountPos): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L51)
- [`getUnreconciledAmountNeg(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L58)
- [`setUnreconciledAmountNeg(int\|float\|null $unreconciledAmountNeg): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L63)
- [`getUnreconciledLines(): ?int`](../../src/Finance/CashValidation/StatementLines.php#L70)
- [`setUnreconciledLines(?int $unreconciledLines): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L75)
- [`getAvgDaysUnreconciledPos(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L82)
- [`setAvgDaysUnreconciledPos(int\|float\|null $avgDaysUnreconciledPos): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L87)
- [`getAvgDaysUnreconciledNeg(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L94)
- [`setAvgDaysUnreconciledNeg(int\|float\|null $avgDaysUnreconciledNeg): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L99)
- [`getEarliestUnreconciledTransaction(): ?string`](../../src/Finance/CashValidation/StatementLines.php#L106)
- [`setEarliestUnreconciledTransaction(?string $earliestUnreconciledTransaction): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L111)
- [`getLatestUnreconciledTransaction(): ?string`](../../src/Finance/CashValidation/StatementLines.php#L118)
- [`setLatestUnreconciledTransaction(?string $latestUnreconciledTransaction): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L123)
- [`getDeletedAmount(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L130)
- [`setDeletedAmount(int\|float\|null $deletedAmount): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L135)
- [`getTotalAmount(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L142)
- [`setTotalAmount(int\|float\|null $totalAmount): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L147)
- [`getDataSource(): ?\Sujip\Xero\Finance\CashValidation\DataSource`](../../src/Finance/CashValidation/StatementLines.php#L154)
- [`setDataSource(?\Sujip\Xero\Finance\CashValidation\DataSource $dataSource): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L159)
- [`getEarliestReconciledTransaction(): ?string`](../../src/Finance/CashValidation/StatementLines.php#L166)
- [`setEarliestReconciledTransaction(?string $earliestReconciledTransaction): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L171)
- [`getLatestReconciledTransaction(): ?string`](../../src/Finance/CashValidation/StatementLines.php#L178)
- [`setLatestReconciledTransaction(?string $latestReconciledTransaction): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L183)
- [`getReconciledAmountPos(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L190)
- [`setReconciledAmountPos(int\|float\|null $reconciledAmountPos): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L195)
- [`getReconciledAmountNeg(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L202)
- [`setReconciledAmountNeg(int\|float\|null $reconciledAmountNeg): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L207)
- [`getReconciledLines(): ?int`](../../src/Finance/CashValidation/StatementLines.php#L214)
- [`setReconciledLines(?int $reconciledLines): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L219)
- [`getTotalAmountPos(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L226)
- [`setTotalAmountPos(int\|float\|null $totalAmountPos): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L231)
- [`getTotalAmountNeg(): int\|float\|null`](../../src/Finance/CashValidation/StatementLines.php#L238)
- [`setTotalAmountNeg(int\|float\|null $totalAmountNeg): Sujip\Xero\Finance\CashValidation\StatementLines`](../../src/Finance/CashValidation/StatementLines.php#L243)

## Finance\Finance

[Source](../../src/Finance/Finance.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Finance/Finance.php#L16)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Finance/Finance.php#L21)
- [`cashValidation(): Sujip\Xero\Finance\CashValidation\CashValidation`](../../src/Finance/Finance.php#L33)
- [`bankStatementAccounting(): Sujip\Xero\Finance\BankStatementAccounting\BankStatementAccounting`](../../src/Finance/Finance.php#L38)
- [`statements(): Sujip\Xero\Finance\FinancialStatement\FinancialStatements`](../../src/Finance/Finance.php#L43)

## Finance\FinancialStatement\BalanceSheet

[Source](../../src/Finance/FinancialStatement/BalanceSheet.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `balanceDate` | string or null | `()` |
| `asset` | object or null ([Finance\FinancialStatement\BalanceSheetAccountGroup](finance.md#financefinancialstatementbalancesheetaccountgroup)) | `()` |
| `liability` | object or null ([Finance\FinancialStatement\BalanceSheetAccountGroup](finance.md#financefinancialstatementbalancesheetaccountgroup)) | `()` |
| `equity` | object or null ([Finance\FinancialStatement\BalanceSheetAccountGroup](finance.md#financefinancialstatementbalancesheetaccountgroup)) | `()` |

### Public methods

- [`getBalanceDate(): ?string`](../../src/Finance/FinancialStatement/BalanceSheet.php#L20)
- [`setBalanceDate(?string $balanceDate): Sujip\Xero\Finance\FinancialStatement\BalanceSheet`](../../src/Finance/FinancialStatement/BalanceSheet.php#L25)
- [`getAsset(): ?\Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup`](../../src/Finance/FinancialStatement/BalanceSheet.php#L32)
- [`setAsset(?\Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup $asset): Sujip\Xero\Finance\FinancialStatement\BalanceSheet`](../../src/Finance/FinancialStatement/BalanceSheet.php#L37)
- [`getLiability(): ?\Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup`](../../src/Finance/FinancialStatement/BalanceSheet.php#L44)
- [`setLiability(?\Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup $liability): Sujip\Xero\Finance\FinancialStatement\BalanceSheet`](../../src/Finance/FinancialStatement/BalanceSheet.php#L49)
- [`getEquity(): ?\Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup`](../../src/Finance/FinancialStatement/BalanceSheet.php#L56)
- [`setEquity(?\Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup $equity): Sujip\Xero\Finance\FinancialStatement\BalanceSheet`](../../src/Finance/FinancialStatement/BalanceSheet.php#L61)

## Finance\FinancialStatement\BalanceSheetAccountDetail

[Source](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `code` | string or null | `()` |
| `accountID` | string or null | `()` |
| `name` | string or null | `()` |
| `reportingCode` | string or null | `()` |
| `total` | int, float, or null | `()` |

### Public methods

- [`getCode(): ?string`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L22)
- [`setCode(?string $code): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountDetail`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L27)
- [`getAccountID(): ?string`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L34)
- [`setAccountID(?string $accountID): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountDetail`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L39)
- [`getName(): ?string`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L46)
- [`setName(?string $name): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountDetail`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L51)
- [`getReportingCode(): ?string`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L58)
- [`setReportingCode(?string $reportingCode): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountDetail`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L63)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L70)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountDetail`](../../src/Finance/FinancialStatement/BalanceSheetAccountDetail.php#L75)

## Finance\FinancialStatement\BalanceSheetAccountGroup

[Source](../../src/Finance/FinancialStatement/BalanceSheetAccountGroup.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accountTypes` | list of objects ([Finance\FinancialStatement\BalanceSheetAccountType](finance.md#financefinancialstatementbalancesheetaccounttype)) | `()` |
| `total` | int, float, or null | `()` |

### Public methods

- [`getAccountTypes(): array`](../../src/Finance/FinancialStatement/BalanceSheetAccountGroup.php#L22)
- [`setAccountTypes(array $accountTypes): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup`](../../src/Finance/FinancialStatement/BalanceSheetAccountGroup.php#L30)
- [`addAccountType(\Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountType $accountType): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup`](../../src/Finance/FinancialStatement/BalanceSheetAccountGroup.php#L37)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/BalanceSheetAccountGroup.php#L44)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountGroup`](../../src/Finance/FinancialStatement/BalanceSheetAccountGroup.php#L49)

## Finance\FinancialStatement\BalanceSheetAccountType

[Source](../../src/Finance/FinancialStatement/BalanceSheetAccountType.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accountType` | string or null | `()` |
| `accounts` | list of objects ([Finance\FinancialStatement\BalanceSheetAccountDetail](finance.md#financefinancialstatementbalancesheetaccountdetail)) | `()` |
| `total` | int, float, or null | `()` |

### Public methods

- [`getAccountType(): ?string`](../../src/Finance/FinancialStatement/BalanceSheetAccountType.php#L21)
- [`setAccountType(?string $accountType): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountType`](../../src/Finance/FinancialStatement/BalanceSheetAccountType.php#L26)
- [`getAccounts(): array`](../../src/Finance/FinancialStatement/BalanceSheetAccountType.php#L36)
- [`setAccounts(array $accounts): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountType`](../../src/Finance/FinancialStatement/BalanceSheetAccountType.php#L44)
- [`addAccount(\Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountDetail $account): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountType`](../../src/Finance/FinancialStatement/BalanceSheetAccountType.php#L51)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/BalanceSheetAccountType.php#L58)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\BalanceSheetAccountType`](../../src/Finance/FinancialStatement/BalanceSheetAccountType.php#L63)

## Finance\FinancialStatement\CashBalance

[Source](../../src/Finance/FinancialStatement/CashBalance.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `openingCashBalance` | int, float, or null | `()` |
| `closingCashBalance` | int, float, or null | `()` |
| `netCashMovement` | int, float, or null | `()` |

### Public methods

- [`getOpeningCashBalance(): int\|float\|null`](../../src/Finance/FinancialStatement/CashBalance.php#L18)
- [`setOpeningCashBalance(int\|float\|null $openingCashBalance): Sujip\Xero\Finance\FinancialStatement\CashBalance`](../../src/Finance/FinancialStatement/CashBalance.php#L23)
- [`getClosingCashBalance(): int\|float\|null`](../../src/Finance/FinancialStatement/CashBalance.php#L30)
- [`setClosingCashBalance(int\|float\|null $closingCashBalance): Sujip\Xero\Finance\FinancialStatement\CashBalance`](../../src/Finance/FinancialStatement/CashBalance.php#L35)
- [`getNetCashMovement(): int\|float\|null`](../../src/Finance/FinancialStatement/CashBalance.php#L42)
- [`setNetCashMovement(int\|float\|null $netCashMovement): Sujip\Xero\Finance\FinancialStatement\CashBalance`](../../src/Finance/FinancialStatement/CashBalance.php#L47)

## Finance\FinancialStatement\Cashflow

[Source](../../src/Finance/FinancialStatement/Cashflow.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `startDate` | string or null | `()` |
| `endDate` | string or null | `()` |
| `cashBalance` | object or null ([Finance\FinancialStatement\CashBalance](finance.md#financefinancialstatementcashbalance)) | `()` |
| `cashflowActivities` | list of objects ([Finance\FinancialStatement\CashflowActivity](finance.md#financefinancialstatementcashflowactivity)) | `()` |

### Public methods

- [`getStartDate(): ?string`](../../src/Finance/FinancialStatement/Cashflow.php#L23)
- [`setStartDate(?string $startDate): Sujip\Xero\Finance\FinancialStatement\Cashflow`](../../src/Finance/FinancialStatement/Cashflow.php#L28)
- [`getEndDate(): ?string`](../../src/Finance/FinancialStatement/Cashflow.php#L35)
- [`setEndDate(?string $endDate): Sujip\Xero\Finance\FinancialStatement\Cashflow`](../../src/Finance/FinancialStatement/Cashflow.php#L40)
- [`getCashBalance(): ?\Sujip\Xero\Finance\FinancialStatement\CashBalance`](../../src/Finance/FinancialStatement/Cashflow.php#L47)
- [`setCashBalance(?\Sujip\Xero\Finance\FinancialStatement\CashBalance $cashBalance): Sujip\Xero\Finance\FinancialStatement\Cashflow`](../../src/Finance/FinancialStatement/Cashflow.php#L52)
- [`getCashflowActivities(): array`](../../src/Finance/FinancialStatement/Cashflow.php#L62)
- [`setCashflowActivities(array $cashflowActivities): Sujip\Xero\Finance\FinancialStatement\Cashflow`](../../src/Finance/FinancialStatement/Cashflow.php#L70)
- [`addCashflowActivity(\Sujip\Xero\Finance\FinancialStatement\CashflowActivity $cashflowActivity): Sujip\Xero\Finance\FinancialStatement\Cashflow`](../../src/Finance/FinancialStatement/Cashflow.php#L77)

## Finance\FinancialStatement\CashflowAccount

[Source](../../src/Finance/FinancialStatement/CashflowAccount.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accountId` | string or null | `()` |
| `accountType` | string or null | `()` |
| `accountClass` | string or null | `()` |
| `code` | string or null | `()` |
| `name` | string or null | `()` |
| `reportingCode` | string or null | `()` |
| `total` | int, float, or null | `()` |

### Public methods

- [`getAccountId(): ?string`](../../src/Finance/FinancialStatement/CashflowAccount.php#L26)
- [`setAccountId(?string $accountId): Sujip\Xero\Finance\FinancialStatement\CashflowAccount`](../../src/Finance/FinancialStatement/CashflowAccount.php#L31)
- [`getAccountType(): ?string`](../../src/Finance/FinancialStatement/CashflowAccount.php#L38)
- [`setAccountType(?string $accountType): Sujip\Xero\Finance\FinancialStatement\CashflowAccount`](../../src/Finance/FinancialStatement/CashflowAccount.php#L43)
- [`getAccountClass(): ?string`](../../src/Finance/FinancialStatement/CashflowAccount.php#L50)
- [`setAccountClass(?string $accountClass): Sujip\Xero\Finance\FinancialStatement\CashflowAccount`](../../src/Finance/FinancialStatement/CashflowAccount.php#L55)
- [`getCode(): ?string`](../../src/Finance/FinancialStatement/CashflowAccount.php#L62)
- [`setCode(?string $code): Sujip\Xero\Finance\FinancialStatement\CashflowAccount`](../../src/Finance/FinancialStatement/CashflowAccount.php#L67)
- [`getName(): ?string`](../../src/Finance/FinancialStatement/CashflowAccount.php#L74)
- [`setName(?string $name): Sujip\Xero\Finance\FinancialStatement\CashflowAccount`](../../src/Finance/FinancialStatement/CashflowAccount.php#L79)
- [`getReportingCode(): ?string`](../../src/Finance/FinancialStatement/CashflowAccount.php#L86)
- [`setReportingCode(?string $reportingCode): Sujip\Xero\Finance\FinancialStatement\CashflowAccount`](../../src/Finance/FinancialStatement/CashflowAccount.php#L91)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/CashflowAccount.php#L98)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\CashflowAccount`](../../src/Finance/FinancialStatement/CashflowAccount.php#L103)

## Finance\FinancialStatement\CashflowActivity

[Source](../../src/Finance/FinancialStatement/CashflowActivity.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `name` | string or null | `()` |
| `total` | int, float, or null | `()` |
| `cashflowTypes` | list of objects ([Finance\FinancialStatement\CashflowType](finance.md#financefinancialstatementcashflowtype)) | `()` |

### Public methods

- [`getName(): ?string`](../../src/Finance/FinancialStatement/CashflowActivity.php#L21)
- [`setName(?string $name): Sujip\Xero\Finance\FinancialStatement\CashflowActivity`](../../src/Finance/FinancialStatement/CashflowActivity.php#L26)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/CashflowActivity.php#L33)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\CashflowActivity`](../../src/Finance/FinancialStatement/CashflowActivity.php#L38)
- [`getCashflowTypes(): array`](../../src/Finance/FinancialStatement/CashflowActivity.php#L48)
- [`setCashflowTypes(array $cashflowTypes): Sujip\Xero\Finance\FinancialStatement\CashflowActivity`](../../src/Finance/FinancialStatement/CashflowActivity.php#L56)
- [`addCashflowType(\Sujip\Xero\Finance\FinancialStatement\CashflowType $cashflowType): Sujip\Xero\Finance\FinancialStatement\CashflowActivity`](../../src/Finance/FinancialStatement/CashflowActivity.php#L63)

## Finance\FinancialStatement\CashflowType

[Source](../../src/Finance/FinancialStatement/CashflowType.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `name` | string or null | `()` |
| `total` | int, float, or null | `()` |
| `accounts` | list of objects ([Finance\FinancialStatement\CashflowAccount](finance.md#financefinancialstatementcashflowaccount)) | `()` |

### Public methods

- [`getName(): ?string`](../../src/Finance/FinancialStatement/CashflowType.php#L21)
- [`setName(?string $name): Sujip\Xero\Finance\FinancialStatement\CashflowType`](../../src/Finance/FinancialStatement/CashflowType.php#L26)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/CashflowType.php#L33)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\CashflowType`](../../src/Finance/FinancialStatement/CashflowType.php#L38)
- [`getAccounts(): array`](../../src/Finance/FinancialStatement/CashflowType.php#L48)
- [`setAccounts(array $accounts): Sujip\Xero\Finance\FinancialStatement\CashflowType`](../../src/Finance/FinancialStatement/CashflowType.php#L56)
- [`addAccount(\Sujip\Xero\Finance\FinancialStatement\CashflowAccount $account): Sujip\Xero\Finance\FinancialStatement\CashflowType`](../../src/Finance/FinancialStatement/CashflowType.php#L63)

## Finance\FinancialStatement\ContactDetail

[Source](../../src/Finance/FinancialStatement/ContactDetail.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `contactId` | string or null | `()` |
| `name` | string or null | `()` |
| `total` | int, float, or null | `()` |
| `totalDetail` | object or null ([Finance\FinancialStatement\ContactTotalDetail](finance.md#financefinancialstatementcontacttotaldetail)) | `()` |
| `totalOther` | object or null ([Finance\FinancialStatement\ContactTotalOther](finance.md#financefinancialstatementcontacttotalother)) | `()` |
| `accountCodes` | array | `()` |

### Public methods

- [`getContactId(): ?string`](../../src/Finance/FinancialStatement/ContactDetail.php#L27)
- [`setContactId(?string $contactId): Sujip\Xero\Finance\FinancialStatement\ContactDetail`](../../src/Finance/FinancialStatement/ContactDetail.php#L32)
- [`getName(): ?string`](../../src/Finance/FinancialStatement/ContactDetail.php#L39)
- [`setName(?string $name): Sujip\Xero\Finance\FinancialStatement\ContactDetail`](../../src/Finance/FinancialStatement/ContactDetail.php#L44)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/ContactDetail.php#L51)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\ContactDetail`](../../src/Finance/FinancialStatement/ContactDetail.php#L56)
- [`getTotalDetail(): ?\Sujip\Xero\Finance\FinancialStatement\ContactTotalDetail`](../../src/Finance/FinancialStatement/ContactDetail.php#L63)
- [`setTotalDetail(?\Sujip\Xero\Finance\FinancialStatement\ContactTotalDetail $totalDetail): Sujip\Xero\Finance\FinancialStatement\ContactDetail`](../../src/Finance/FinancialStatement/ContactDetail.php#L68)
- [`getTotalOther(): ?\Sujip\Xero\Finance\FinancialStatement\ContactTotalOther`](../../src/Finance/FinancialStatement/ContactDetail.php#L75)
- [`setTotalOther(?\Sujip\Xero\Finance\FinancialStatement\ContactTotalOther $totalOther): Sujip\Xero\Finance\FinancialStatement\ContactDetail`](../../src/Finance/FinancialStatement/ContactDetail.php#L80)
- [`getAccountCodes(): array`](../../src/Finance/FinancialStatement/ContactDetail.php#L90)
- [`setAccountCodes(array $accountCodes): Sujip\Xero\Finance\FinancialStatement\ContactDetail`](../../src/Finance/FinancialStatement/ContactDetail.php#L98)

## Finance\FinancialStatement\ContactTotalDetail

[Source](../../src/Finance/FinancialStatement/ContactTotalDetail.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `totalPaid` | int, float, or null | `()` |
| `totalOutstanding` | int, float, or null | `()` |
| `totalCreditedUnApplied` | int, float, or null | `()` |

### Public methods

- [`getTotalPaid(): int\|float\|null`](../../src/Finance/FinancialStatement/ContactTotalDetail.php#L18)
- [`setTotalPaid(int\|float\|null $totalPaid): Sujip\Xero\Finance\FinancialStatement\ContactTotalDetail`](../../src/Finance/FinancialStatement/ContactTotalDetail.php#L23)
- [`getTotalOutstanding(): int\|float\|null`](../../src/Finance/FinancialStatement/ContactTotalDetail.php#L30)
- [`setTotalOutstanding(int\|float\|null $totalOutstanding): Sujip\Xero\Finance\FinancialStatement\ContactTotalDetail`](../../src/Finance/FinancialStatement/ContactTotalDetail.php#L35)
- [`getTotalCreditedUnApplied(): int\|float\|null`](../../src/Finance/FinancialStatement/ContactTotalDetail.php#L42)
- [`setTotalCreditedUnApplied(int\|float\|null $totalCreditedUnApplied): Sujip\Xero\Finance\FinancialStatement\ContactTotalDetail`](../../src/Finance/FinancialStatement/ContactTotalDetail.php#L47)

## Finance\FinancialStatement\ContactTotalOther

[Source](../../src/Finance/FinancialStatement/ContactTotalOther.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `totalOutstandingAged` | int, float, or null | `()` |
| `totalVoided` | int, float, or null | `()` |
| `totalCredited` | int, float, or null | `()` |
| `transactionCount` | int, float, or null | `()` |

### Public methods

- [`getTotalOutstandingAged(): int\|float\|null`](../../src/Finance/FinancialStatement/ContactTotalOther.php#L20)
- [`setTotalOutstandingAged(int\|float\|null $totalOutstandingAged): Sujip\Xero\Finance\FinancialStatement\ContactTotalOther`](../../src/Finance/FinancialStatement/ContactTotalOther.php#L25)
- [`getTotalVoided(): int\|float\|null`](../../src/Finance/FinancialStatement/ContactTotalOther.php#L32)
- [`setTotalVoided(int\|float\|null $totalVoided): Sujip\Xero\Finance\FinancialStatement\ContactTotalOther`](../../src/Finance/FinancialStatement/ContactTotalOther.php#L37)
- [`getTotalCredited(): int\|float\|null`](../../src/Finance/FinancialStatement/ContactTotalOther.php#L44)
- [`setTotalCredited(int\|float\|null $totalCredited): Sujip\Xero\Finance\FinancialStatement\ContactTotalOther`](../../src/Finance/FinancialStatement/ContactTotalOther.php#L49)
- [`getTransactionCount(): int\|float\|null`](../../src/Finance/FinancialStatement/ContactTotalOther.php#L56)
- [`setTransactionCount(int\|float\|null $transactionCount): Sujip\Xero\Finance\FinancialStatement\ContactTotalOther`](../../src/Finance/FinancialStatement/ContactTotalOther.php#L61)

## Finance\FinancialStatement\FinancialStatements

[Source](../../src/Finance/FinancialStatement/FinancialStatements.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Finance/FinancialStatement/FinancialStatements.php#L14)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Finance/FinancialStatement/FinancialStatements.php#L19)
- [`balanceSheet(?\DateTimeInterface $balanceDate = NULL): Sujip\Xero\Finance\FinancialStatement\BalanceSheet`](../../src/Finance/FinancialStatement/FinancialStatements.php#L27)
- [`cashflow(?\DateTimeInterface $startDate = NULL, ?\DateTimeInterface $endDate = NULL): Sujip\Xero\Finance\FinancialStatement\Cashflow`](../../src/Finance/FinancialStatement/FinancialStatements.php#L38)
- [`profitAndLoss(?\DateTimeInterface $startDate = NULL, ?\DateTimeInterface $endDate = NULL): Sujip\Xero\Finance\FinancialStatement\ProfitAndLoss`](../../src/Finance/FinancialStatement/FinancialStatements.php#L49)
- [`trialBalance(?\DateTimeInterface $endDate = NULL): Sujip\Xero\Finance\FinancialStatement\TrialBalance`](../../src/Finance/FinancialStatement/FinancialStatements.php#L60)
- [`contactExpenses(array $contactIds = array (
), ?\DateTimeInterface $startDate = NULL, ?\DateTimeInterface $endDate = NULL, ?bool $includeManualJournals = NULL): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/FinancialStatements.php#L74)
- [`contactRevenue(array $contactIds = array (
), ?\DateTimeInterface $startDate = NULL, ?\DateTimeInterface $endDate = NULL, ?bool $includeManualJournals = NULL): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/FinancialStatements.php#L92)

## Finance\FinancialStatement\IncomeByContact

[Source](../../src/Finance/FinancialStatement/IncomeByContact.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `startDate` | string or null | `()` |
| `endDate` | string or null | `()` |
| `total` | int, float, or null | `()` |
| `totalDetail` | object or null ([Finance\FinancialStatement\TotalDetail](finance.md#financefinancialstatementtotaldetail)) | `()` |
| `totalOther` | object or null ([Finance\FinancialStatement\TotalOther](finance.md#financefinancialstatementtotalother)) | `()` |
| `contacts` | list of objects ([Finance\FinancialStatement\ContactDetail](finance.md#financefinancialstatementcontactdetail)) | `()` |
| `manualJournals` | object or null ([Finance\FinancialStatement\ManualJournalTotal](finance.md#financefinancialstatementmanualjournaltotal)) | `()` |

### Public methods

- [`getStartDate(): ?string`](../../src/Finance/FinancialStatement/IncomeByContact.php#L29)
- [`setStartDate(?string $startDate): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/IncomeByContact.php#L34)
- [`getEndDate(): ?string`](../../src/Finance/FinancialStatement/IncomeByContact.php#L41)
- [`setEndDate(?string $endDate): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/IncomeByContact.php#L46)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/IncomeByContact.php#L53)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/IncomeByContact.php#L58)
- [`getTotalDetail(): ?\Sujip\Xero\Finance\FinancialStatement\TotalDetail`](../../src/Finance/FinancialStatement/IncomeByContact.php#L65)
- [`setTotalDetail(?\Sujip\Xero\Finance\FinancialStatement\TotalDetail $totalDetail): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/IncomeByContact.php#L70)
- [`getTotalOther(): ?\Sujip\Xero\Finance\FinancialStatement\TotalOther`](../../src/Finance/FinancialStatement/IncomeByContact.php#L77)
- [`setTotalOther(?\Sujip\Xero\Finance\FinancialStatement\TotalOther $totalOther): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/IncomeByContact.php#L82)
- [`getContacts(): array`](../../src/Finance/FinancialStatement/IncomeByContact.php#L92)
- [`setContacts(array $contacts): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/IncomeByContact.php#L100)
- [`addContact(\Sujip\Xero\Finance\FinancialStatement\ContactDetail $contact): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/IncomeByContact.php#L107)
- [`getManualJournals(): ?\Sujip\Xero\Finance\FinancialStatement\ManualJournalTotal`](../../src/Finance/FinancialStatement/IncomeByContact.php#L114)
- [`setManualJournals(?\Sujip\Xero\Finance\FinancialStatement\ManualJournalTotal $manualJournals): Sujip\Xero\Finance\FinancialStatement\IncomeByContact`](../../src/Finance/FinancialStatement/IncomeByContact.php#L119)

## Finance\FinancialStatement\ManualJournalTotal

[Source](../../src/Finance/FinancialStatement/ManualJournalTotal.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `total` | int, float, or null | `()` |

### Public methods

- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/ManualJournalTotal.php#L14)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\ManualJournalTotal`](../../src/Finance/FinancialStatement/ManualJournalTotal.php#L19)

## Finance\FinancialStatement\PnlAccount

[Source](../../src/Finance/FinancialStatement/PnlAccount.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accountID` | string or null | `()` |
| `accountType` | string or null | `()` |
| `code` | string or null | `()` |
| `name` | string or null | `()` |
| `reportingCode` | string or null | `()` |
| `total` | int, float, or null | `()` |

### Public methods

- [`getAccountID(): ?string`](../../src/Finance/FinancialStatement/PnlAccount.php#L24)
- [`setAccountID(?string $accountID): Sujip\Xero\Finance\FinancialStatement\PnlAccount`](../../src/Finance/FinancialStatement/PnlAccount.php#L29)
- [`getAccountType(): ?string`](../../src/Finance/FinancialStatement/PnlAccount.php#L36)
- [`setAccountType(?string $accountType): Sujip\Xero\Finance\FinancialStatement\PnlAccount`](../../src/Finance/FinancialStatement/PnlAccount.php#L41)
- [`getCode(): ?string`](../../src/Finance/FinancialStatement/PnlAccount.php#L48)
- [`setCode(?string $code): Sujip\Xero\Finance\FinancialStatement\PnlAccount`](../../src/Finance/FinancialStatement/PnlAccount.php#L53)
- [`getName(): ?string`](../../src/Finance/FinancialStatement/PnlAccount.php#L60)
- [`setName(?string $name): Sujip\Xero\Finance\FinancialStatement\PnlAccount`](../../src/Finance/FinancialStatement/PnlAccount.php#L65)
- [`getReportingCode(): ?string`](../../src/Finance/FinancialStatement/PnlAccount.php#L72)
- [`setReportingCode(?string $reportingCode): Sujip\Xero\Finance\FinancialStatement\PnlAccount`](../../src/Finance/FinancialStatement/PnlAccount.php#L77)
- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/PnlAccount.php#L84)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\PnlAccount`](../../src/Finance/FinancialStatement/PnlAccount.php#L89)

## Finance\FinancialStatement\PnlAccountClass

[Source](../../src/Finance/FinancialStatement/PnlAccountClass.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `total` | int, float, or null | `()` |
| `accountTypes` | list of objects ([Finance\FinancialStatement\PnlAccountType](finance.md#financefinancialstatementpnlaccounttype)) | `()` |

### Public methods

- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/PnlAccountClass.php#L19)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\PnlAccountClass`](../../src/Finance/FinancialStatement/PnlAccountClass.php#L24)
- [`getAccountTypes(): array`](../../src/Finance/FinancialStatement/PnlAccountClass.php#L34)
- [`setAccountTypes(array $accountTypes): Sujip\Xero\Finance\FinancialStatement\PnlAccountClass`](../../src/Finance/FinancialStatement/PnlAccountClass.php#L42)
- [`addAccountType(\Sujip\Xero\Finance\FinancialStatement\PnlAccountType $accountType): Sujip\Xero\Finance\FinancialStatement\PnlAccountClass`](../../src/Finance/FinancialStatement/PnlAccountClass.php#L49)

## Finance\FinancialStatement\PnlAccountType

[Source](../../src/Finance/FinancialStatement/PnlAccountType.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `total` | int, float, or null | `()` |
| `title` | string or null | `()` |
| `accounts` | list of objects ([Finance\FinancialStatement\PnlAccount](finance.md#financefinancialstatementpnlaccount)) | `()` |

### Public methods

- [`getTotal(): int\|float\|null`](../../src/Finance/FinancialStatement/PnlAccountType.php#L21)
- [`setTotal(int\|float\|null $total): Sujip\Xero\Finance\FinancialStatement\PnlAccountType`](../../src/Finance/FinancialStatement/PnlAccountType.php#L26)
- [`getTitle(): ?string`](../../src/Finance/FinancialStatement/PnlAccountType.php#L33)
- [`setTitle(?string $title): Sujip\Xero\Finance\FinancialStatement\PnlAccountType`](../../src/Finance/FinancialStatement/PnlAccountType.php#L38)
- [`getAccounts(): array`](../../src/Finance/FinancialStatement/PnlAccountType.php#L48)
- [`setAccounts(array $accounts): Sujip\Xero\Finance\FinancialStatement\PnlAccountType`](../../src/Finance/FinancialStatement/PnlAccountType.php#L56)
- [`addAccount(\Sujip\Xero\Finance\FinancialStatement\PnlAccount $account): Sujip\Xero\Finance\FinancialStatement\PnlAccountType`](../../src/Finance/FinancialStatement/PnlAccountType.php#L63)

## Finance\FinancialStatement\ProfitAndLoss

[Source](../../src/Finance/FinancialStatement/ProfitAndLoss.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `startDate` | string or null | `()` |
| `endDate` | string or null | `()` |
| `netProfitLoss` | int, float, or null | `()` |
| `revenue` | object or null ([Finance\FinancialStatement\PnlAccountClass](finance.md#financefinancialstatementpnlaccountclass)) | `()` |
| `expense` | object or null ([Finance\FinancialStatement\PnlAccountClass](finance.md#financefinancialstatementpnlaccountclass)) | `()` |

### Public methods

- [`getStartDate(): ?string`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L22)
- [`setStartDate(?string $startDate): Sujip\Xero\Finance\FinancialStatement\ProfitAndLoss`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L27)
- [`getEndDate(): ?string`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L34)
- [`setEndDate(?string $endDate): Sujip\Xero\Finance\FinancialStatement\ProfitAndLoss`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L39)
- [`getNetProfitLoss(): int\|float\|null`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L46)
- [`setNetProfitLoss(int\|float\|null $netProfitLoss): Sujip\Xero\Finance\FinancialStatement\ProfitAndLoss`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L51)
- [`getRevenue(): ?\Sujip\Xero\Finance\FinancialStatement\PnlAccountClass`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L58)
- [`setRevenue(?\Sujip\Xero\Finance\FinancialStatement\PnlAccountClass $revenue): Sujip\Xero\Finance\FinancialStatement\ProfitAndLoss`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L63)
- [`getExpense(): ?\Sujip\Xero\Finance\FinancialStatement\PnlAccountClass`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L70)
- [`setExpense(?\Sujip\Xero\Finance\FinancialStatement\PnlAccountClass $expense): Sujip\Xero\Finance\FinancialStatement\ProfitAndLoss`](../../src/Finance/FinancialStatement/ProfitAndLoss.php#L75)

## Finance\FinancialStatement\TotalDetail

[Source](../../src/Finance/FinancialStatement/TotalDetail.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `totalPaid` | int, float, or null | `()` |
| `totalOutstanding` | int, float, or null | `()` |
| `totalCreditedUnApplied` | int, float, or null | `()` |

### Public methods

- [`getTotalPaid(): int\|float\|null`](../../src/Finance/FinancialStatement/TotalDetail.php#L18)
- [`setTotalPaid(int\|float\|null $totalPaid): Sujip\Xero\Finance\FinancialStatement\TotalDetail`](../../src/Finance/FinancialStatement/TotalDetail.php#L23)
- [`getTotalOutstanding(): int\|float\|null`](../../src/Finance/FinancialStatement/TotalDetail.php#L30)
- [`setTotalOutstanding(int\|float\|null $totalOutstanding): Sujip\Xero\Finance\FinancialStatement\TotalDetail`](../../src/Finance/FinancialStatement/TotalDetail.php#L35)
- [`getTotalCreditedUnApplied(): int\|float\|null`](../../src/Finance/FinancialStatement/TotalDetail.php#L42)
- [`setTotalCreditedUnApplied(int\|float\|null $totalCreditedUnApplied): Sujip\Xero\Finance\FinancialStatement\TotalDetail`](../../src/Finance/FinancialStatement/TotalDetail.php#L47)

## Finance\FinancialStatement\TotalOther

[Source](../../src/Finance/FinancialStatement/TotalOther.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `totalOutstandingAged` | int, float, or null | `()` |
| `totalVoided` | int, float, or null | `()` |
| `totalCredited` | int, float, or null | `()` |

### Public methods

- [`getTotalOutstandingAged(): int\|float\|null`](../../src/Finance/FinancialStatement/TotalOther.php#L18)
- [`setTotalOutstandingAged(int\|float\|null $totalOutstandingAged): Sujip\Xero\Finance\FinancialStatement\TotalOther`](../../src/Finance/FinancialStatement/TotalOther.php#L23)
- [`getTotalVoided(): int\|float\|null`](../../src/Finance/FinancialStatement/TotalOther.php#L30)
- [`setTotalVoided(int\|float\|null $totalVoided): Sujip\Xero\Finance\FinancialStatement\TotalOther`](../../src/Finance/FinancialStatement/TotalOther.php#L35)
- [`getTotalCredited(): int\|float\|null`](../../src/Finance/FinancialStatement/TotalOther.php#L42)
- [`setTotalCredited(int\|float\|null $totalCredited): Sujip\Xero\Finance\FinancialStatement\TotalOther`](../../src/Finance/FinancialStatement/TotalOther.php#L47)

## Finance\FinancialStatement\TrialBalance

[Source](../../src/Finance/FinancialStatement/TrialBalance.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `startDate` | string or null | `()` |
| `endDate` | string or null | `()` |
| `accounts` | list of objects ([Finance\FinancialStatement\TrialBalanceAccount](finance.md#financefinancialstatementtrialbalanceaccount)) | `()` |

### Public methods

- [`getStartDate(): ?string`](../../src/Finance/FinancialStatement/TrialBalance.php#L21)
- [`setStartDate(?string $startDate): Sujip\Xero\Finance\FinancialStatement\TrialBalance`](../../src/Finance/FinancialStatement/TrialBalance.php#L26)
- [`getEndDate(): ?string`](../../src/Finance/FinancialStatement/TrialBalance.php#L33)
- [`setEndDate(?string $endDate): Sujip\Xero\Finance\FinancialStatement\TrialBalance`](../../src/Finance/FinancialStatement/TrialBalance.php#L38)
- [`getAccounts(): array`](../../src/Finance/FinancialStatement/TrialBalance.php#L48)
- [`setAccounts(array $accounts): Sujip\Xero\Finance\FinancialStatement\TrialBalance`](../../src/Finance/FinancialStatement/TrialBalance.php#L56)
- [`addAccount(\Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount $account): Sujip\Xero\Finance\FinancialStatement\TrialBalance`](../../src/Finance/FinancialStatement/TrialBalance.php#L63)

## Finance\FinancialStatement\TrialBalanceAccount

[Source](../../src/Finance/FinancialStatement/TrialBalanceAccount.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `accountId` | string or null | `()` |
| `accountType` | string or null | `()` |
| `accountCode` | string or null | `()` |
| `accountClass` | string or null | `()` |
| `status` | string or null | `()` |
| `reportingCode` | string or null | `()` |
| `accountName` | string or null | `()` |
| `balance` | object or null ([Finance\FinancialStatement\TrialBalanceEntry](finance.md#financefinancialstatementtrialbalanceentry)) | `()` |
| `signedBalance` | int, float, or null | `()` |
| `accountMovement` | object or null ([Finance\FinancialStatement\TrialBalanceMovement](finance.md#financefinancialstatementtrialbalancemovement)) | `()` |

### Public methods

- [`getAccountId(): ?string`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L32)
- [`setAccountId(?string $accountId): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L37)
- [`getAccountType(): ?string`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L44)
- [`setAccountType(?string $accountType): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L49)
- [`getAccountCode(): ?string`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L56)
- [`setAccountCode(?string $accountCode): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L61)
- [`getAccountClass(): ?string`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L68)
- [`setAccountClass(?string $accountClass): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L73)
- [`getStatus(): ?string`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L80)
- [`setStatus(?string $status): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L85)
- [`getReportingCode(): ?string`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L92)
- [`setReportingCode(?string $reportingCode): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L97)
- [`getAccountName(): ?string`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L104)
- [`setAccountName(?string $accountName): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L109)
- [`getBalance(): ?\Sujip\Xero\Finance\FinancialStatement\TrialBalanceEntry`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L116)
- [`setBalance(?\Sujip\Xero\Finance\FinancialStatement\TrialBalanceEntry $balance): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L121)
- [`getSignedBalance(): int\|float\|null`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L128)
- [`setSignedBalance(int\|float\|null $signedBalance): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L133)
- [`getAccountMovement(): ?\Sujip\Xero\Finance\FinancialStatement\TrialBalanceMovement`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L140)
- [`setAccountMovement(?\Sujip\Xero\Finance\FinancialStatement\TrialBalanceMovement $accountMovement): Sujip\Xero\Finance\FinancialStatement\TrialBalanceAccount`](../../src/Finance/FinancialStatement/TrialBalanceAccount.php#L145)

## Finance\FinancialStatement\TrialBalanceEntry

[Source](../../src/Finance/FinancialStatement/TrialBalanceEntry.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `value` | int, float, or null | `()` |
| `entryType` | string or null | `()` |

### Public methods

- [`getValue(): int\|float\|null`](../../src/Finance/FinancialStatement/TrialBalanceEntry.php#L16)
- [`setValue(int\|float\|null $value): Sujip\Xero\Finance\FinancialStatement\TrialBalanceEntry`](../../src/Finance/FinancialStatement/TrialBalanceEntry.php#L21)
- [`getEntryType(): ?string`](../../src/Finance/FinancialStatement/TrialBalanceEntry.php#L28)
- [`setEntryType(?string $entryType): Sujip\Xero\Finance\FinancialStatement\TrialBalanceEntry`](../../src/Finance/FinancialStatement/TrialBalanceEntry.php#L33)

## Finance\FinancialStatement\TrialBalanceMovement

[Source](../../src/Finance/FinancialStatement/TrialBalanceMovement.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `debits` | int, float, or null | `()` |
| `credits` | int, float, or null | `()` |
| `movement` | object or null ([Finance\FinancialStatement\TrialBalanceEntry](finance.md#financefinancialstatementtrialbalanceentry)) | `()` |
| `signedMovement` | int, float, or null | `()` |

### Public methods

- [`getDebits(): int\|float\|null`](../../src/Finance/FinancialStatement/TrialBalanceMovement.php#L20)
- [`setDebits(int\|float\|null $debits): Sujip\Xero\Finance\FinancialStatement\TrialBalanceMovement`](../../src/Finance/FinancialStatement/TrialBalanceMovement.php#L25)
- [`getCredits(): int\|float\|null`](../../src/Finance/FinancialStatement/TrialBalanceMovement.php#L32)
- [`setCredits(int\|float\|null $credits): Sujip\Xero\Finance\FinancialStatement\TrialBalanceMovement`](../../src/Finance/FinancialStatement/TrialBalanceMovement.php#L37)
- [`getMovement(): ?\Sujip\Xero\Finance\FinancialStatement\TrialBalanceEntry`](../../src/Finance/FinancialStatement/TrialBalanceMovement.php#L44)
- [`setMovement(?\Sujip\Xero\Finance\FinancialStatement\TrialBalanceEntry $movement): Sujip\Xero\Finance\FinancialStatement\TrialBalanceMovement`](../../src/Finance/FinancialStatement/TrialBalanceMovement.php#L49)
- [`getSignedMovement(): int\|float\|null`](../../src/Finance/FinancialStatement/TrialBalanceMovement.php#L56)
- [`setSignedMovement(int\|float\|null $signedMovement): Sujip\Xero\Finance\FinancialStatement\TrialBalanceMovement`](../../src/Finance/FinancialStatement/TrialBalanceMovement.php#L61)
