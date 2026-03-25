<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Accounting;
use Sujip\Xero\AppStore\AppStore;
use Sujip\Xero\Assets\Assets;
use Sujip\Xero\Auth\Token;
use Sujip\Xero\Client;
use Sujip\Xero\Context;
use Sujip\Xero\Files\Files;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Finance\Finance;
use Sujip\Xero\Identity\Identity;
use Sujip\Xero\Xero;
use Sujip\Xero\Payroll\Payroll;
use Sujip\Xero\Projects\Projects;

final class ClientTest extends TestCase
{
    public function test_it_creates_a_tenant_aware_client(): void
    {
        $client = Xero::withAccessToken('token')
            ->tenant('tenant-123');

        self::assertInstanceOf(Client::class, $client);
        self::assertSame('tenant-123', $client->context()->tenantId);
    }

    public function test_it_can_swap_transport(): void
    {
        $transport = new FakeTransport();
        $client = Xero::withAccessToken('token')->withTransport($transport);

        self::assertInstanceOf(Client::class, $client);
    }

    public function test_context_exposes_auth_headers(): void
    {
        $headers = Context::make('token', 'tenant-123')->authHeaders();

        self::assertSame('Bearer token', $headers['Authorization']);
        self::assertSame('application/json', $headers['Accept']);
        self::assertSame('tenant-123', Context::make('token', 'tenant-123')->tenantHeaders()['Xero-Tenant-Id']);
    }

    public function test_it_exposes_domain_roots(): void
    {
        $client = Xero::withAccessToken('token');

        self::assertInstanceOf(Accounting::class, $client->accounting());
        self::assertInstanceOf(Assets::class, $client->assets());
        self::assertInstanceOf(Files::class, $client->files());
        self::assertInstanceOf(Projects::class, $client->projects());
        self::assertInstanceOf(Payroll::class, $client->payroll());
        self::assertInstanceOf(Identity::class, $client->identity());
        self::assertInstanceOf(Finance::class, $client->finance());
        self::assertInstanceOf(AppStore::class, $client->appStore());
    }

    public function test_it_can_swap_to_native_transport(): void
    {
        $client = Xero::withAccessToken('token')->usingNativeTransport();

        self::assertInstanceOf(Client::class, $client);
    }

    public function test_it_can_create_a_client_from_token_object(): void
    {
        $client = Xero::withToken(new Token('token-value'))->tenant('tenant-123');

        self::assertSame('token-value', $client->context()->accessToken);
        self::assertSame('tenant-123', $client->context()->tenantId);
    }
}
