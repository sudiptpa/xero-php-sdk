<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\CreditNote\CreditNote;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
        $firstCn = $creditNotes->first();
        self::assertNotNull($firstCn);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1', $transport->requests()[1]->path);
        self::assertSame('credit-1', $creditNote?->getCreditNoteID());
        self::assertSame('contact-1', $firstCn->getContact()?->getContactID());
        self::assertSame('Adjustment', $firstCn->getLineItems()[0]->getDescription());
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
        $json0 = $transport->requests()[0]->json ?? [];
        $cn0 = Json::extractFirst($json0, 'CreditNotes');
        self::assertNotNull($cn0);
        self::assertSame('ACCRECCREDIT', $cn0['Type']);
        self::assertSame('contact-1', Json::extractObject($cn0, 'Contact')['ContactID']);
        $json1 = $transport->requests()[1]->json ?? [];
        $cn1 = Json::extractFirst($json1, 'CreditNotes');
        self::assertNotNull($cn1);
        self::assertSame('/api.xro/2.0/CreditNotes', $transport->requests()[1]->path);
        self::assertSame('credit-1', $cn1['CreditNoteID']);
        self::assertSame('CN-1002', $updated->getReference());
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.transactions.read', 'accounting.transactions'], $scopes->granular);
    }

    public function test_it_can_paginate_credit_notes(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['CreditNotes' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->paginate(page: 2, perPage: 25);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(25, $page->perPage);
    }

    public function test_payload_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'CreditNotes' => [['CreditNoteID' => 'credit-1', 'Type' => 'ACCRECCREDIT']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->update('credit-1')
            ->type('accreccredit')
            ->contact('contact-1')
            ->reference('CN-3001')
            ->lineItem('Adjustment', 1, 50)
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $cn = Json::extractFirst($json, 'CreditNotes');
        self::assertNotNull($cn);
        self::assertSame('credit-1', $cn['CreditNoteID']);
        self::assertSame('ACCRECCREDIT', $cn['Type']);
        self::assertSame('contact-1', Json::extractObject($cn, 'Contact')['ContactID']);
        self::assertSame('CN-3001', $cn['Reference']);
        $lineItems = Json::extractList($cn, 'LineItems');
        self::assertSame('Adjustment', $lineItems[0]['Description'] ?? null);
    }

    public function test_model_fluent_helpers_set_fields(): void
    {
        $creditNote = (new CreditNote())
            ->type('accreccredit')
            ->contact('contact-9')
            ->lineItem('Refund', 1, 75)
            ->setTotal(75)
            ->setLineItems([
                (new LineItem())->setDescription('Replaced'),
            ]);

        self::assertSame('ACCRECCREDIT', $creditNote->getType());
        self::assertSame('contact-9', $creditNote->getContact()?->getContactID());
        self::assertSame(75, $creditNote->getTotal());
        self::assertSame('Replaced', $creditNote->getLineItems()[0]->getDescription());
    }

    public function test_bound_model_exposes_attachments_history_and_pdf(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [['CreditNoteID' => 'credit-1']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-1.4 credit'));

        $creditNote = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->find('credit-1');

        self::assertNotNull($creditNote);
        $creditNote->attachments();
        $creditNote->history();
        $pdf = $creditNote->pdf();

        self::assertSame('%PDF-1.4 credit', $pdf);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/pdf', $transport->requests()[1]->path);
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new CreditNote())->save();
    }

    public function test_attachments_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new CreditNote())->attachments();
    }

    public function test_history_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new CreditNote())->history();
    }

    public function test_pdf_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new CreditNote())->pdf();
    }
}
