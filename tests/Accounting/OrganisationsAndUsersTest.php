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
                    'Name' => 'Acme Pty Ltd',
                    'LegalName' => 'Acme Holdings Pty Ltd',
                    'ShortCode' => 'ACME',
                    'CountryCode' => 'AU',
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
        self::assertSame('Acme Pty Ltd', $organisation->getName());
        self::assertSame('Acme Holdings Pty Ltd', $organisation->getLegalName());
        self::assertSame('ACME', $organisation->getShortCode());
        self::assertSame('AU', $organisation->getCountryCode());
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
