<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class AccountsTest extends TestCase
{
    public function test_it_can_query_accounts(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Accounts' => [[
                    'AccountID' => 'account-1',
                    'Code' => '200',
                    'Name' => 'Sales',
                    'Type' => 'REVENUE',
                    'Status' => 'ACTIVE',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $accounts = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->accounts()
            ->where('Status == :status', status: 'ACTIVE')
            ->orderBy('Code')
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Accounts', $request->path);
        self::assertSame('Status == "ACTIVE"', $request->query['where']);
        self::assertSame('Code ASC', $request->query['order']);
        self::assertInstanceOf(Account::class, $accounts->first());
    }

    public function test_it_can_create_an_account(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Accounts' => [[
                    'AccountID' => 'account-1',
                    'Code' => '200',
                    'Name' => 'Sales',
                    'Type' => 'REVENUE',
                    'Status' => 'ACTIVE',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $account = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->accounts()
            ->create()
            ->code('200')
            ->name('Sales')
            ->type('REVENUE')
            ->description('Primary sales account')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Accounts', $request->path);
        self::assertSame('200', $request->json['Accounts'][0]['Code']);
        self::assertSame('Sales', $account->name);
    }

    public function test_it_can_update_an_account(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Accounts' => [[
                    'AccountID' => 'account-1',
                    'Code' => '200',
                    'Name' => 'Primary Sales',
                    'Type' => 'REVENUE',
                    'Status' => 'ACTIVE',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $account = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->accounts()
            ->update('account-1')
            ->name('Primary Sales')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Accounts/account-1', $request->path);
        self::assertSame('Primary Sales', $account->name);
    }
}
