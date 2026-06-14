<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Finance\CashValidation\CashValidationResult;
use Sujip\Xero\Finance\FinancialStatement\ContactDetail;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class FinanceCoverageTest extends TestCase
{
    public function test_it_exposes_scopes_across_finance_endpoints(): void
    {
        $finance = Xero::withAccessToken('token', new FakeTransport())->tenant('tenant-1')->finance();

        self::assertSame([
            'finance.bankstatementsplus.read',
            'finance.cashvalidation.read',
            'finance.statements.read',
        ], $finance->scopes()->granular);
        self::assertSame(['finance.cashvalidation.read'], $finance->cashValidation()->scopes()->granular);
        self::assertSame(['finance.bankstatementsplus.read'], $finance->bankStatementAccounting()->scopes()->granular);
        self::assertSame(['finance.statements.read'], $finance->statements()->scopes()->granular);
    }

    public function test_cash_validation_and_contact_models_expose_getters(): void
    {
        $cash = (new CashValidationResult())
            ->setAccountId('account-1')
            ->setStatementBalanceDate('2026-03-01');

        self::assertSame('account-1', $cash->getAccountId());
        self::assertSame('2026-03-01', $cash->getStatementBalanceDate());

        $contact = (new ContactDetail())
            ->setContactId('contact-1')
            ->setName('Acme')
            ->setTotal(750.0);

        self::assertSame('contact-1', $contact->getContactId());
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
