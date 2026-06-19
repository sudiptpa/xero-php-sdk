<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\ManualJournal\JournalLine;
use Sujip\Xero\Accounting\ManualJournal\ManualJournal;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
                'JournalLines' => [[
                    'LineAmount' => 100,
                    'AccountCode' => '200',
                    'AccountID' => 'account-1',
                    'Description' => 'Office equipment',
                    'TaxType' => 'NONE',
                    'TaxAmount' => 0,
                    'IsBlank' => false,
                    'Tracking' => [[
                        'TrackingCategoryID' => 'category-1',
                        'Name' => 'Region',
                    ]],
                ]],
                'Date' => '2026-03-25',
                'LineAmountTypes' => 'NoTax',
                'Url' => 'https://example.test/source',
                'ShowOnCashBasisReports' => true,
                'HasAttachments' => true,
                'UpdatedDateUTC' => '2026-03-25T00:00:00',
                'StatusAttributeString' => 'ERROR',
                'Warnings' => [['Message' => 'Journal is unbalanced']],
                'ValidationErrors' => [['Message' => 'Invalid account code']],
                'Attachments' => [['AttachmentID' => 'attachment-1', 'FileName' => 'journal.pdf', 'MimeType' => 'application/pdf']],
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
        $firstMj = $manualJournals->first();
        self::assertNotNull($firstMj);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1', $transport->requests()[1]->path);
        self::assertSame('journal-1', $manualJournal?->getManualJournalID());
        $line = $firstMj->getJournalLines()[0];
        self::assertSame('200', $line->getAccountCode());
        self::assertSame('account-1', $line->getAccountID());
        self::assertSame('Office equipment', $line->getDescription());
        self::assertSame('NONE', $line->getTaxType());
        self::assertSame(0, $line->getTaxAmount());
        self::assertFalse($line->getIsBlank());
        self::assertSame('category-1', $line->getTracking()[0]->getTrackingCategoryID());
        self::assertSame('2026-03-25', $firstMj->getDate());
        self::assertSame('NoTax', $firstMj->getLineAmountTypes());
        self::assertSame('https://example.test/source', $firstMj->getUrl());
        self::assertTrue($firstMj->getShowOnCashBasisReports());
        self::assertTrue($firstMj->getHasAttachments());
        self::assertSame('2026-03-25T00:00:00', $firstMj->getUpdatedDateUTC());
        self::assertSame('ERROR', $firstMj->getStatusAttributeString());
        self::assertSame('Journal is unbalanced', $firstMj->getWarnings()[0]->getMessage());
        self::assertSame('Invalid account code', $firstMj->getValidationErrors()[0]->getMessage());
        self::assertSame('journal.pdf', $firstMj->getAttachments()[0]->getFileName());
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
            ->using(
                (new ManualJournal())
                    ->setNarration('Month end adjustments')
                    ->addJournalLine(
                        (new JournalLine())
                            ->setLineAmount(100)
                            ->setAccountCode('200')
                    )
                    ->addJournalLine(
                        (new JournalLine())
                            ->setLineAmount(-100)
                            ->setAccountCode('300')
                    )
            )
            ->save();

        $updated = $created->narration('Revised month end adjustments')->save();

        self::assertSame('/api.xro/2.0/ManualJournals', $transport->requests()[0]->path);
        $json0 = $transport->requests()[0]->json ?? [];
        $mj0 = Json::extractFirst($json0, 'ManualJournals');
        self::assertNotNull($mj0);
        self::assertSame('Month end adjustments', $mj0['Narration']);
        $json1 = $transport->requests()[1]->json ?? [];
        $mj1 = Json::extractFirst($json1, 'ManualJournals');
        self::assertNotNull($mj1);
        self::assertSame('/api.xro/2.0/ManualJournals', $transport->requests()[1]->path);
        self::assertSame('journal-1', $mj1['ManualJournalID']);
        self::assertSame('Revised month end adjustments', $updated->getNarration());
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
        $modelHistory = $manualJournal?->history()?->get();

        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/History', $transport->requests()[0]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/History', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1', $transport->requests()[2]->path);
        self::assertSame('/api.xro/2.0/ManualJournals/journal-1/History', $transport->requests()[3]->path);
        self::assertSame('Created in app', $history->first()?->details);
        self::assertSame('Updated in app', $record->details);
        self::assertSame('Viewed from model', $modelHistory?->first()?->details);
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->manualJournals();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.transactions.read', 'accounting.transactions'], $scopes->granular);
    }

    public function test_it_can_paginate_manual_journals(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['ManualJournals' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->manualJournals()
            ->paginate(page: 2, perPage: 15);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(15, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(15, $page->perPage);
    }

    public function test_it_maps_journal_lines_directly(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->manualJournals();

        $line = $resource->mapJournalLine([
            'LineAmount' => 100,
            'AccountCode' => '200',
        ]);

        self::assertSame('200', $line->getAccountCode());
    }

    public function test_payload_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'ManualJournals' => [['ManualJournalID' => 'mj-1']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->manualJournals()
            ->update('mj-1')
            ->narration('Year end adjustments')
            ->line(100, '200', true)
            ->line(100, '090', false)
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $mj = Json::extractFirst($json, 'ManualJournals');
        self::assertNotNull($mj);
        self::assertSame('mj-1', $mj['ManualJournalID']);
        self::assertSame('Year end adjustments', $mj['Narration']);
        $lines = Json::extractList($mj, 'JournalLines');
        self::assertCount(2, $lines);
        self::assertSame('200', $lines[0]['AccountCode'] ?? null);
        self::assertSame(100, $lines[0]['LineAmount'] ?? null);
        self::assertSame('090', $lines[1]['AccountCode'] ?? null);
        self::assertSame(-100, $lines[1]['LineAmount'] ?? null);
    }

    public function test_model_fluent_helpers_set_fields(): void
    {
        $journal = (new ManualJournal())
            ->narration('Adjustment')
            ->line(50, '200', true)
            ->setJournalLines([
                (new JournalLine())->setAccountCode('090'),
            ]);

        self::assertSame('Adjustment', $journal->getNarration());
        self::assertSame('090', $journal->getJournalLines()[0]->getAccountCode());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new ManualJournal())->save();
    }

    public function test_attachments_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new ManualJournal())->attachments();
    }

    public function test_history_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new ManualJournal())->history();
    }
}
