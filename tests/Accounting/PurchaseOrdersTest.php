<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class PurchaseOrdersTest extends TestCase
{
    public function test_it_can_query_and_find_purchase_orders(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'PurchaseOrders' => [[
                'PurchaseOrderID' => 'po-1',
                'PurchaseOrderNumber' => 'PO-1001',
                'Status' => 'AUTHORISED',
                'Reference' => 'PO-REF',
                'Contact' => [
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Supplies',
                ],
                'LineItems' => [[
                    'Description' => 'Hardware',
                    'Quantity' => 1,
                    'UnitAmount' => 250,
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PurchaseOrders' => [[
                'PurchaseOrderID' => 'po-1',
                'PurchaseOrderNumber' => 'PO-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $purchaseOrders = $client->accounting()->purchaseOrders()->where('Status == :status', status: 'AUTHORISED')->get();
        $purchaseOrder = $client->accounting()->purchaseOrders()->find('po-1');

        self::assertSame('/api.xro/2.0/PurchaseOrders', $transport->requests()[0]->path);
        self::assertInstanceOf(PurchaseOrder::class, $purchaseOrders->first());
        self::assertSame('/api.xro/2.0/PurchaseOrders/po-1', $transport->requests()[1]->path);
        self::assertSame('po-1', $purchaseOrder?->getPurchaseOrderID());
        self::assertSame('contact-1', $purchaseOrders->first()->getContact()?->getContactID());
        self::assertSame('Hardware', $purchaseOrders->first()->getLineItems()[0]->getDescription());
    }

    public function test_it_can_create_and_update_purchase_orders(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'PurchaseOrders' => [[
                'PurchaseOrderID' => 'po-1',
                'Reference' => 'PO-REF',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PurchaseOrders' => [[
                'PurchaseOrderID' => 'po-1',
                'Reference' => 'PO-REF-UPDATED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->purchaseOrders()->create()
            ->using(
                (new PurchaseOrder())
                    ->setContact(
                        (new Contact())
                            ->setContactID('contact-1')
                    )
                    ->setReference('PO-REF')
                    ->addLineItem(
                        (new LineItem())
                            ->setDescription('Hardware')
                            ->setQuantity(1)
                            ->setUnitAmount(250)
                    )
            )
            ->save();

        $updated = $created->reference('PO-REF-UPDATED')->save();

        self::assertSame('/api.xro/2.0/PurchaseOrders', $transport->requests()[0]->path);
        self::assertSame('contact-1', $transport->requests()[0]->json['PurchaseOrders'][0]['Contact']['ContactID']);
        self::assertSame('/api.xro/2.0/PurchaseOrders', $transport->requests()[1]->path);
        self::assertSame('po-1', $transport->requests()[1]->json['PurchaseOrders'][0]['PurchaseOrderID']);
        self::assertSame('PO-REF-UPDATED', $updated->getReference());
    }
}
