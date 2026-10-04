<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use RuntimeException;
use Sujip\Xero\Accounting\Currency\Currency;
use Sujip\Xero\Accounting\Receipt\Receipt;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class ReceiptsTest extends TestCase
{
    public function test_it_can_query_and_find_receipts(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Receipts' => [[
                'ReceiptID' => 'receipt-1',
                'ReceiptNumber' => 'REC-1001',
                'Status' => 'DRAFT',
                'Total' => 45,
                'Contact' => [
                    'ContactID' => 'contact-1',
                ],
                'Date' => '2026-04-01T00:00:00',
                'LineItems' => [[
                    'Description' => 'Taxi fare',
                    'Quantity' => 1,
                    'UnitAmount' => 45,
                ]],
                'User' => [
                    'UserID' => 'user-1',
                ],
                'Reference' => 'REF-1',
                'LineAmountTypes' => 'Exclusive',
                'SubTotal' => 40,
                'TotalTax' => 5,
                'UpdatedDateUTC' => '2026-04-01T01:00:00',
                'HasAttachments' => true,
                'Url' => 'https://example.com/receipt',
                'ValidationErrors' => [['Message' => 'Bad receipt']],
                'Warnings' => [['Message' => 'Receipt warning']],
                'Attachments' => [['AttachmentID' => 'attach-1', 'FileName' => 'photo.jpg']],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Receipts' => [[
                'ReceiptID' => 'receipt-1',
                'ReceiptNumber' => 'REC-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $receipts = $client->accounting()->receipts()->where('Status == :status', status: 'DRAFT')->unitDp(4)->get();
        $receipt = $client->accounting()->receipts()->find('receipt-1');

        self::assertSame('/api.xro/2.0/Receipts', $transport->requests()[0]->path);
        self::assertSame(4, $transport->requests()[0]->query['unitdp']);
        self::assertInstanceOf(Receipt::class, $receipts->first());
        self::assertSame('contact-1', $receipts->first()->getContact()?->getContactID());
        self::assertSame('REC-1001', $receipts->first()->getReceiptNumber());
        self::assertSame('DRAFT', $receipts->first()->getStatus());
        self::assertSame(45, $receipts->first()->getTotal());
        self::assertSame('/api.xro/2.0/Receipts/receipt-1', $transport->requests()[1]->path);
        self::assertSame('receipt-1', $receipt?->getReceiptID());

        $first = $receipts->first();
        self::assertSame('2026-04-01T00:00:00', $first->getDate());
        self::assertCount(1, $first->getLineItems());
        self::assertSame('Taxi fare', $first->getLineItems()[0]->getDescription());
        self::assertSame('user-1', $first->getUser()?->getUserID());
        self::assertSame('REF-1', $first->getReference());
        self::assertSame('Exclusive', $first->getLineAmountTypes());
        self::assertSame(40, $first->getSubTotal());
        self::assertSame(5, $first->getTotalTax());
        self::assertSame('2026-04-01T01:00:00', $first->getUpdatedDateUTC());
        self::assertTrue($first->getHasAttachments());
        self::assertSame('https://example.com/receipt', $first->getUrl());
        self::assertCount(1, $first->getValidationErrors());
        self::assertSame('Bad receipt', $first->getValidationErrors()[0]->getMessage());
        self::assertCount(1, $first->getWarnings());
        self::assertSame('Receipt warning', $first->getWarnings()[0]->getMessage());
        self::assertCount(1, $first->getAttachments());
        self::assertSame('attach-1', $first->getAttachments()[0]->getAttachmentID());
        self::assertSame('photo.jpg', $first->getAttachments()[0]->getFileName());

        self::assertNotSame([], $client->accounting()->receipts()->scopes()->broad);

        $model = (new Receipt())->setContactID('contact-9');
        self::assertSame('contact-9', $model->getContactID());
    }

    public function test_it_can_create_and_update_receipts(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Receipts' => [[
                'ReceiptID' => 'receipt-2',
                'Status' => 'DRAFT',
                'Total' => 25,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Receipts' => [[
                'ReceiptID' => 'receipt-2',
                'Status' => 'DRAFT',
                'Reference' => 'Audit ref',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->receipts()->create()
            ->contact('contact-1')
            ->user('user-1')
            ->lineItem('Taxi fare', 1, 25, '453')
            ->date('2026-04-01')
            ->lineAmountTypes('NoTax')
            ->save();

        $updated = $client->accounting()->receipts()->update('receipt-2')
            ->contact('contact-1')
            ->user('user-1')
            ->lineItem('Taxi fare updated', 1, 30)
            ->reference('Audit ref')
            ->status('DRAFT')
            ->save();

        self::assertSame('PUT', $transport->requests()[0]->method);
        self::assertSame('/api.xro/2.0/Receipts', $transport->requests()[0]->path);
        $sent = Json::extractFirst($transport->requests()[0]->json ?? [], 'Receipts') ?? [];
        self::assertSame('contact-1', Json::extractObject($sent, 'Contact')['ContactID'] ?? null);
        self::assertSame('user-1', Json::extractObject($sent, 'User')['UserID'] ?? null);
        $sentLineItem = Json::extractList($sent, 'LineItems')[0] ?? [];
        self::assertSame('Taxi fare', $sentLineItem['Description'] ?? null);
        self::assertSame('453', $sentLineItem['AccountCode'] ?? null);
        self::assertSame('NoTax', $sent['LineAmountTypes'] ?? null);
        self::assertSame('2026-04-01', $sent['Date'] ?? null);
        self::assertSame('receipt-2', $created->getReceiptID());

        self::assertSame('POST', $transport->requests()[1]->method);
        self::assertSame('/api.xro/2.0/Receipts/receipt-2', $transport->requests()[1]->path);
        $sentUpdate = Json::extractFirst($transport->requests()[1]->json ?? [], 'Receipts');
        self::assertNotNull($sentUpdate);
        self::assertSame('receipt-2', $sentUpdate['ReceiptID'] ?? null);
        self::assertSame('Audit ref', $sentUpdate['Reference'] ?? null);
        self::assertSame('Audit ref', $updated->getReference());
    }

    public function test_receipt_model_save_requires_a_bound_client(): void
    {
        $this->expectException(RuntimeException::class);

        (new Receipt())->save();
    }

    public function test_receipt_model_save_delegates_to_payload(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Receipts' => [[
                'ReceiptID' => 'receipt-3',
                'Status' => 'DRAFT',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $receipt = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->accounting()->receipts()->mapReceipt(['ReceiptID' => 'receipt-3'])
            ->setReference('Saved directly');

        $saved = $receipt->save();

        self::assertSame('POST', $transport->requests()[0]->method);
        self::assertSame('/api.xro/2.0/Receipts/receipt-3', $transport->requests()[0]->path);
        self::assertSame('receipt-3', $saved->getReceiptID());
    }

    public function test_receipt_setters_compose_a_model(): void
    {
        $receipt = (new Receipt())
            ->setDate('2026-04-01T00:00:00')
            ->setUser((new \Sujip\Xero\Accounting\User\User())->setUserID('user-2'))
            ->setReference('REF-2')
            ->setLineAmountTypes('Inclusive')
            ->setSubTotal(100)
            ->setTotalTax(15)
            ->setUpdatedDateUTC('2026-04-02T00:00:00')
            ->setHasAttachments(false)
            ->setUrl('https://example.com/other');

        self::assertSame('2026-04-01T00:00:00', $receipt->getDate());
        self::assertSame('user-2', $receipt->getUser()?->getUserID());
        self::assertSame('REF-2', $receipt->getReference());
        self::assertSame('Inclusive', $receipt->getLineAmountTypes());
        self::assertSame(100, $receipt->getSubTotal());
        self::assertSame(15, $receipt->getTotalTax());
        self::assertSame('2026-04-02T00:00:00', $receipt->getUpdatedDateUTC());
        self::assertFalse($receipt->getHasAttachments());
        self::assertSame('https://example.com/other', $receipt->getUrl());
    }

    public function test_receipt_attachments_require_a_bound_client(): void
    {
        $this->expectException(RuntimeException::class);

        (new Receipt())->attachments();
    }

    public function test_receipt_history_requires_a_bound_client(): void
    {
        $this->expectException(RuntimeException::class);

        (new Receipt())->history();
    }

    public function test_receipt_maps_non_contact_definitions_through_the_parent(): void
    {
        $method = new ReflectionMethod(Receipt::class, 'newDefinitionInstance');
        $instance = $method->invoke(new Receipt(), Currency::class);

        self::assertInstanceOf(Currency::class, $instance);
    }
}
