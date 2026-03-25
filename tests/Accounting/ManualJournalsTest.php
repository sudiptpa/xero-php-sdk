<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\ManualJournal\ManualJournal;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ManualJournalsTest extends TestCase
{
    public function test_it_can_query_and_find_manual_journals(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'ManualJournals' => [[
                'ManualJournalID' => 'journal-1',
                'Narration' => 'Month end adjustments',
                'Status' => 'POSTED',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ManualJournals' => [[
                'ManualJournalID' => 'journal-1',
                'Narration' => 'Month end adjustments',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $manualJournals = $client->accounting()->manualJournals()->where('Status == :status', status: 'POSTED')->get();
        $manualJournal = $client->accounting()->manualJournals()->find('journal-1');

        self::assertSame('/api.xro/2.0/ManualJournals', $transport->requests()[0]->path);
        self::assertInstanceOf(ManualJournal::class, $manualJournals->first());
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1', $transport->requests()[1]->path);
        self::assertSame('journal-1', $manualJournal?->id);
    }

    public function test_it_can_create_and_update_manual_journals(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'ManualJournals' => [[
                'ManualJournalID' => 'journal-1',
                'Narration' => 'Month end adjustments',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ManualJournals' => [[
                'ManualJournalID' => 'journal-1',
                'Narration' => 'Revised month end adjustments',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->manualJournals()->create()
            ->narration('Month end adjustments')
            ->line(100, '200', true)
            ->line(100, '300', false)
            ->save();

        $updated = $created->narration('Revised month end adjustments')->save();

        self::assertSame('/api.xro/2.0/ManualJournals', $transport->requests()[0]->path);
        self::assertSame('Month end adjustments', $transport->requests()[0]->json['ManualJournals'][0]['Narration']);
        self::assertSame('/api.xro/2.0/ManualJournals', $transport->requests()[1]->path);
        self::assertSame('journal-1', $transport->requests()[1]->json['ManualJournals'][0]['ManualJournalID']);
        self::assertSame('Revised month end adjustments', $updated->narration);
    }
}
