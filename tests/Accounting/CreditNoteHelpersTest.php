<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\CreditNote\Attachment;
use Sujip\Xero\Accounting\CreditNote\HistoryRecord;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
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
                'MimeType' => 'application/pdf',
                'IncludeOnline' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-2',
                'FileName' => 'credit-note.pdf',
                'MimeType' => 'application/pdf',
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
        self::assertInstanceOf(Attachment::class, $attachments->first());
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertStringContainsString('/api.xro/2.0/CreditNotes/credit-1/Attachments/credit-note.pdf', $transport->requests()[1]->path);
        self::assertSame('application/pdf', $transport->requests()[1]->headers['Content-Type']);
        self::assertTrue((bool) $uploaded->includeOnline);
    }

    public function test_it_can_list_history_record_history_and_fetch_pdf(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'HistoryRecords' => [[
                'Details' => 'Created in ERP',
                'User' => 'System',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'HistoryRecords' => [[
                'Details' => 'Updated from ERP',
                'User' => 'System',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-credit-note'));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $history = $client->accounting()->creditNotes()->history('credit-1')->get();
        $record = $client->accounting()->creditNotes()->history('credit-1')->record('Updated from ERP');
        $pdf = $client->accounting()->creditNotes()->pdf('credit-1');

        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/History', $transport->requests()[0]->path);
        self::assertInstanceOf(HistoryRecord::class, $history->first());
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertSame('Updated from ERP', $transport->requests()[1]->json['HistoryRecords'][0]['Details']);
        self::assertSame('Updated from ERP', $record->details);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/pdf', $transport->requests()[2]->path);
        self::assertSame('application/pdf', $transport->requests()[2]->headers['Accept']);
        self::assertSame('%PDF-credit-note', $pdf);
    }
}
