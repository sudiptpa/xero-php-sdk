<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Invoice\Invoice;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\Invoice\LineItemItem;
use Sujip\Xero\Accounting\Invoice\LineItemTracking;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class LineItemTest extends TestCase
{
    public function test_it_hydrates_all_line_item_fields(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Invoices' => [[
                    'InvoiceID' => 'invoice-1',
                    'Type' => 'ACCREC',
                    'Status' => 'AUTHORISED',
                    'LineItems' => [[
                        'LineItemID' => 'line-1',
                        'Description' => 'Consulting',
                        'Quantity' => 2,
                        'UnitAmount' => 150,
                        'ItemCode' => 'CONSULT',
                        'AccountCode' => '200',
                        'AccountID' => 'account-1',
                        'TaxType' => 'OUTPUT2',
                        'TaxAmount' => 45,
                        'Item' => [
                            'Code' => 'CONSULT',
                            'Name' => 'Consulting Services',
                            'ItemID' => 'item-1',
                        ],
                        'LineAmount' => 300,
                        'Tracking' => [[
                            'TrackingCategoryID' => 'category-1',
                            'TrackingOptionID' => 'option-1',
                            'Name' => 'Region',
                            'Option' => 'North',
                        ]],
                        'DiscountRate' => 10,
                        'DiscountAmount' => 30,
                        'RepeatingInvoiceID' => 'repeating-1',
                        'Taxability' => 'TAXABLE',
                        'SalesTaxCodeId' => 5,
                        'TaxBreakdown' => [[
                            'TaxComponentId' => 'tax-1',
                            'Type' => 'SYSGST/USSTATE',
                            'Name' => 'State Tax',
                            'TaxPercentage' => 7.5,
                            'TaxAmount' => 22.5,
                            'TaxableAmount' => 300,
                            'NonTaxableAmount' => 0,
                            'ExemptAmount' => 0,
                            'StateAssignedNo' => 'ST-123',
                            'JurisdictionRegion' => 'California',
                        ]],
                    ]],
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $invoice = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->find('invoice-1');

        self::assertNotNull($invoice);
        $lineItem = $invoice->getLineItems()[0];

        self::assertSame('line-1', $lineItem->getLineItemID());
        self::assertSame('Consulting', $lineItem->getDescription());
        self::assertSame(2, $lineItem->getQuantity());
        self::assertSame(150, $lineItem->getUnitAmount());
        self::assertSame('CONSULT', $lineItem->getItemCode());
        self::assertSame('200', $lineItem->getAccountCode());
        self::assertSame('account-1', $lineItem->getAccountID());
        self::assertSame('OUTPUT2', $lineItem->getTaxType());
        self::assertSame(45, $lineItem->getTaxAmount());
        self::assertSame(300, $lineItem->getLineAmount());
        self::assertSame(10, $lineItem->getDiscountRate());
        self::assertSame(30, $lineItem->getDiscountAmount());
        self::assertSame('repeating-1', $lineItem->getRepeatingInvoiceID());
        self::assertSame('TAXABLE', $lineItem->getTaxability());
        self::assertSame(5, $lineItem->getSalesTaxCodeId());

        $item = $lineItem->getItem();
        self::assertInstanceOf(LineItemItem::class, $item);
        self::assertSame('CONSULT', $item->getCode());
        self::assertSame('Consulting Services', $item->getName());
        self::assertSame('item-1', $item->getItemID());

        $tracking = $lineItem->getTracking();
        self::assertCount(1, $tracking);
        self::assertSame('category-1', $tracking[0]->getTrackingCategoryID());
        self::assertSame('option-1', $tracking[0]->getTrackingOptionID());
        self::assertSame('Region', $tracking[0]->getName());
        self::assertSame('North', $tracking[0]->getOption());

        $taxBreakdown = $lineItem->getTaxBreakdown();
        self::assertCount(1, $taxBreakdown);
        $component = $taxBreakdown[0];
        self::assertSame('tax-1', $component->getTaxComponentId());
        self::assertSame('SYSGST/USSTATE', $component->getType());
        self::assertSame('State Tax', $component->getName());
        self::assertSame(7.5, $component->getTaxPercentage());
        self::assertSame(22.5, $component->getTaxAmount());
        self::assertSame(300, $component->getTaxableAmount());
        self::assertSame(0, $component->getNonTaxableAmount());
        self::assertSame(0, $component->getExemptAmount());
        self::assertSame('ST-123', $component->getStateAssignedNo());
        self::assertSame('California', $component->getJurisdictionRegion());
    }

    public function test_set_tracking_replaces_the_tracking_list(): void
    {
        $lineItem = (new LineItem())
            ->addTracking((new LineItemTracking())->setName('Region'))
            ->setTracking([(new LineItemTracking())->setName('Department')]);

        self::assertCount(1, $lineItem->getTracking());
        self::assertSame('Department', $lineItem->getTracking()[0]->getName());
    }

    public function test_it_serializes_writable_line_item_fields_to_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Invoices' => [['InvoiceID' => 'invoice-1', 'Status' => 'DRAFT']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->create()
            ->using(
                (new Invoice())
                    ->setType('ACCREC')
                    ->addLineItem(
                        (new LineItem())
                            ->setLineItemID('line-1')
                            ->setDescription('Consulting')
                            ->setQuantity(2)
                            ->setUnitAmount(150)
                            ->setItemCode('CONSULT')
                            ->setAccountCode('200')
                            ->setAccountID('account-1')
                            ->setTaxType('OUTPUT2')
                            ->setTaxAmount(45)
                            ->setLineAmount(300)
                            ->setDiscountRate(10)
                            ->setDiscountAmount(30)
                            ->addTracking(
                                (new LineItemTracking())
                                    ->setTrackingCategoryID('category-1')
                                    ->setTrackingOptionID('option-1')
                                    ->setName('Region')
                                    ->setOption('North')
                            )
                    )
            )
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $invoice = Json::extractFirst($json, 'Invoices');
        self::assertNotNull($invoice);
        $lineItem0 = Json::extractList($invoice, 'LineItems')[0];

        self::assertSame('line-1', $lineItem0['LineItemID']);
        self::assertSame('Consulting', $lineItem0['Description']);
        self::assertSame(2, $lineItem0['Quantity']);
        self::assertSame(150, $lineItem0['UnitAmount']);
        self::assertSame('CONSULT', $lineItem0['ItemCode']);
        self::assertSame('200', $lineItem0['AccountCode']);
        self::assertSame('account-1', $lineItem0['AccountID']);
        self::assertSame('OUTPUT2', $lineItem0['TaxType']);
        self::assertSame(45, $lineItem0['TaxAmount']);
        self::assertSame(300, $lineItem0['LineAmount']);
        self::assertSame(10, $lineItem0['DiscountRate']);
        self::assertSame(30, $lineItem0['DiscountAmount']);

        $tracking0 = Json::extractList($lineItem0, 'Tracking')[0];
        self::assertSame('category-1', $tracking0['TrackingCategoryID']);
        self::assertSame('option-1', $tracking0['TrackingOptionID']);
        self::assertSame('Region', $tracking0['Name']);
        self::assertSame('North', $tracking0['Option']);
    }
}
