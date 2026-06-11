<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Address;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Contact\Phone;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
                    'Addresses' => [[
                        'AddressType' => 'POBOX',
                        'AddressLine1' => 'Level 2',
                        'City' => 'Sydney',
                        'PostalCode' => '2000',
                        'Country' => 'Australia',
                    ]],
                    'Phones' => [[
                        'PhoneType' => 'DEFAULT',
                        'PhoneNumber' => '5551234',
                        'PhoneAreaCode' => '02',
                        'PhoneCountryCode' => '61',
                    ]],
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
        $firstContact = $contacts->first();
        self::assertNotNull($firstContact);
        self::assertSame('Acme Pty Ltd', $firstContact->getName());
        self::assertSame('POBOX', $firstContact->getAddresses()[0]->getAddressType());
        self::assertSame('DEFAULT', $firstContact->getPhones()[0]->getPhoneType());
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
        self::assertSame('contact-1', $contact?->getContactID());
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
            ->setName('Acme Pty Ltd')
            ->setEmailAddress('accounts@acme.test')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Contacts', $request->path);
        $json = $request->json ?? [];
        $firstContact = Json::extractFirst($json, 'Contacts');
        self::assertNotNull($firstContact);
        self::assertSame('Acme Pty Ltd', $firstContact['Name']);
        self::assertSame('accounts@acme.test', $contact->getEmailAddress());
    }

    public function test_it_can_add_addresses_and_phones_to_a_contact(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [[
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                    'Addresses' => [[
                        'AddressType' => 'STREET',
                        'AddressLine1' => '100 George Street',
                        'City' => 'Sydney',
                    ]],
                    'Phones' => [[
                        'PhoneType' => 'DEFAULT',
                        'PhoneNumber' => '5551234',
                    ]],
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $contact = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->create()
            ->setName('Acme Pty Ltd')
            ->using(
                (new Contact())
                    ->setName('Acme Pty Ltd')
                    ->addAddress(
                        (new Address())
                            ->setAddressType('STREET')
                            ->setAddressLine1('100 George Street')
                            ->setCity('Sydney')
                    )
                    ->addPhone(
                        (new Phone())
                            ->setPhoneType('DEFAULT')
                            ->setPhoneNumber('5551234')
                    )
            )
            ->save();

        $request = $transport->requests()[0];

        $json = $request->json ?? [];
        $firstContact = Json::extractFirst($json, 'Contacts');
        self::assertNotNull($firstContact);
        $addresses = Json::extractList($firstContact, 'Addresses');
        self::assertSame('100 George Street', $addresses[0]['AddressLine1'] ?? null);
        $phones = Json::extractList($firstContact, 'Phones');
        self::assertSame('5551234', $phones[0]['PhoneNumber'] ?? null);
        self::assertSame('Sydney', $contact->getAddresses()[0]->getCity());
        self::assertSame('5551234', $contact->getPhones()[0]->getPhoneNumber());
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
            ->setName('Acme Holdings Pty Ltd')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Contacts/contact-1', $request->path);
        self::assertSame('Acme Holdings Pty Ltd', $contact->getName());
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

        $saved = $contact?->setName('Acme Holdings Pty Ltd')->save();

        $request = $transport->requests()[1];

        self::assertSame('/api.xro/2.0/Contacts/contact-1', $request->path);
        self::assertSame('Acme Holdings Pty Ltd', $saved?->getName());
    }

    public function test_it_exposes_contacts_scopes(): void
    {
        $contacts = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->contacts();

        $scopes = $contacts->scopes();

        self::assertSame(['accounting.contacts'], $scopes->broad);
        self::assertSame(['accounting.contacts.read', 'accounting.contacts'], $scopes->granular);
    }

    public function test_it_maps_addresses_and_phones_directly(): void
    {
        $contacts = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->contacts();

        $address = $contacts->mapAddress([
            'AddressType' => 'STREET',
            'AddressLine2' => 'Suite 5',
            'Region' => 'NSW',
        ]);
        $phone = $contacts->mapPhone([
            'PhoneType' => 'MOBILE',
            'PhoneNumber' => '0400000000',
        ]);

        self::assertSame('Suite 5', $address->getAddressLine2());
        self::assertSame('NSW', $address->getRegion());
        self::assertSame('MOBILE', $phone->getPhoneType());
    }

    public function test_payload_fluent_helpers_set_all_name_fields(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [[
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->create()
            ->name('Acme Pty Ltd')
            ->firstName('Ada')
            ->lastName('Lovelace')
            ->email('ada@acme.test')
            ->save();

        $request = $transport->requests()[0];
        $json = $request->json ?? [];
        $firstContact = Json::extractFirst($json, 'Contacts');
        self::assertNotNull($firstContact);
        self::assertSame('Acme Pty Ltd', $firstContact['Name']);
        self::assertSame('Ada', $firstContact['FirstName']);
        self::assertSame('Lovelace', $firstContact['LastName']);
        self::assertSame('ada@acme.test', $firstContact['EmailAddress']);
    }

    public function test_contact_model_setters_serialise_addresses_and_phones(): void
    {
        $contact = (new Contact())
            ->setFirstName('Ada')
            ->setLastName('Lovelace')
            ->setAddresses([
                (new Address())
                    ->setAddressLine2('Suite 5')
                    ->setRegion('NSW'),
            ])
            ->setPhones([
                (new Phone())->setPhoneNumber('0400000000'),
            ]);

        self::assertSame('Ada', $contact->getFirstName());
        self::assertSame('Lovelace', $contact->getLastName());
        self::assertSame('Suite 5', $contact->getAddresses()[0]->getAddressLine2());
        self::assertSame('NSW', $contact->getAddresses()[0]->getRegion());
        self::assertSame('0400000000', $contact->getPhones()[0]->getPhoneNumber());
    }

    public function test_saving_a_contact_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Contact())->save();
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
