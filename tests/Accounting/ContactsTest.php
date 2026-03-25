<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ContactsTest extends TestCase
{
    public function test_it_builds_a_fluent_contacts_query(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [[
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                    'EmailAddress' => 'hello@acme.test',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $contacts = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->where('Name.Contains(:name)', name: 'Acme')
            ->orderBy('Name')
            ->page(1)
            ->includeArchived()
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Contacts', $request->path);
        self::assertSame('Name ASC', $request->query['order']);
        self::assertSame('Name.Contains("Acme")', $request->query['where']);
        self::assertSame(1, $request->query['page']);
        self::assertSame('true', $request->query['includeArchived']);
        self::assertInstanceOf(Contact::class, $contacts->first());
        self::assertSame('Acme Pty Ltd', $contacts->first()->name);
    }

    public function test_it_can_paginate_contacts(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [],
            ], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->paginate(page: 2, perPage: 100);

        $request = $transport->requests()[0];

        self::assertSame(2, $request->query['page']);
        self::assertSame(100, $request->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(100, $page->perPage);
    }

    public function test_it_can_find_a_contact(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [[
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $contact = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->find('contact-1');

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Contacts/contact-1', $request->path);
        self::assertSame('contact-1', $contact?->id);
    }

    public function test_it_can_create_a_contact(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [[
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                    'EmailAddress' => 'accounts@acme.test',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $contact = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->create()
            ->name('Acme Pty Ltd')
            ->email('accounts@acme.test')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Contacts', $request->path);
        self::assertSame('Acme Pty Ltd', $request->json['Contacts'][0]['Name']);
        self::assertSame('accounts@acme.test', $contact->emailAddress);
    }

    public function test_it_can_update_a_contact(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [[
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Holdings Pty Ltd',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $contact = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->update('contact-1')
            ->name('Acme Holdings Pty Ltd')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Contacts/contact-1', $request->path);
        self::assertSame('Acme Holdings Pty Ltd', $contact->name);
    }

    public function test_loaded_contact_can_be_changed_and_saved_fluently(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Contacts' => [[
                'ContactID' => 'contact-1',
                'Name' => 'Acme Pty Ltd',
                'EmailAddress' => 'hello@acme.test',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Contacts' => [[
                'ContactID' => 'contact-1',
                'Name' => 'Acme Holdings Pty Ltd',
                'EmailAddress' => 'hello@acme.test',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $contact = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->find('contact-1');

        $saved = $contact?->name('Acme Holdings Pty Ltd')->save();

        $request = $transport->requests()[1];

        self::assertSame('/api.xro/2.0/Contacts/contact-1', $request->path);
        self::assertSame('Acme Holdings Pty Ltd', $saved?->name);
    }

    public function test_it_supports_up_to_date_query_modifiers(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->where('Name.Contains(:name)', name: 'Acme')
            ->ids('id-1', 'id-2')
            ->createdByApp()
            ->unitDp(4)
            ->modifiedSince(new DateTimeImmutable('2026-03-25T00:00:00+00:00'))
            ->page(1)
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('id-1,id-2', $request->query['IDs']);
        self::assertSame('true', $request->query['createdByMyApp']);
        self::assertSame(4, $request->query['unitdp']);
        self::assertSame('Wed, 25 Mar 2026 00:00:00 GMT', $request->query['If-Modified-Since']);
    }
}
