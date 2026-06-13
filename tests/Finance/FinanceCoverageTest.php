<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Finance\AccountingActivity\AccountingActivity;
use Sujip\Xero\Finance\AccountingActivity\AccountUsage;
use Sujip\Xero\Finance\AccountingActivity\LockHistory;
use Sujip\Xero\Finance\AccountingActivity\ReportHistory;
use Sujip\Xero\Finance\AccountingActivity\UserActivity;
use Sujip\Xero\Finance\BankStatementEntry;
use Sujip\Xero\Finance\CashValidation\CashValidationResult;
use Sujip\Xero\Finance\FinancialStatement\ContactStatement;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class FinanceCoverageTest extends TestCase
{
    public function test_it_exposes_scopes_across_finance_endpoints(): void
    {
        $finance = Xero::withAccessToken('token', new FakeTransport())->tenant('tenant-1')->finance();

        self::assertSame([
            'finance.accountingactivity.read',
            'finance.cashvalidation.read',
            'finance.statements.read',
        ], $finance->scopes()->granular);
        self::assertSame(['finance.accountingactivity.read'], $finance->accountingActivities()->scopes()->granular);
        self::assertSame(['finance.cashvalidation.read'], $finance->cashValidation()->scopes()->granular);
        self::assertSame(['finance.bankstatementsplus.read'], $finance->bankStatementAccounting()->scopes()->granular);
        self::assertSame(['finance.statements.read'], $finance->statements()->scopes()->granular);
    }

    public function test_accounting_activity_models_expose_getters(): void
    {
        $usage = (new AccountUsage())
            ->setAccountID('acc-1')
            ->setAccountCode('200')
            ->setAccountName('Sales')
            ->setAmount(99.5);

        self::assertSame('acc-1', $usage->getAccountID());
        self::assertSame('200', $usage->getAccountCode());
        self::assertSame('Sales', $usage->getAccountName());
        self::assertSame(99.5, $usage->getAmount());

        $activity = (new AccountingActivity())
            ->setMonth('2026-03')
            ->setTotalIncome(1000.0)
            ->setTotalExpense(400.0);

        self::assertSame('2026-03', $activity->getMonth());
        self::assertSame(1000.0, $activity->getTotalIncome());
        self::assertSame(400.0, $activity->getTotalExpense());

        $lock = (new LockHistory())
            ->setLockDate('2026-03-01')
            ->setLockType('HARD')
            ->setChangedDateUTC('2026-03-02T00:00:00');

        self::assertSame('2026-03-01', $lock->getLockDate());
        self::assertSame('HARD', $lock->getLockType());
        self::assertSame('2026-03-02T00:00:00', $lock->getChangedDateUTC());

        $report = (new ReportHistory())
            ->setReportName('BalanceSheet')
            ->setPublishedDateUTC('2026-03-02T00:00:00')
            ->setPublishedBy('Jane');

        self::assertSame('BalanceSheet', $report->getReportName());
        self::assertSame('2026-03-02T00:00:00', $report->getPublishedDateUTC());
        self::assertSame('Jane', $report->getPublishedBy());

        $user = (new UserActivity())
            ->setUserId('user-1')
            ->setFullName('Jane Doe')
            ->setTransactionCount(12);

        self::assertSame('user-1', $user->getUserId());
        self::assertSame('Jane Doe', $user->getFullName());
        self::assertSame(12, $user->getTransactionCount());
    }

    public function test_bank_statement_cash_and_contact_models_expose_getters(): void
    {
        $entry = (new BankStatementEntry())
            ->setAccountID('acc-1')
            ->setAccountName('Business')
            ->setStatementBalance(2500.0);

        self::assertSame('acc-1', $entry->getAccountID());
        self::assertSame('Business', $entry->getAccountName());
        self::assertSame(2500.0, $entry->getStatementBalance());

        $cash = (new CashValidationResult())
            ->setAccountId('account-1')
            ->setStatementBalanceDate('2026-03-01');

        self::assertSame('account-1', $cash->getAccountId());
        self::assertSame('2026-03-01', $cash->getStatementBalanceDate());

        $contact = (new ContactStatement())
            ->setContactID('contact-1')
            ->setName('Acme')
            ->setTotal(750.0);

        self::assertSame('contact-1', $contact->getContactID());
        self::assertSame('Acme', $contact->getName());
        self::assertSame(750.0, $contact->getTotal());
    }

    public function test_balance_sheet_falls_back_to_an_empty_model_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '[]'));

        $balanceSheet = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-1')
            ->finance()
            ->statements()
            ->balanceSheet();

        self::assertNull($balanceSheet->getBalanceDate());
        self::assertNull($balanceSheet->getAsset());
    }
}
