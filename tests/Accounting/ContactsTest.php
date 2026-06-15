<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Address;
use Sujip\Xero\Accounting\Contact\BatchPaymentDetails;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Contact\ContactPerson;
use Sujip\Xero\Accounting\Contact\Phone;
use Sujip\Xero\Accounting\Contact\SalesTrackingCategory;
use Sujip\Xero\Accounting\Organisation\Bill;
use Sujip\Xero\Accounting\Organisation\PaymentTerm;
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
                    'MergedToContactID' => 'contact-0',
                    'ContactNumber' => 'CUST-001',
                    'AccountNumber' => 'ACC-001',
                    'ContactStatus' => 'ACTIVE',
                    'CompanyNumber' => 'NZ-123456',
                    'ContactPersons' => [[
                        'FirstName' => 'Bruce',
                        'LastName' => 'Banner',
                        'EmailAddress' => 'bruce@acme.test',
                        'IncludeInEmails' => true,
                    ]],
                    'BankAccountDetails' => '12-3456-7890123-00',
                    'TaxNumber' => 'TAX-999',
                    'TaxNumberType' => 'EIN',
                    'AccountsReceivableTaxType' => 'OUTPUT2',
                    'AccountsPayableTaxType' => 'INPUT2',
                    'IsSupplier' => true,
                    'IsCustomer' => true,
                    'SalesDefaultLineAmountType' => 'EXCLUSIVE',
                    'PurchasesDefaultLineAmountType' => 'INCLUSIVE',
                    'DefaultCurrency' => 'NZD',
                    'XeroNetworkKey' => 'network-key-1',
                    'SalesDefaultAccountCode' => '200',
                    'PurchasesDefaultAccountCode' => '400',
                    'SalesTrackingCategories' => [[
                        'TrackingCategoryName' => 'Region',
                        'TrackingOptionName' => 'North',
                    ]],
                    'PurchasesTrackingCategories' => [[
                        'TrackingCategoryName' => 'Department',
                        'TrackingOptionName' => 'Procurement',
                    ]],
                    'TrackingCategoryName' => 'Region',
                    'TrackingCategoryOption' => 'North',
                    'PaymentTerms' => [
                        'Bills' => ['Day' => 15, 'Type' => 'DAYSAFTERBILLMONTH'],
                        'Sales' => ['Day' => 20, 'Type' => 'DAYSAFTERBILLDATE'],
                    ],
                    'UpdatedDateUTC' => '2026-01-02T00:00:00',
                    'ContactGroups' => [[
                        'ContactGroupID' => 'group-1',
                        'Name' => 'VIP',
                        'Status' => 'ACTIVE',
                    ]],
                    'Website' => 'https://acme.test',
                    'BrandingTheme' => [
                        'BrandingThemeID' => 'theme-1',
                        'Name' => 'Default',
                    ],
                    'BatchPayments' => [
                        'BankAccountNumber' => '123-456-1111111',
                        'BankAccountName' => 'ACME Bank',
                        'Details' => 'Hello World',
                        'Code' => 'ABC',
                        'Reference' => 'Foobar',
                    ],
                    'Discount' => 10.5,
                    'Balances' => [
                        'AccountsReceivable' => ['Outstanding' => 100.5, 'Overdue' => 50.25],
                        'AccountsPayable' => ['Outstanding' => 25.5, 'Overdue' => 5.25],
                    ],
                    'Attachments' => [['AttachmentID' => 'attachment-1', 'FileName' => 'contract.pdf']],
                    'HasAttachments' => true,
                    'ValidationErrors' => [['Message' => 'something went wrong']],
                    'HasValidationErrors' => true,
                    'StatusAttributeString' => 'OK',
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
        self::assertNotNull($contact);
        self::assertSame('contact-1', $contact->getContactID());
        self::assertSame('contact-0', $contact->getMergedToContactID());
        self::assertSame('CUST-001', $contact->getContactNumber());
        self::assertSame('ACC-001', $contact->getAccountNumber());
        self::assertSame('ACTIVE', $contact->getContactStatus());
        self::assertSame('NZ-123456', $contact->getCompanyNumber());
        self::assertSame('12-3456-7890123-00', $contact->getBankAccountDetails());
        self::assertSame('TAX-999', $contact->getTaxNumber());
        self::assertSame('EIN', $contact->getTaxNumberType());
        self::assertSame('OUTPUT2', $contact->getAccountsReceivableTaxType());
        self::assertSame('INPUT2', $contact->getAccountsPayableTaxType());
        self::assertTrue($contact->getIsSupplier());
        self::assertTrue($contact->getIsCustomer());
        self::assertSame('EXCLUSIVE', $contact->getSalesDefaultLineAmountType());
        self::assertSame('INCLUSIVE', $contact->getPurchasesDefaultLineAmountType());
        self::assertSame('NZD', $contact->getDefaultCurrency());
        self::assertSame('network-key-1', $contact->getXeroNetworkKey());
        self::assertSame('200', $contact->getSalesDefaultAccountCode());
        self::assertSame('400', $contact->getPurchasesDefaultAccountCode());
        self::assertSame('Region', $contact->getTrackingCategoryName());
        self::assertSame('North', $contact->getTrackingCategoryOption());
        self::assertSame('2026-01-02T00:00:00', $contact->getUpdatedDateUTC());
        self::assertSame('https://acme.test', $contact->getWebsite());
        self::assertSame(10.5, $contact->getDiscount());
        self::assertTrue($contact->getHasAttachments());
        self::assertTrue($contact->getHasValidationErrors());
        self::assertSame('OK', $contact->getStatusAttributeString());

        $contactPersons = $contact->getContactPersons();
        self::assertCount(1, $contactPersons);
        self::assertSame('Bruce', $contactPersons[0]->getFirstName());
        self::assertSame('Banner', $contactPersons[0]->getLastName());
        self::assertSame('bruce@acme.test', $contactPersons[0]->getEmailAddress());
        self::assertTrue($contactPersons[0]->getIncludeInEmails());

        $salesCategories = $contact->getSalesTrackingCategories();
        self::assertCount(1, $salesCategories);
        self::assertSame('Region', $salesCategories[0]->getTrackingCategoryName());
        self::assertSame('North', $salesCategories[0]->getTrackingOptionName());

        $purchasesCategories = $contact->getPurchasesTrackingCategories();
        self::assertCount(1, $purchasesCategories);
        self::assertSame('Department', $purchasesCategories[0]->getTrackingCategoryName());
        self::assertSame('Procurement', $purchasesCategories[0]->getTrackingOptionName());

        $paymentTerms = $contact->getPaymentTerms();
        self::assertNotNull($paymentTerms);
        self::assertNotNull($paymentTerms->getBills());
        self::assertSame(15, $paymentTerms->getBills()->getDay());
        self::assertSame('DAYSAFTERBILLMONTH', $paymentTerms->getBills()->getType());
        self::assertNotNull($paymentTerms->getSales());
        self::assertSame(20, $paymentTerms->getSales()->getDay());
        self::assertSame('DAYSAFTERBILLDATE', $paymentTerms->getSales()->getType());

        $contactGroups = $contact->getContactGroups();
        self::assertCount(1, $contactGroups);
        self::assertSame('group-1', $contactGroups[0]->getContactGroupID());
        self::assertSame('VIP', $contactGroups[0]->getName());
        self::assertSame('ACTIVE', $contactGroups[0]->getStatus());

        $brandingTheme = $contact->getBrandingTheme();
        self::assertNotNull($brandingTheme);
        self::assertSame('theme-1', $brandingTheme->getBrandingThemeID());
        self::assertSame('Default', $brandingTheme->getName());

        $batchPayments = $contact->getBatchPayments();
        self::assertNotNull($batchPayments);
        self::assertSame('123-456-1111111', $batchPayments->getBankAccountNumber());
        self::assertSame('ACME Bank', $batchPayments->getBankAccountName());
        self::assertSame('Hello World', $batchPayments->getDetails());
        self::assertSame('ABC', $batchPayments->getCode());
        self::assertSame('Foobar', $batchPayments->getReference());

        $balances = $contact->getBalances();
        self::assertNotNull($balances);
        self::assertNotNull($balances->getAccountsReceivable());
        self::assertSame(100.5, $balances->getAccountsReceivable()->getOutstanding());
        self::assertSame(50.25, $balances->getAccountsReceivable()->getOverdue());
        self::assertNotNull($balances->getAccountsPayable());
        self::assertSame(25.5, $balances->getAccountsPayable()->getOutstanding());
        self::assertSame(5.25, $balances->getAccountsPayable()->getOverdue());

        $attachments = $contact->getAttachments();
        self::assertCount(1, $attachments);
        self::assertSame('attachment-1', $attachments[0]->getAttachmentID());
        self::assertSame('contract.pdf', $attachments[0]->getFileName());

        $validationErrors = $contact->getValidationErrors();
        self::assertCount(1, $validationErrors);
        self::assertSame('something went wrong', $validationErrors[0]->getMessage());
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
            'AddressLine1' => 'Level 2',
            'AddressLine2' => 'Suite 5',
            'AddressLine3' => 'Building C',
            'AddressLine4' => 'Tech Park',
            'City' => 'Sydney',
            'Region' => 'NSW',
            'PostalCode' => '2000',
            'Country' => 'Australia',
            'AttentionTo' => 'Accounts Team',
        ]);
        $phone = $contacts->mapPhone([
            'PhoneType' => 'MOBILE',
            'PhoneNumber' => '0400000000',
        ]);

        self::assertSame('STREET', $address->getAddressType());
        self::assertSame('Level 2', $address->getAddressLine1());
        self::assertSame('Suite 5', $address->getAddressLine2());
        self::assertSame('Building C', $address->getAddressLine3());
        self::assertSame('Tech Park', $address->getAddressLine4());
        self::assertSame('Sydney', $address->getCity());
        self::assertSame('NSW', $address->getRegion());
        self::assertSame('2000', $address->getPostalCode());
        self::assertSame('Australia', $address->getCountry());
        self::assertSame('Accounts Team', $address->getAttentionTo());
        self::assertSame('MOBILE', $phone->getPhoneType());
        self::assertSame([
            'AddressType' => 'STREET',
            'AddressLine1' => 'Level 2',
            'AddressLine2' => 'Suite 5',
            'AddressLine3' => 'Building C',
            'AddressLine4' => 'Tech Park',
            'City' => 'Sydney',
            'Region' => 'NSW',
            'PostalCode' => '2000',
            'Country' => 'Australia',
            'AttentionTo' => 'Accounts Team',
        ], $address->toRequest());
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

    public function test_it_serialises_contact_persons_tracking_categories_batch_payments_and_payment_terms(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Contacts' => [['ContactID' => 'contact-1', 'Name' => 'Acme Pty Ltd']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->create()
            ->using(
                (new Contact())
                    ->setName('Acme Pty Ltd')
                    ->addContactPerson(
                        (new ContactPerson())
                            ->setFirstName('Bruce')
                            ->setLastName('Banner')
                            ->setEmailAddress('bruce@acme.test')
                            ->setIncludeInEmails(true)
                    )
                    ->addSalesTrackingCategory(
                        (new SalesTrackingCategory())
                            ->setTrackingCategoryName('Region')
                            ->setTrackingOptionName('North')
                    )
                    ->addPurchasesTrackingCategory(
                        (new SalesTrackingCategory())
                            ->setTrackingCategoryName('Department')
                            ->setTrackingOptionName('Procurement')
                    )
                    ->setBatchPayments(
                        (new BatchPaymentDetails())
                            ->setBankAccountNumber('123-456-1111111')
                            ->setBankAccountName('ACME Bank')
                            ->setDetails('Hello World')
                            ->setCode('ABC')
                            ->setReference('Foobar')
                    )
                    ->setPaymentTerms(
                        (new PaymentTerm())
                            ->setBills((new Bill())->setDay(15)->setType('DAYSAFTERBILLMONTH'))
                            ->setSales((new Bill())->setDay(20)->setType('DAYSAFTERBILLDATE'))
                    )
            )
            ->save();

        $request = $transport->requests()[0];
        $json = $request->json ?? [];
        $firstContact = Json::extractFirst($json, 'Contacts');
        self::assertNotNull($firstContact);

        $contactPersons = Json::extractList($firstContact, 'ContactPersons');
        self::assertSame('Bruce', $contactPersons[0]['FirstName'] ?? null);
        self::assertSame('Banner', $contactPersons[0]['LastName'] ?? null);
        self::assertSame('bruce@acme.test', $contactPersons[0]['EmailAddress'] ?? null);
        self::assertTrue($contactPersons[0]['IncludeInEmails'] ?? null);

        $salesCategories = Json::extractList($firstContact, 'SalesTrackingCategories');
        self::assertSame('Region', $salesCategories[0]['TrackingCategoryName'] ?? null);
        self::assertSame('North', $salesCategories[0]['TrackingOptionName'] ?? null);

        $purchasesCategories = Json::extractList($firstContact, 'PurchasesTrackingCategories');
        self::assertSame('Department', $purchasesCategories[0]['TrackingCategoryName'] ?? null);
        self::assertSame('Procurement', $purchasesCategories[0]['TrackingOptionName'] ?? null);

        $batchPayments = Json::extractObject($firstContact, 'BatchPayments');
        self::assertSame('123-456-1111111', $batchPayments['BankAccountNumber'] ?? null);
        self::assertSame('ACME Bank', $batchPayments['BankAccountName'] ?? null);
        self::assertSame('Hello World', $batchPayments['Details'] ?? null);
        self::assertSame('ABC', $batchPayments['Code'] ?? null);
        self::assertSame('Foobar', $batchPayments['Reference'] ?? null);

        $paymentTerms = Json::extractObject($firstContact, 'PaymentTerms');
        $bills = Json::extractObject($paymentTerms, 'Bills');
        self::assertSame(15, $bills['Day'] ?? null);
        self::assertSame('DAYSAFTERBILLMONTH', $bills['Type'] ?? null);
        $sales = Json::extractObject($paymentTerms, 'Sales');
        self::assertSame(20, $sales['Day'] ?? null);
        self::assertSame('DAYSAFTERBILLDATE', $sales['Type'] ?? null);
    }

    public function test_it_fetches_contact_cis_settings(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'CISSettings' => [['CISEnabled' => true, 'Rate' => 20]],
        ], JSON_THROW_ON_ERROR)));

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->cisSettings('contact-1');

        self::assertSame('/api.xro/2.0/Contacts/contact-1/CISSettings', $transport->requests()[0]->path);
        $setting = $settings->first();
        self::assertNotNull($setting);
        self::assertTrue($setting->cisEnabled);
        self::assertSame(20.0, $setting->rate);
    }

    public function test_contact_cis_settings_accepts_the_singular_wrapper(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'CISSetting' => [['CISEnabled' => false]],
        ], JSON_THROW_ON_ERROR)));

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->cisSettings('contact-1');

        $setting = $settings->first();
        self::assertNotNull($setting);
        self::assertFalse($setting->cisEnabled);
        self::assertNull($setting->rate);
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
