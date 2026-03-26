<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class HistoryHelpersTest extends TestCase
{
    public function test_it_can_get_and_record_history_for_remaining_resources(): void
    {
        $transport = new FakeTransport();

        foreach (range(1, 8) as $index) {
            $transport->push(new Response(200, body: json_encode([
                'HistoryRecords' => [[
                    'Details' => 'History ' . $index,
                    'DateUTC' => '2026-03-26T00:00:00',
                ]],
            ], JSON_THROW_ON_ERROR)));
        }

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $client->accounting()->bankTransactions()->history('bank-1')->get();
        $client->accounting()->bankTransactions()->history('bank-1')->record('Bank change');
        $client->accounting()->batchPayments()->history('batch-1')->record('Batch change');
        $client->accounting()->items()->history('item-1')->record('Item change');
        $client->accounting()->payments()->history('payment-1')->record('Payment change');
        $client->accounting()->receipts()->history('receipt-1')->record('Receipt change');
        $client->accounting()->purchaseOrders()->history('po-1')->get();
        $client->accounting()->purchaseOrders()->history('po-1')->record('PO change');

        self::assertSame('/api.xro/2.0/BankTransactions/bank-1/History', $transport->requests()[0]->path);
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertSame('/api.xro/2.0/BatchPayments/batch-1/History', $transport->requests()[2]->path);
        self::assertSame('/api.xro/2.0/Items/item-1/History', $transport->requests()[3]->path);
        self::assertSame('/api.xro/2.0/Payments/payment-1/History', $transport->requests()[4]->path);
        self::assertSame('/api.xro/2.0/Receipts/receipt-1/History', $transport->requests()[5]->path);
        self::assertSame('/api.xro/2.0/PurchaseOrders/po-1/History', $transport->requests()[6]->path);
        self::assertSame('PO change', $transport->requests()[7]->json['HistoryRecords'][0]['Details']);
    }

    public function test_it_can_remove_contact_group_members_and_manage_manual_journal_attachments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'ContactGroups' => [[
                'ContactGroupID' => 'group-1',
                'Name' => 'VIP',
                'Contacts' => [['ContactID' => 'contact-1']],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'FileName' => 'journal.pdf',
                'Url' => 'https://example.test/journal.pdf',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'FileName' => 'journal.pdf',
                'Url' => 'https://example.test/journal.pdf',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $group = $client->accounting()->contactGroups()->find('group-1');
        $removed = $group?->removeContact('contact-1');
        $attachments = $client->accounting()->manualJournals()->attachments('manual-1')->get();
        $upload = $client->accounting()->manualJournals()->attachments('manual-1')
            ->upload('journal.pdf', 'pdf-data')
            ->mimeType('application/pdf')
            ->save();

        self::assertSame('/api.xro/2.0/ContactGroups/group-1/Contacts/contact-1', $transport->requests()[1]->path);
        self::assertTrue((bool) $removed);
        self::assertSame('/api.xro/2.0/ManualJournals/manual-1/Attachments', $transport->requests()[2]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/manual-1/Attachments/journal.pdf', $transport->requests()[3]->path);
        self::assertSame('application/pdf', $transport->requests()[3]->headers['Content-Type']);
        self::assertSame('journal.pdf', $attachments->first()?->fileName);
        self::assertSame('journal.pdf', $upload->fileName);
    }
}
