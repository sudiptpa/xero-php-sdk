<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Receipt\Attachment;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ReceiptAttachmentsTest extends TestCase
{
    public function test_it_can_list_and_upload_receipt_attachments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-1',
                'FileName' => 'receipt.jpg',
                'MimeType' => 'image/jpeg',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-2',
                'FileName' => 'receipt.jpg',
                'MimeType' => 'image/jpeg',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $attachments = $client->accounting()->receipts()->attachments('receipt-1')->get();
        $uploaded = $client->accounting()->receipts()->attachments('receipt-1')
            ->upload('receipt.jpg', 'binary-image')
            ->mimeType('image/jpeg')
            ->save();

        self::assertSame('/api.xro/2.0/Receipts/receipt-1/Attachments', $transport->requests()[0]->path);
        self::assertInstanceOf(Attachment::class, $attachments->first());
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertStringContainsString('/api.xro/2.0/Receipts/receipt-1/Attachments/receipt.jpg', $transport->requests()[1]->path);
        self::assertSame('image/jpeg', $transport->requests()[1]->headers['Content-Type']);
        self::assertSame('attachment-2', $uploaded->id);
    }

    public function test_it_can_download_receipt_attachments_by_name_and_id_and_from_model(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Receipts' => [[
                'ReceiptID' => 'receipt-1',
                'ReceiptNumber' => 'R-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: 'receipt-by-name'));
        $transport->push(new Response(200, body: 'receipt-by-id'));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-1',
                'FileName' => 'receipt.jpg',
                'MimeType' => 'image/jpeg',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $receipt = $client->accounting()->receipts()->find('receipt-1');
        $attachments = $client->accounting()->receipts()->attachments('receipt-1');
        $byName = $attachments->download('receipt.jpg', 'image/jpeg');
        $byId = $attachments->downloadById('attachment-1', 'image/jpeg');
        $fromModel = $receipt?->attachments()->get();

        self::assertSame('/api.xro/2.0/Receipts/receipt-1', $transport->requests()[0]->path);
        self::assertSame('/api.xro/2.0/Receipts/receipt-1/Attachments/receipt.jpg', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/Receipts/receipt-1/Attachments/attachment-1', $transport->requests()[2]->path);
        self::assertSame('/api.xro/2.0/Receipts/receipt-1/Attachments', $transport->requests()[3]->path);
        self::assertSame('receipt-by-name', $byName);
        self::assertSame('receipt-by-id', $byId);
        self::assertInstanceOf(Attachment::class, $fromModel?->first());
    }

    public function test_it_url_encodes_receipt_attachment_filenames_on_download(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: 'encoded-download'));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $binary = $client->accounting()->receipts()->attachments('receipt-1')
            ->download('receipt image.jpg', 'image/jpeg');

        self::assertSame('/api.xro/2.0/Receipts/receipt-1/Attachments/receipt%20image.jpg', $transport->requests()[0]->path);
        self::assertSame('encoded-download', $binary);
    }
}
