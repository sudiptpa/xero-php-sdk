<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Invoice\Attachment;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class InvoiceAttachmentsTest extends TestCase
{
    public function test_it_can_list_invoice_attachments(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Attachments' => [[
                    'AttachmentID' => 'attachment-1',
                    'FileName' => 'invoice.pdf',
                    'MimeType' => 'application/pdf',
                    'IncludeOnline' => true,
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $attachments = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->attachments('invoice-1')
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Invoices/invoice-1/Attachments', $request->path);
        self::assertInstanceOf(Attachment::class, $attachments->first());
    }

    public function test_it_can_upload_an_invoice_attachment(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Attachments' => [[
                    'AttachmentID' => 'attachment-1',
                    'FileName' => 'invoice.pdf',
                    'MimeType' => 'application/pdf',
                    'IncludeOnline' => true,
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $attachment = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->attachments('invoice-1')
            ->upload('invoice.pdf', 'binary-pdf-content')
            ->mimeType('application/pdf')
            ->includeOnline()
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('PUT', $request->method);
        self::assertStringContainsString('/api.xro/2.0/Invoices/invoice-1/Attachments/invoice.pdf', $request->path);
        self::assertSame('application/pdf', $request->headers['Content-Type']);
        self::assertSame('binary-pdf-content', $request->body);
        self::assertTrue((bool) $attachment->includeOnline);
    }
}
