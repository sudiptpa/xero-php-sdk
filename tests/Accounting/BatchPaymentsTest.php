<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Accounting\BatchPayment\BatchPayment;
use Sujip\Xero\Accounting\BatchPayment\PaymentEntry;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class BatchPaymentsTest extends TestCase
{
    public function test_it_can_query_and_find_batch_payments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BatchPayments' => [[
                'BatchPaymentID' => 'batch-1',
                'Reference' => 'BATCH-1001',
                'Status' => 'AUTHORISED',
                'Amount' => 75,
                'Account' => [
                    'AccountID' => 'account-1',
                ],
                'Payments' => [[
                    'Invoice' => [
                        'InvoiceID' => 'invoice-1',
                    ],
                    'Amount' => 75,
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BatchPayments' => [[
                'BatchPaymentID' => 'batch-1',
                'Reference' => 'BATCH-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $batchPayments = $client->accounting()->batchPayments()->where('Status == :status', status: 'AUTHORISED')->get();
        $batchPayment = $client->accounting()->batchPayments()->find('batch-1');

        self::assertSame('/api.xro/2.0/BatchPayments', $transport->requests()[0]->path);
        $firstBp = $batchPayments->first();
        self::assertNotNull($firstBp);
        self::assertSame('/api.xro/2.0/BatchPayments/batch-1', $transport->requests()[1]->path);
        self::assertSame('batch-1', $batchPayment?->getBatchPaymentID());
        self::assertSame('account-1', $firstBp->getAccount()?->getAccountID());
        self::assertSame('invoice-1', $firstBp->getPayments()[0]->getInvoiceID());
    }

    public function test_it_can_create_batch_payments(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'BatchPayments' => [[
                    'BatchPaymentID' => 'batch-1',
                    'Reference' => 'BATCH-1001',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $batchPayment = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->batchPayments()
            ->create()
            ->using(
                (new BatchPayment())
                    ->setAccount(
                        (new Account())
                            ->setAccountID('account-1')
                    )
                    ->setReference('BATCH-1001')
                    ->addPayment(
                        (new PaymentEntry())
                            ->setInvoiceID('invoice-1')
                            ->setAmount(75)
                    )
            )
            ->save();

        self::assertSame('/api.xro/2.0/BatchPayments', $transport->requests()[0]->path);
        $json0 = $transport->requests()[0]->json ?? [];
        $bp0 = Json::extractFirst($json0, 'BatchPayments');
        self::assertNotNull($bp0);
        self::assertSame('account-1', Json::extractObject($bp0, 'Account')['AccountID']);
        $payments0 = Json::extractList($bp0, 'Payments');
        $invoice0 = Json::extractObject($payments0[0] ?? [], 'Invoice');
        self::assertSame('invoice-1', $invoice0['InvoiceID']);
        self::assertSame('batch-1', $batchPayment->getBatchPaymentID());
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->batchPayments();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.transactions.read', 'accounting.transactions'], $scopes->granular);
    }

    public function test_it_can_paginate_batch_payments(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['BatchPayments' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->batchPayments()
            ->paginate(page: 2, perPage: 35);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(35, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(35, $page->perPage);
    }

    public function test_it_maps_payment_entries_directly(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->batchPayments();

        $entry = $resource->mapPaymentEntry([
            'Invoice' => ['InvoiceID' => 'invoice-9'],
            'Amount' => 50,
        ]);

        self::assertSame('invoice-9', $entry->getInvoiceID());
    }

    public function test_payload_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'BatchPayments' => [['BatchPaymentID' => 'batch-1']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->batchPayments()
            ->create()
            ->account('account-1')
            ->reference('BATCH-9001')
            ->payment('invoice-1', 100)
            ->payment('invoice-2', 200)
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $bp = Json::extractFirst($json, 'BatchPayments');
        self::assertNotNull($bp);
        self::assertSame('account-1', Json::extractObject($bp, 'Account')['AccountID']);
        self::assertSame('BATCH-9001', $bp['Reference']);
        $payments = Json::extractList($bp, 'Payments');
        self::assertCount(2, $payments);
    }

    public function test_model_set_payments_replaces_entries(): void
    {
        $batchPayment = (new BatchPayment())
            ->setPayments([
                (new PaymentEntry())->setInvoiceID('invoice-9'),
            ]);

        self::assertSame('invoice-9', $batchPayment->getPayments()[0]->getInvoiceID());
    }

    public function test_history_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new BatchPayment())->history();
    }
}
