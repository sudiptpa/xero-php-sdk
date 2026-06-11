<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\BankTransaction\BankAccount;
use Sujip\Xero\Accounting\BankTransaction\BankTransaction;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class BankTransactionsTest extends TestCase
{
    public function test_it_can_query_and_find_bank_transactions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BankTransactions' => [[
                'BankTransactionID' => 'bank-1',
                'Type' => 'SPEND',
                'Status' => 'AUTHORISED',
                'Reference' => 'BT-1001',
                'Contact' => [
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                ],
                'BankAccount' => [
                    'AccountID' => 'account-1',
                ],
                'LineItems' => [[
                    'Description' => 'Office supplies',
                    'Quantity' => 1,
                    'UnitAmount' => 25,
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BankTransactions' => [[
                'BankTransactionID' => 'bank-1',
                'Type' => 'SPEND',
                'Status' => 'AUTHORISED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $transactions = $client->accounting()->bankTransactions()->where('Status == :status', status: 'AUTHORISED')->get();
        $transaction = $client->accounting()->bankTransactions()->find('bank-1');

        $firstTx = $transactions->first();
        self::assertNotNull($firstTx);
        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[0]->path);
        self::assertSame('Status == "AUTHORISED"', $transport->requests()[0]->query['where']);
        self::assertSame('/api.xro/2.0/BankTransactions/bank-1', $transport->requests()[1]->path);
        self::assertSame('bank-1', $transaction?->getBankTransactionID());
        self::assertSame('contact-1', $firstTx->getContact()?->getContactID());
        self::assertSame('account-1', $firstTx->getBankAccount()?->getAccountID());
        self::assertSame('Office supplies', $firstTx->getLineItems()[0]->getDescription());
    }

    public function test_it_can_create_and_update_bank_transactions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BankTransactions' => [[
                'BankTransactionID' => 'bank-1',
                'Type' => 'SPEND',
                'Reference' => 'BT-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BankTransactions' => [[
                'BankTransactionID' => 'bank-1',
                'Type' => 'SPEND',
                'Reference' => 'BT-1002',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->bankTransactions()->create()
            ->using(
                (new BankTransaction())
                    ->setType('SPEND')
                    ->setContact(
                        (new Contact())
                            ->setContactID('contact-1')
                    )
                    ->setBankAccount(
                        (new BankAccount())
                            ->setAccountID('account-1')
                    )
                    ->setReference('BT-1001')
                    ->addLineItem(
                        (new LineItem())
                            ->setDescription('Office supplies')
                            ->setQuantity(1)
                            ->setUnitAmount(25)
                    )
            )
            ->save();

        $updated = $created->reference('BT-1002')->save();

        $json0 = $transport->requests()[0]->json ?? [];
        $bt0 = Json::extractFirst($json0, 'BankTransactions');
        self::assertNotNull($bt0);
        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[0]->path);
        self::assertSame('SPEND', $bt0['Type']);
        self::assertSame('contact-1', Json::extractObject($bt0, 'Contact')['ContactID']);
        self::assertSame('account-1', Json::extractObject($bt0, 'BankAccount')['AccountID']);
        $json1 = $transport->requests()[1]->json ?? [];
        $bt1 = Json::extractFirst($json1, 'BankTransactions');
        self::assertNotNull($bt1);
        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[1]->path);
        self::assertSame('bank-1', $bt1['BankTransactionID']);
        self::assertSame('BT-1002', $updated->getReference());
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->bankTransactions();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.transactions.read', 'accounting.transactions'], $scopes->granular);
    }

    public function test_it_can_paginate_bank_transactions(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['BankTransactions' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->bankTransactions()
            ->paginate(page: 3, perPage: 50);

        self::assertSame(3, $transport->requests()[0]->query['page']);
        self::assertSame(50, $transport->requests()[0]->query['pageSize']);
        self::assertSame(3, $page->page);
        self::assertSame(50, $page->perPage);
    }

    public function test_payload_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'BankTransactions' => [['BankTransactionID' => 'bank-1', 'Type' => 'SPEND']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->bankTransactions()
            ->update('bank-1')
            ->type('spend')
            ->contact('contact-1')
            ->bankAccount('account-1')
            ->reference('BT-2001')
            ->lineItem('Office supplies', 2, 15)
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $bt = Json::extractFirst($json, 'BankTransactions');
        self::assertNotNull($bt);
        self::assertSame('bank-1', $bt['BankTransactionID']);
        self::assertSame('SPEND', $bt['Type']);
        self::assertSame('contact-1', Json::extractObject($bt, 'Contact')['ContactID']);
        self::assertSame('account-1', Json::extractObject($bt, 'BankAccount')['AccountID']);
        self::assertSame('BT-2001', $bt['Reference']);
        $lineItems = Json::extractList($bt, 'LineItems');
        self::assertSame('Office supplies', $lineItems[0]['Description'] ?? null);
    }

    public function test_model_fluent_helpers_set_fields(): void
    {
        $transaction = (new BankTransaction())
            ->type('spend')
            ->reference('BT-3001')
            ->contact('contact-9')
            ->bankAccount('account-9')
            ->lineItem('Consulting', 1, 100)
            ->setTotal(100)
            ->setLineItems([
                (new LineItem())->setDescription('Replaced'),
            ]);

        self::assertSame('SPEND', $transaction->getType());
        self::assertSame('BT-3001', $transaction->getReference());
        self::assertSame('contact-9', $transaction->getContact()?->getContactID());
        self::assertSame('account-9', $transaction->getBankAccount()?->getAccountID());
        self::assertSame(100, $transaction->getTotal());
        self::assertSame('Replaced', $transaction->getLineItems()[0]->getDescription());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new BankTransaction())->save();
    }

    public function test_history_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new BankTransaction())->history();
    }
}
