<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class BankStatementAccountingTest extends TestCase
{
    public function test_it_can_get_bank_statement_accounting(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'bankAccountId' => '1234eee9-47f0-4179-bd46-9adb4f21cc7f',
            'bankAccountName' => 'ANZ BANK',
            'bankAccountCurrencyCode' => 'NZD',
            'statements' => [[
                'statementId' => '7c29eee9-47f0-4179-bd46-9adb4f21cc7f',
                'startDate' => '2021-01-01',
                'endDate' => '2021-01-02',
                'importedDateTimeUtc' => '2021-01-02T12:00:00Z',
                'importSource' => 'STMTIMPORTSRC/MANUAL',
                'startBalance' => 10.0,
                'endBalance' => 200.0,
                'indicativeStartBalance' => 10.0,
                'indicativeEndBalance' => 200.0,
                'statementLines' => [[
                    'statementLineId' => '1234eee9-47f0-4179-bd46-9adb4f21cc7f',
                    'postedDate' => '2021-01-01',
                    'payee' => 'ACME Thneeds ABC1234567890 SYDNEY',
                    'reference' => 'Eft',
                    'notes' => 'payment to bank',
                    'chequeNo' => '123',
                    'amount' => 100.0,
                    'transactionDate' => '2021-01-01',
                    'type' => 'Debit',
                    'isReconciled' => true,
                    'isDuplicate' => false,
                    'isDeleted' => false,
                    'payments' => [
                        [
                            'paymentId' => '47ec8431-23c2-4ef9-90e5-b440fe55d086',
                            'batchPaymentId' => 'ecc83387-ffaa-4023-b111-b3fd9e3e4a8e',
                            'date' => '2021-01-01',
                            'amount' => 80.0,
                            'bankAmount' => 80.0,
                            'currencyRate' => 1.0,
                            'invoice' => [
                                'invoiceId' => 'c01dd6ac-8835-4bf2-af8b-841db9534d7f',
                                'contact' => [
                                    'contactId' => '1234eee9-47f0-4179-bd46-9adb4f21cc7f',
                                    'contactName' => 'Bob',
                                ],
                                'total' => 80.0,
                                'lineItems' => [[
                                    'accountId' => 'f7fe1049-d1cf-4d10-9df1-67a6e363015f',
                                    'reportingCode' => 'REV.OTH',
                                    'lineAmount' => 80.0,
                                    'accountType' => 'REVENUE',
                                ]],
                            ],
                        ],
                        [
                            'paymentId' => '54e8eee0-91a7-4a4d-bb9b-957302a2760a',
                            'batchPaymentId' => 'ecc83387-ffaa-4023-b111-b3fd9e3e4a8e',
                            'date' => '2021-01-01',
                            'amount' => 15.0,
                            'bankAmount' => 15.0,
                            'currencyRate' => 1.0,
                            'creditNote' => [
                                'creditNoteId' => 'c346d6a5-f013-4207-bc70-f2dd80a5f37f',
                                'contact' => [
                                    'contactId' => '1234eee9-47f0-4179-bd46-9adb4f21cc7f',
                                    'contactName' => 'Bob',
                                ],
                                'total' => 15.0,
                                'lineItems' => [[
                                    'accountId' => 'f7fe1049-d1cf-4d10-9df1-67a6e363015f',
                                    'reportingCode' => 'REV.OTH',
                                    'lineAmount' => 15.0,
                                    'accountType' => 'REVENUE',
                                ]],
                            ],
                        ],
                        [
                            'paymentId' => 'f94dad64-658c-491f-b901-05d38e9e8702',
                            'date' => '2021-01-01',
                            'amount' => 5.0,
                            'bankAmount' => 5.0,
                            'currencyRate' => 1.0,
                            'prepayment' => [
                                'prepaymentId' => '995f81ae-0afd-4c84-bbe1-90bc7dfa4372',
                                'contact' => [
                                    'contactId' => '1234eee9-47f0-4179-bd46-9adb4f21cc7f',
                                    'contactName' => 'Bob',
                                ],
                                'total' => 5.0,
                                'lineItems' => [[
                                    'accountId' => 'f7fe1049-d1cf-4d10-9df1-67a6e363015f',
                                    'reportingCode' => 'REV.OTH',
                                    'lineAmount' => 5.0,
                                    'accountType' => 'REVENUE',
                                ]],
                            ],
                        ],
                        [
                            'paymentId' => '6ffbe999-04c8-42d2-bf16-13947c5f1036',
                            'date' => '2021-01-01',
                            'amount' => 5.0,
                            'bankAmount' => 5.0,
                            'currencyRate' => 1.0,
                            'overpayment' => [
                                'overpaymentId' => '06575718-5100-4e02-8fbf-c2731a112836',
                                'contact' => [
                                    'contactId' => '1234eee9-47f0-4179-bd46-9adb4f21cc7f',
                                    'contactName' => 'Bob',
                                ],
                                'total' => 5.0,
                                'lineItems' => [[
                                    'accountId' => 'f7fe1049-d1cf-4d10-9df1-67a6e363015f',
                                    'reportingCode' => 'REV.OTH',
                                    'lineAmount' => 5.0,
                                    'accountType' => 'REVENUE',
                                ]],
                            ],
                        ],
                    ],
                    'bankTransactions' => [[
                        'bankTransactionId' => '55edf88c-6bf6-459a-bd9b-7f250df62eb2',
                        'batchPaymentId' => '2dce9b39-0427-41af-9739-9510e3b68211',
                        'contact' => [
                            'contactId' => '1234eee9-47f0-4179-bd46-9adb4f21cc7f',
                            'contactName' => 'Bob',
                        ],
                        'date' => '2021-01-01',
                        'amount' => 20.0,
                        'lineItems' => [[
                            'accountId' => 'f7fe1049-d1cf-4d10-9df1-67a6e363015f',
                            'reportingCode' => 'REV.OTH',
                            'lineAmount' => 20.0,
                            'accountType' => 'REVENUE',
                        ]],
                    ]],
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $result = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->finance()
            ->bankStatementAccounting()
            ->get('1234eee9-47f0-4179-bd46-9adb4f21cc7f', new DateTimeImmutable('2021-01-01'), new DateTimeImmutable('2021-01-02'), summaryOnly: true);

        self::assertSame('/finance.xro/1.0/BankStatementsPlus/statements', $transport->requests()[0]->path);
        self::assertSame('1234eee9-47f0-4179-bd46-9adb4f21cc7f', $transport->requests()[0]->query['BankAccountID']);
        self::assertSame('2021-01-01', $transport->requests()[0]->query['FromDate']);
        self::assertSame('2021-01-02', $transport->requests()[0]->query['ToDate']);
        self::assertTrue($transport->requests()[0]->query['SummaryOnly']);

        self::assertSame('1234eee9-47f0-4179-bd46-9adb4f21cc7f', $result->getBankAccountId());
        self::assertSame('ANZ BANK', $result->getBankAccountName());
        self::assertSame('NZD', $result->getBankAccountCurrencyCode());

        $statement = $result->getStatements()[0];
        self::assertSame('7c29eee9-47f0-4179-bd46-9adb4f21cc7f', $statement->getStatementId());
        self::assertSame('2021-01-01', $statement->getStartDate());
        self::assertSame('2021-01-02', $statement->getEndDate());
        self::assertSame('2021-01-02T12:00:00Z', $statement->getImportedDateTimeUtc());
        self::assertSame('STMTIMPORTSRC/MANUAL', $statement->getImportSource());
        self::assertEquals(10.0, $statement->getStartBalance());
        self::assertEquals(200.0, $statement->getEndBalance());
        self::assertEquals(10.0, $statement->getIndicativeStartBalance());
        self::assertEquals(200.0, $statement->getIndicativeEndBalance());

        $line = $statement->getStatementLines()[0];
        self::assertSame('1234eee9-47f0-4179-bd46-9adb4f21cc7f', $line->getStatementLineId());
        self::assertSame('2021-01-01', $line->getPostedDate());
        self::assertSame('ACME Thneeds ABC1234567890 SYDNEY', $line->getPayee());
        self::assertSame('Eft', $line->getReference());
        self::assertSame('payment to bank', $line->getNotes());
        self::assertSame('123', $line->getChequeNo());
        self::assertEquals(100.0, $line->getAmount());
        self::assertSame('2021-01-01', $line->getTransactionDate());
        self::assertSame('Debit', $line->getType());
        self::assertTrue($line->getIsReconciled());
        self::assertFalse($line->getIsDuplicate());
        self::assertFalse($line->getIsDeleted());

        $payments = $line->getPayments();
        self::assertCount(4, $payments);

        $invoicePayment = $payments[0];
        self::assertSame('47ec8431-23c2-4ef9-90e5-b440fe55d086', $invoicePayment->getPaymentId());
        self::assertSame('ecc83387-ffaa-4023-b111-b3fd9e3e4a8e', $invoicePayment->getBatchPaymentId());
        self::assertSame('2021-01-01', $invoicePayment->getDate());
        self::assertEquals(80.0, $invoicePayment->getAmount());
        self::assertEquals(80.0, $invoicePayment->getBankAmount());
        self::assertEquals(1.0, $invoicePayment->getCurrencyRate());

        $invoice = $invoicePayment->getInvoice();
        self::assertNotNull($invoice);
        self::assertSame('c01dd6ac-8835-4bf2-af8b-841db9534d7f', $invoice->getInvoiceId());
        self::assertEquals(80.0, $invoice->getTotal());
        $invoiceContact = $invoice->getContact();
        self::assertNotNull($invoiceContact);
        self::assertSame('1234eee9-47f0-4179-bd46-9adb4f21cc7f', $invoiceContact->getContactId());
        self::assertSame('Bob', $invoiceContact->getContactName());
        self::assertSame('f7fe1049-d1cf-4d10-9df1-67a6e363015f', $invoice->getLineItems()[0]->getAccountId());
        self::assertSame('REV.OTH', $invoice->getLineItems()[0]->getReportingCode());
        self::assertEquals(80.0, $invoice->getLineItems()[0]->getLineAmount());
        self::assertSame('REVENUE', $invoice->getLineItems()[0]->getAccountType());

        $creditNotePayment = $payments[1];
        $creditNote = $creditNotePayment->getCreditNote();
        self::assertNotNull($creditNote);
        self::assertSame('c346d6a5-f013-4207-bc70-f2dd80a5f37f', $creditNote->getCreditNoteId());
        self::assertEquals(15.0, $creditNote->getTotal());
        self::assertSame('Bob', $creditNote->getContact()?->getContactName());

        $prepaymentPayment = $payments[2];
        $prepayment = $prepaymentPayment->getPrepayment();
        self::assertNotNull($prepayment);
        self::assertSame('995f81ae-0afd-4c84-bbe1-90bc7dfa4372', $prepayment->getPrepaymentId());
        self::assertEquals(5.0, $prepayment->getTotal());

        $overpaymentPayment = $payments[3];
        $overpayment = $overpaymentPayment->getOverpayment();
        self::assertNotNull($overpayment);
        self::assertSame('06575718-5100-4e02-8fbf-c2731a112836', $overpayment->getOverpaymentId());
        self::assertEquals(5.0, $overpayment->getTotal());

        $bankTransactions = $line->getBankTransactions();
        self::assertCount(1, $bankTransactions);
        self::assertSame('55edf88c-6bf6-459a-bd9b-7f250df62eb2', $bankTransactions[0]->getBankTransactionId());
        self::assertSame('2dce9b39-0427-41af-9739-9510e3b68211', $bankTransactions[0]->getBatchPaymentId());
        self::assertSame('Bob', $bankTransactions[0]->getContact()?->getContactName());
        self::assertSame('2021-01-01', $bankTransactions[0]->getDate());
        self::assertEquals(20.0, $bankTransactions[0]->getAmount());
        self::assertSame('REVENUE', $bankTransactions[0]->getLineItems()[0]->getAccountType());
    }
}
