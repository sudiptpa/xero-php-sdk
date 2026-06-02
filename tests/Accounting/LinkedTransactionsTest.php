<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\LinkedTransaction\LinkedTransaction;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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

        self::assertSame('/api.xro/2.0/LinkedTransactions', $transport->requests()[0]->path);
        $json0 = $transport->requests()[0]->json ?? [];
        self::assertSame('source-1', $json0['SourceTransactionID'] ?? null);
        self::assertSame('target-1', $linkedTransaction->getTargetTransactionID());
    }
}
