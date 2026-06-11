<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
        $firstAccount = $accounts->first();
        self::assertNotNull($firstAccount);
        self::assertSame('Sales', $firstAccount->getName());
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
            ->using(
                (new Account())
                    ->setCode('200')
                    ->setName('Sales')
                    ->setType('REVENUE')
                    ->setDescription('Primary sales account')
            )
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Accounts', $request->path);
        $json = $request->json ?? [];
        $firstAccount = Json::extractFirst($json, 'Accounts');
        self::assertNotNull($firstAccount);
        self::assertSame('200', $firstAccount['Code']);
        self::assertSame('Sales', $account->getName());
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
            ->using(
                (new Account())
                    ->setAccountID('account-1')
                    ->setName('Primary Sales')
            )
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Accounts/account-1', $request->path);
        self::assertSame('Primary Sales', $account->getName());
    }

    public function test_it_paginates_finds_and_builds_accounts(): void
    {
        $body = json_encode([
            'Accounts' => [[
                'AccountID' => 'account-1',
                'Code' => '200',
                'Name' => 'Sales',
                'Type' => 'REVENUE',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR);

        $transport = new FakeTransport();
        $transport->push(new Response(200, body: $body));
        $transport->push(new Response(200, body: $body));
        $transport->push(new Response(200, body: $body));

        $accounts = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()->accounts();

        $page = $accounts->paginate(1, 50);
        $found = $accounts->find('account-1');
        $created = $accounts->create()
            ->code('300')
            ->name('Other Sales')
            ->type('REVENUE')
            ->description('Secondary sales account')
            ->save();

        self::assertSame('/api.xro/2.0/Accounts', $transport->requests()[0]->path);
        self::assertNotNull($page->items->first());
        self::assertSame(1, $page->page);
        self::assertSame(50, $page->perPage);
        self::assertSame('/api.xro/2.0/Accounts/account-1', $transport->requests()[1]->path);
        self::assertSame('account-1', $found?->getAccountID());
        $json = $transport->requests()[2]->json ?? [];
        $sent = Json::extractFirst($json, 'Accounts');
        self::assertNotNull($sent);
        self::assertSame('300', $sent['Code']);
        self::assertSame('Sales', $created->getName());
        self::assertNotSame([], $accounts->scopes()->broad);
    }

    public function test_it_can_save_an_account_model_and_guards_the_client(): void
    {
        $body = json_encode([
            'Accounts' => [[
                'AccountID' => 'account-1',
                'Code' => '201',
                'Name' => 'Sales Two',
                'Type' => 'REVENUE',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR);

        $transport = new FakeTransport();
        $transport->push(new Response(200, body: $body));
        $transport->push(new Response(200, body: $body));

        $accounts = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()->accounts();
        $account = $accounts->get()->first();
        self::assertNotNull($account);

        $saved = $account->code('201')->name('Sales Two')->type('REVENUE')->save();

        self::assertSame('/api.xro/2.0/Accounts/account-1', $transport->requests()[1]->path);
        self::assertSame('Sales Two', $saved->getName());
    }

    public function test_saving_an_account_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('without a bound client context');

        (new Account())->code('999')->save();
    }
}
