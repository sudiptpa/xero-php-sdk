<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Organisation\Organisation;
use Sujip\Xero\Accounting\User\User;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class OrganisationsAndUsersTest extends TestCase
{
    public function test_it_can_list_organisation_details(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Organisations' => [[
                    'OrganisationID' => 'org-123',
                    'APIKey' => 'api-key-456',
                    'Name' => 'Acme Pty Ltd',
                    'LegalName' => 'Acme Holdings Pty Ltd',
                    'PaysTax' => true,
                    'Version' => 'AU',
                    'OrganisationType' => 'COMPANY',
                    'BaseCurrency' => 'AUD',
                    'CountryCode' => 'AU',
                    'IsDemoCompany' => false,
                    'OrganisationStatus' => 'ACTIVE',
                    'RegistrationNumber' => 'REG-123',
                    'EmployerIdentificationNumber' => 'EIN-123',
                    'TaxNumber' => 'TAX-123',
                    'FinancialYearEndDay' => 30,
                    'FinancialYearEndMonth' => 6,
                    'SalesTaxBasis' => 'ACCRUALS',
                    'SalesTaxPeriod' => 'QUARTERLY1',
                    'DefaultSalesTax' => 'Tax Exclusive',
                    'DefaultPurchasesTax' => 'Tax Inclusive',
                    'PeriodLockDate' => '2025-12-31T00:00:00',
                    'EndOfYearLockDate' => '2025-12-31T00:00:00',
                    'CreatedDateUTC' => '2020-01-01T00:00:00',
                    'Timezone' => 'AUSEASTERNSTANDARDTIME',
                    'OrganisationEntityType' => 'COMPANY',
                    'Class' => 'PREMIUM',
                    'Edition' => 'BUSINESS',
                    'LineOfBusiness' => 'Retail',
                    'ShortCode' => 'ACME',
                    'Addresses' => [[
                        'AddressType' => 'STREET',
                        'AddressLine1' => '123 Main St',
                        'City' => 'Sydney',
                        'Region' => 'NSW',
                        'PostalCode' => '2000',
                        'Country' => 'Australia',
                        'AttentionTo' => 'Bruce Banner',
                    ]],
                    'Phones' => [[
                        'PhoneType' => 'DEFAULT',
                        'PhoneNumber' => '5555555',
                        'PhoneAreaCode' => '02',
                        'PhoneCountryCode' => '61',
                    ]],
                    'ExternalLinks' => [[
                        'LinkType' => 'Website',
                        'Url' => 'https://acme.test',
                        'Description' => 'Acme website',
                    ]],
                    'PaymentTerms' => [
                        'Bills' => ['Day' => 15, 'Type' => 'DAYSAFTERBILLMONTH'],
                        'Sales' => ['Day' => 20, 'Type' => 'DAYSAFTERBILLDATE'],
                    ],
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $organisation = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->organisations()
            ->current();

        self::assertSame('/api.xro/2.0/Organisation', $transport->requests()[0]->path);
        self::assertInstanceOf(Organisation::class, $organisation);
        self::assertSame('org-123', $organisation->getOrganisationID());
        self::assertSame('api-key-456', $organisation->getApiKey());
        self::assertSame('Acme Pty Ltd', $organisation->getName());
        self::assertSame('Acme Holdings Pty Ltd', $organisation->getLegalName());
        self::assertTrue($organisation->getPaysTax());
        self::assertSame('AU', $organisation->getVersion());
        self::assertSame('COMPANY', $organisation->getOrganisationType());
        self::assertSame('AUD', $organisation->getBaseCurrency());
        self::assertSame('AU', $organisation->getCountryCode());
        self::assertFalse($organisation->getIsDemoCompany());
        self::assertSame('ACTIVE', $organisation->getOrganisationStatus());
        self::assertSame('REG-123', $organisation->getRegistrationNumber());
        self::assertSame('EIN-123', $organisation->getEmployerIdentificationNumber());
        self::assertSame('TAX-123', $organisation->getTaxNumber());
        self::assertSame(30, $organisation->getFinancialYearEndDay());
        self::assertSame(6, $organisation->getFinancialYearEndMonth());
        self::assertSame('ACCRUALS', $organisation->getSalesTaxBasis());
        self::assertSame('QUARTERLY1', $organisation->getSalesTaxPeriod());
        self::assertSame('Tax Exclusive', $organisation->getDefaultSalesTax());
        self::assertSame('Tax Inclusive', $organisation->getDefaultPurchasesTax());
        self::assertSame('2025-12-31T00:00:00', $organisation->getPeriodLockDate());
        self::assertSame('2025-12-31T00:00:00', $organisation->getEndOfYearLockDate());
        self::assertSame('2020-01-01T00:00:00', $organisation->getCreatedDateUTC());
        self::assertSame('AUSEASTERNSTANDARDTIME', $organisation->getTimezone());
        self::assertSame('COMPANY', $organisation->getOrganisationEntityType());
        self::assertSame('PREMIUM', $organisation->getClass());
        self::assertSame('BUSINESS', $organisation->getEdition());
        self::assertSame('Retail', $organisation->getLineOfBusiness());
        self::assertSame('ACME', $organisation->getShortCode());

        $addresses = $organisation->getAddresses();
        self::assertCount(1, $addresses);
        self::assertSame('STREET', $addresses[0]->getAddressType());
        self::assertSame('123 Main St', $addresses[0]->getAddressLine1());
        self::assertSame('Sydney', $addresses[0]->getCity());
        self::assertSame('NSW', $addresses[0]->getRegion());
        self::assertSame('2000', $addresses[0]->getPostalCode());
        self::assertSame('Australia', $addresses[0]->getCountry());
        self::assertSame('Bruce Banner', $addresses[0]->getAttentionTo());

        $phones = $organisation->getPhones();
        self::assertCount(1, $phones);
        self::assertSame('DEFAULT', $phones[0]->getPhoneType());
        self::assertSame('5555555', $phones[0]->getPhoneNumber());
        self::assertSame('02', $phones[0]->getPhoneAreaCode());
        self::assertSame('61', $phones[0]->getPhoneCountryCode());

        $externalLinks = $organisation->getExternalLinks();
        self::assertCount(1, $externalLinks);
        self::assertSame('Website', $externalLinks[0]->getLinkType());
        self::assertSame('https://acme.test', $externalLinks[0]->getUrl());
        self::assertSame('Acme website', $externalLinks[0]->getDescription());

        $paymentTerms = $organisation->getPaymentTerms();
        self::assertNotNull($paymentTerms);
        self::assertNotNull($paymentTerms->getBills());
        self::assertSame(15, $paymentTerms->getBills()->getDay());
        self::assertSame('DAYSAFTERBILLMONTH', $paymentTerms->getBills()->getType());
        self::assertNotNull($paymentTerms->getSales());
        self::assertSame(20, $paymentTerms->getSales()->getDay());
        self::assertSame('DAYSAFTERBILLDATE', $paymentTerms->getSales()->getType());
    }

    public function test_it_can_query_users(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Users' => [[
                    'UserID' => 'user-1',
                    'FirstName' => 'Bruce',
                    'LastName' => 'Banner',
                    'EmailAddress' => 'bruce@example.test',
                    'IsSubscriber' => true,
                    'UpdatedDateUTC' => '2026-03-25T00:00:00',
                    'OrganisationRole' => 'STANDARD',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $users = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->users()
            ->modifiedSince(new DateTimeImmutable('2026-03-25T00:00:00+00:00'))
            ->where('IsSubscriber == :sub', sub: true)
            ->orderBy('LastName')
            ->get();

        self::assertSame('/api.xro/2.0/Users', $transport->requests()[0]->path);
        self::assertSame('IsSubscriber == true', $transport->requests()[0]->query['where']);
        self::assertSame('LastName ASC', $transport->requests()[0]->query['order']);
        self::assertSame('Wed, 25 Mar 2026 00:00:00 GMT', $transport->requests()[0]->query['If-Modified-Since']);
        self::assertInstanceOf(User::class, $users->first());
        self::assertSame('bruce@example.test', $users->first()->getEmailAddress());
        self::assertSame('user-1', $users->first()->getUserID());
        self::assertSame('Bruce', $users->first()->getFirstName());
        self::assertSame('Banner', $users->first()->getLastName());
        self::assertTrue($users->first()->getIsSubscriber());
        self::assertSame('2026-03-25T00:00:00', $users->first()->getUpdatedDateUTC());
        self::assertSame('STANDARD', $users->first()->getOrganisationRole());
    }

    public function test_it_can_find_a_user(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Users' => [['UserID' => 'user-1', 'EmailAddress' => 'test@email.com', 'FirstName' => 'Test']],
        ], JSON_THROW_ON_ERROR)));

        $user = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->users()
            ->find('user-1');

        self::assertSame('/api.xro/2.0/Users/user-1', $transport->requests()[0]->path);
        self::assertNotNull($user);
        self::assertSame('test@email.com', $user->getEmailAddress());
    }

    public function test_find_returns_null_when_user_is_missing(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $user = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->users()
            ->find('missing');

        self::assertNull($user);
    }

    public function test_it_lists_organisation_actions(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Actions' => [
                ['Name' => 'CreateApprovedInvoice', 'Status' => 'ALLOWED'],
                ['Name' => 'UseMulticurrency', 'Status' => 'NOT-ALLOWED'],
            ],
        ], JSON_THROW_ON_ERROR)));

        $actions = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->organisations()
            ->actions();

        self::assertSame('/api.xro/2.0/Organisation/Actions', $transport->requests()[0]->path);
        self::assertCount(2, $actions);
        $first = $actions->first();
        self::assertNotNull($first);
        self::assertSame('CreateApprovedInvoice', $first->name);
        self::assertTrue($first->isAllowed());
        self::assertFalse($actions->all()[1]->isAllowed());
    }

    public function test_it_fetches_organisation_cis_settings(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'CISSettings' => [['CISContractorEnabled' => true, 'CISSubContractorEnabled' => false, 'Rate' => 10]],
        ], JSON_THROW_ON_ERROR)));

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->organisations()
            ->cisSettings('org-1');

        self::assertSame('/api.xro/2.0/Organisation/org-1/CISSettings', $transport->requests()[0]->path);
        $setting = $settings->first();
        self::assertNotNull($setting);
        self::assertTrue($setting->cisContractorEnabled);
        self::assertFalse($setting->cisSubContractorEnabled);
        self::assertSame(10.0, $setting->rate);
    }

    public function test_organisations_and_users_expose_required_scopes(): void
    {
        $accounting = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting();

        self::assertNotSame([], $accounting->organisations()->scopes()->broad);
        self::assertNotSame([], $accounting->users()->scopes()->broad);
    }
}
