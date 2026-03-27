<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\CreditNote\CreditNote;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class CreditNotesTest extends TestCase
{
    public function test_it_can_query_and_find_credit_notes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [[
                'CreditNoteID' => 'credit-1',
                'Type' => 'ACCRECCREDIT',
                'Status' => 'AUTHORISED',
                'Reference' => 'CN-1001',
                'Contact' => [
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                ],
                'LineItems' => [[
                    'Description' => 'Adjustment',
                    'Quantity' => 1,
                    'UnitAmount' => 50,
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [[
                'CreditNoteID' => 'credit-1',
                'Type' => 'ACCRECCREDIT',
                'Status' => 'AUTHORISED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $creditNotes = $client->accounting()->creditNotes()->where('Status == :status', status: 'AUTHORISED')->get();
        $creditNote = $client->accounting()->creditNotes()->find('credit-1');

        self::assertSame('/api.xro/2.0/CreditNotes', $transport->requests()[0]->path);
        self::assertSame('Status == "AUTHORISED"', $transport->requests()[0]->query['where']);
        self::assertInstanceOf(CreditNote::class, $creditNotes->first());
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1', $transport->requests()[1]->path);
        self::assertSame('credit-1', $creditNote?->getCreditNoteID());
        self::assertSame('contact-1', $creditNotes->first()->getContact()?->getContactID());
        self::assertSame('Adjustment', $creditNotes->first()->getLineItems()[0]->getDescription());
    }

    public function test_it_can_create_and_update_credit_notes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [[
                'CreditNoteID' => 'credit-1',
                'Type' => 'ACCRECCREDIT',
                'Reference' => 'CN-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [[
                'CreditNoteID' => 'credit-1',
                'Type' => 'ACCRECCREDIT',
                'Reference' => 'CN-1002',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->creditNotes()->create()
            ->using(
                (new CreditNote())
                    ->setType('ACCRECCREDIT')
                    ->setContact(
                        (new Contact())
                            ->setContactID('contact-1')
                    )
                    ->setReference('CN-1001')
                    ->addLineItem(
                        (new LineItem())
                            ->setDescription('Adjustment')
                            ->setQuantity(1)
                            ->setUnitAmount(50)
                    )
            )
            ->save();

        $updated = $created->reference('CN-1002')->save();

        self::assertSame('/api.xro/2.0/CreditNotes', $transport->requests()[0]->path);
        self::assertSame('ACCRECCREDIT', $transport->requests()[0]->json['CreditNotes'][0]['Type']);
        self::assertSame('contact-1', $transport->requests()[0]->json['CreditNotes'][0]['Contact']['ContactID']);
        self::assertSame('/api.xro/2.0/CreditNotes', $transport->requests()[1]->path);
        self::assertSame('credit-1', $transport->requests()[1]->json['CreditNotes'][0]['CreditNoteID']);
        self::assertSame('CN-1002', $updated->getReference());
    }
}
