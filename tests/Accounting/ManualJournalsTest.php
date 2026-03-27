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

    public function test_it_can_list_upload_and_download_manual_journal_attachments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-1',
                'FileName' => 'journal.pdf',
                'MimeType' => 'application/pdf',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-1',
                'FileName' => 'journal.pdf',
                'MimeType' => 'application/pdf',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: 'journal-by-name'));
        $transport->push(new Response(200, body: 'journal-by-id'));

        $attachments = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->manualJournals()
            ->attachments('journal-1');

        $list = $attachments->get();
        $uploaded = $attachments->upload('journal.pdf', 'binary-journal')
            ->mimeType('application/pdf')
            ->save();
        $byName = $attachments->download('journal.pdf', 'application/pdf');
        $byId = $attachments->downloadById('attachment-1', 'application/pdf');

        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/Attachments', $transport->requests()[0]->path);
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertStringContainsString('/api.xro/2.0/ManualJournals/journal-1/Attachments/journal.pdf', $transport->requests()[1]->path);
        self::assertSame('application/pdf', $transport->requests()[1]->headers['Content-Type']);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/Attachments/journal.pdf', $transport->requests()[2]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/Attachments/attachment-1', $transport->requests()[3]->path);
        self::assertCount(1, $list);
        self::assertSame('journal.pdf', $uploaded->fileName);
        self::assertSame('journal-by-name', $byName);
        self::assertSame('journal-by-id', $byId);
    }

    public function test_it_can_access_manual_journal_attachments_from_a_loaded_model(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'ManualJournals' => [[
                'ManualJournalID' => 'journal-1',
                'Narration' => 'Month end adjustments',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-1',
                'FileName' => 'journal.pdf',
                'MimeType' => 'application/pdf',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $manualJournal = $client->accounting()->manualJournals()->find('journal-1');
        $attachments = $manualJournal?->attachments()->get();

        self::assertSame('/api.xro/2.0/ManualJournals/journal-1', $transport->requests()[0]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/Attachments', $transport->requests()[1]->path);
        self::assertSame('journal.pdf', $attachments?->first()?->fileName);
    }

    public function test_it_can_list_and_record_manual_journal_history_from_resource_and_model(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'HistoryRecords' => [[
                'Details' => 'Created in app',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'HistoryRecords' => [[
                'Details' => 'Updated in app',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ManualJournals' => [[
                'ManualJournalID' => 'journal-1',
                'Narration' => 'Month end adjustments',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'HistoryRecords' => [[
                'Details' => 'Viewed from model',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $history = $client->accounting()->manualJournals()->history('journal-1')->get();
        $record = $client->accounting()->manualJournals()->history('journal-1')->record('Updated in app');
        $manualJournal = $client->accounting()->manualJournals()->find('journal-1');
        $modelHistory = $manualJournal?->history()->get();

        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/History', $transport->requests()[0]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/History', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1', $transport->requests()[2]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/History', $transport->requests()[3]->path);
        self::assertSame('Created in app', $history->first()?->details);
        self::assertSame('Updated in app', $record->details);
        self::assertSame('Viewed from model', $modelHistory->first()?->details);
    }
}
