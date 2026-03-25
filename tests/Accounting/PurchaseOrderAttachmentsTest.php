<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\PurchaseOrder\Attachment;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class PurchaseOrderAttachmentsTest extends TestCase
{
    public function test_it_can_list_and_upload_purchase_order_attachments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-1',
                'FileName' => 'purchase-order.pdf',
                'MimeType' => 'application/pdf',
                'IncludeOnline' => false,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Attachments' => [[
                'AttachmentID' => 'attachment-2',
                'FileName' => 'purchase-order.pdf',
                'MimeType' => 'application/pdf',
                'IncludeOnline' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $attachments = $client->accounting()->purchaseOrders()->attachments('po-1')->get();
        $uploaded = $client->accounting()->purchaseOrders()->attachments('po-1')
            ->upload('purchase-order.pdf', 'binary-pdf')
            ->mimeType('application/pdf')
            ->includeOnline()
            ->save();

        self::assertSame('/api.xro/2.0/PurchaseOrders/po-1/Attachments', $transport->requests()[0]->path);
        self::assertInstanceOf(Attachment::class, $attachments->first());
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertStringContainsString('/api.xro/2.0/PurchaseOrders/po-1/Attachments/purchase-order.pdf', $transport->requests()[1]->path);
        self::assertSame('application/pdf', $transport->requests()[1]->headers['Content-Type']);
        self::assertTrue((bool) $uploaded->includeOnline);
    }
}
