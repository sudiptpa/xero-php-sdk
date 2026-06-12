<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class LinkedTransactionsTest extends TestCase
{
    public function test_it_can_query_linked_transactions(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'LinkedTransactions' => [[
                    'LinkedTransactionID' => 'linked-1',
                    'SourceTransactionID' => 'source-1',
                    'TargetTransactionID' => 'target-1',
                    'ContactID' => 'contact-1',
                    'Status' => 'ACTIVE',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $linkedTransactions = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->linkedTransactions()
            ->sourceTransaction('source-1')
            ->status('active')
            ->page(1)
            ->get();

        self::assertSame('/api.xro/2.0/LinkedTransactions', $transport->requests()[0]->path);
        self::assertSame('source-1', $transport->requests()[0]->query['SourceTransactionID']);
        self::assertSame('ACTIVE', $transport->requests()[0]->query['Status']);
        $firstLt = $linkedTransactions->first();
        self::assertNotNull($firstLt);
        self::assertSame('source-1', $firstLt->getSourceTransactionID());
    }

    public function test_it_can_create_linked_transactions(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'LinkedTransactions' => [[
                    'LinkedTransactionID' => 'linked-1',
                    'SourceTransactionID' => 'source-1',
                    'TargetTransactionID' => 'target-1',
                    'ContactID' => 'contact-1',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $linkedTransaction = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->linkedTransactions()
            ->create()
            ->using(
                (new LinkedTransaction())
                    ->setSourceTransactionID('source-1')
                    ->setTargetTransactionID('target-1')
                    ->setContactID('contact-1')
            )
            ->save();

        self::assertSame('PUT', $transport->requests()[0]->method);
        self::assertSame('/api.xro/2.0/LinkedTransactions', $transport->requests()[0]->path);
        $json0 = $transport->requests()[0]->json ?? [];
        self::assertSame('source-1', $json0['SourceTransactionID'] ?? null);
        self::assertSame('target-1', $linkedTransaction->getTargetTransactionID());
    }

    public function test_it_filters_by_id_target_and_contact(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'LinkedTransactions' => [[
                    'LinkedTransactionID' => 'linked-1',
                    'SourceTransactionID' => 'source-1',
                    'TargetTransactionID' => 'target-1',
                    'ContactID' => 'contact-1',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $linkedTransactions = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()->linkedTransactions();

        $linkedTransactions
            ->linkedTransactionId('linked-1')
            ->targetTransaction('target-1')
            ->contact('contact-1')
            ->get();

        $query = $transport->requests()[0]->query;
        self::assertSame('linked-1', $query['LinkedTransactionID']);
        self::assertSame('target-1', $query['TargetTransactionID']);
        self::assertSame('contact-1', $query['ContactID']);
        self::assertNotSame([], $linkedTransactions->scopes()->broad);
    }

    public function test_it_creates_via_builder_methods(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'LinkedTransactions' => [[
                    'LinkedTransactionID' => 'linked-1',
                    'SourceTransactionID' => 'source-1',
                    'TargetTransactionID' => 'target-1',
                    'ContactID' => 'contact-1',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $linkedTransaction = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()
            ->linkedTransactions()
            ->create()
            ->sourceTransaction('source-1')
            ->targetTransaction('target-1')
            ->contact('contact-1')
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        self::assertSame('source-1', $json['SourceTransactionID'] ?? null);
        self::assertSame('target-1', $json['TargetTransactionID'] ?? null);
        self::assertSame('contact-1', $json['ContactID'] ?? null);
        self::assertSame('linked-1', $linkedTransaction->getLinkedTransactionID());
    }

    public function test_it_can_find_a_linked_transaction(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'LinkedTransactions' => [['LinkedTransactionID' => 'linked-1', 'Status' => 'DRAFT']],
        ], JSON_THROW_ON_ERROR)));

        $linkedTransaction = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()
            ->linkedTransactions()
            ->find('linked-1');

        self::assertSame('/api.xro/2.0/LinkedTransactions/linked-1', $transport->requests()[0]->path);
        self::assertSame('GET', $transport->requests()[0]->method);
        self::assertNotNull($linkedTransaction);
        self::assertSame('DRAFT', $linkedTransaction->getStatus());
    }

    public function test_find_returns_null_when_linked_transaction_is_missing(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $linkedTransaction = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()
            ->linkedTransactions()
            ->find('missing');

        self::assertNull($linkedTransaction);
    }

    public function test_it_updates_a_linked_transaction_with_post(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'LinkedTransactions' => [['LinkedTransactionID' => 'linked-1', 'TargetTransactionID' => 'target-2']],
        ], JSON_THROW_ON_ERROR)));

        $linkedTransaction = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()
            ->linkedTransactions()
            ->update('linked-1')
            ->targetTransaction('target-2')
            ->save();

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/LinkedTransactions/linked-1', $request->path);
        self::assertSame('target-2', ($request->json ?? [])['TargetTransactionID'] ?? null);
        self::assertSame('target-2', $linkedTransaction->getTargetTransactionID());
    }

    public function test_it_deletes_a_linked_transaction(): void
    {
        $transport = (new FakeTransport())->push(new Response(204, body: ''));

        Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()
            ->linkedTransactions()
            ->delete('linked-1');

        self::assertSame('DELETE', $transport->requests()[0]->method);
        self::assertSame('/api.xro/2.0/LinkedTransactions/linked-1', $transport->requests()[0]->path);
    }
}
