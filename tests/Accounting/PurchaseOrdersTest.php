<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\PurchaseOrder\PurchaseOrder;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
        $firstPo = $purchaseOrders->first();
        self::assertNotNull($firstPo);
        self::assertSame('/api.xro/2.0/PurchaseOrders/po-1', $transport->requests()[1]->path);
        self::assertSame('po-1', $purchaseOrder?->getPurchaseOrderID());
        self::assertSame('contact-1', $firstPo->getContact()?->getContactID());
        self::assertSame('Hardware', $firstPo->getLineItems()[0]->getDescription());
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
        $json0 = $transport->requests()[0]->json ?? [];
        $po0 = Json::extractFirst($json0, 'PurchaseOrders');
        self::assertNotNull($po0);
        self::assertSame('contact-1', Json::extractObject($po0, 'Contact')['ContactID']);
        $json1 = $transport->requests()[1]->json ?? [];
        $po1 = Json::extractFirst($json1, 'PurchaseOrders');
        self::assertNotNull($po1);
        self::assertSame('/api.xro/2.0/PurchaseOrders', $transport->requests()[1]->path);
        self::assertSame('po-1', $po1['PurchaseOrderID']);
        self::assertSame('PO-REF-UPDATED', $updated->getReference());
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->purchaseOrders();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.transactions.read', 'accounting.transactions'], $scopes->granular);
    }

    public function test_it_can_paginate_purchase_orders(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['PurchaseOrders' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->purchaseOrders()
            ->paginate(page: 2, perPage: 20);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(20, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(20, $page->perPage);
    }

    public function test_payload_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'PurchaseOrders' => [['PurchaseOrderID' => 'po-1']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->purchaseOrders()
            ->update('po-1')
            ->contact('contact-1')
            ->reference('PO-9001')
            ->lineItem('Stock', 5, 12)
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $po = Json::extractFirst($json, 'PurchaseOrders');
        self::assertNotNull($po);
        self::assertSame('po-1', $po['PurchaseOrderID']);
        self::assertSame('contact-1', Json::extractObject($po, 'Contact')['ContactID']);
        self::assertSame('PO-9001', $po['Reference']);
        $lineItems = Json::extractList($po, 'LineItems');
        self::assertSame('Stock', $lineItems[0]['Description'] ?? null);
    }

    public function test_model_fluent_helpers_set_fields(): void
    {
        $purchaseOrder = (new PurchaseOrder())
            ->contact('contact-9')
            ->lineItem('Stock', 1, 50)
            ->setLineItems([
                (new LineItem())->setDescription('Replaced'),
            ]);

        self::assertSame('contact-9', $purchaseOrder->getContact()?->getContactID());
        self::assertSame('Replaced', $purchaseOrder->getLineItems()[0]->getDescription());
    }

    public function test_bound_model_exposes_attachments_history_and_pdf(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'PurchaseOrders' => [['PurchaseOrderID' => 'po-1']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-1.4 po'));

        $purchaseOrder = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->purchaseOrders()
            ->find('po-1');

        self::assertNotNull($purchaseOrder);
        $purchaseOrder->attachments();
        $purchaseOrder->history();
        $pdf = $purchaseOrder->pdf();

        self::assertSame('%PDF-1.4 po', $pdf);
        self::assertSame('/api.xro/2.0/PurchaseOrders/po-1/pdf', $transport->requests()[1]->path);
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new PurchaseOrder())->save();
    }

    public function test_attachments_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new PurchaseOrder())->attachments();
    }

    public function test_history_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new PurchaseOrder())->history();
    }

    public function test_pdf_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new PurchaseOrder())->pdf();
    }
}
