<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class CreditNoteHelpersTest extends TestCase
{
    public function test_it_can_list_and_upload_credit_note_attachments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-1',
                'FileName' => 'credit-note.pdf',
                'Url' => 'https://api.xero.com/api.xro/2.0/CreditNotes/credit-1/Attachments/credit-note.pdf',
                'MimeType' => 'application/pdf',
                'ContentLength' => 2878711,
                'IncludeOnline' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-2',
                'FileName' => 'credit-note.pdf',
                'Url' => 'https://api.xero.com/api.xro/2.0/CreditNotes/credit-1/Attachments/credit-note.pdf',
                'MimeType' => 'application/pdf',
                'ContentLength' => 2878711,
                'IncludeOnline' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $attachments = $client->accounting()->creditNotes()->attachments('credit-1')->get();
        $uploaded = $client->accounting()->creditNotes()->attachments('credit-1')
            ->upload('credit-note.pdf', 'binary-pdf')
            ->mimeType('application/pdf')
            ->includeOnline()
            ->save();

        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/Attachments', $transport->requests()[0]->path);
        $first = $attachments->first();
        self::assertNotNull($first);
        self::assertSame('https://api.xero.com/api.xro/2.0/CreditNotes/credit-1/Attachments/credit-note.pdf', $first->url);
        self::assertSame(2878711, $first->contentLength);
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertStringContainsString('/api.xro/2.0/CreditNotes/credit-1/Attachments/credit-note.pdf', $transport->requests()[1]->path);
        self::assertSame('application/pdf', $transport->requests()[1]->headers['Content-Type']);
        self::assertTrue((bool) $uploaded->includeOnline);
        self::assertSame(2878711, $uploaded->contentLength);
    }

    public function test_it_can_download_credit_note_attachments_by_name_and_id(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: 'credit-note-by-name'));
        $transport->push(new Response(200, body: 'credit-note-by-id'));

        $attachments = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->attachments('credit-1');

        $byName = $attachments->download('credit-note.pdf', 'application/pdf');
        $byId = $attachments->downloadById('attachment-1', 'application/pdf');

        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/Attachments/credit-note.pdf', $transport->requests()[0]->path);
        self::assertSame('application/pdf', $transport->requests()[0]->headers['Accept']);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/Attachments/attachment-1', $transport->requests()[1]->path);
        self::assertSame('credit-note-by-name', $byName);
        self::assertSame('credit-note-by-id', $byId);
    }

    public function test_it_can_update_a_credit_note_attachment(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-1',
                'FileName' => 'credit-note.pdf',
                'MimeType' => 'application/pdf',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $updated = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->attachments('credit-1')
            ->upload('credit-note.pdf', 'binary-pdf-v2')
            ->update();

        self::assertSame('POST', $transport->requests()[0]->method);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/Attachments/credit-note.pdf', $transport->requests()[0]->path);
        self::assertSame('attachment-1', $updated->id);
    }

    public function test_it_can_list_history_record_history_and_fetch_pdf(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'HistoryRecords' => [[
                'Details' => 'Created in ERP',
                'User' => 'System',
                'DateUTC' => '2026-03-25T00:00:00',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'HistoryRecords' => [[
                'Details' => 'Updated from ERP',
                'User' => 'System',
                'DateUTC' => '2026-03-26T00:00:00',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-credit-note'));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $history = $client->accounting()->creditNotes()->history('credit-1')->get();
        $record = $client->accounting()->creditNotes()->history('credit-1')->record('Updated from ERP');
        $pdf = $client->accounting()->creditNotes()->pdf('credit-1');

        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/History', $transport->requests()[0]->path);
        self::assertNotNull($history->first());
        self::assertSame('2026-03-25T00:00:00', $history->first()->dateUtc);
        self::assertSame('PUT', $transport->requests()[1]->method);
        $json1 = $transport->requests()[1]->json ?? [];
        $hr = Json::extractFirst($json1, 'HistoryRecords');
        self::assertNotNull($hr);
        self::assertSame('Updated from ERP', $hr['Details']);
        self::assertSame('Updated from ERP', $record->details);
        self::assertSame('2026-03-26T00:00:00', $record->dateUtc);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1', $transport->requests()[2]->path);
        self::assertSame('application/pdf', $transport->requests()[2]->headers['Accept']);
        self::assertSame('%PDF-credit-note', $pdf);
    }
}
