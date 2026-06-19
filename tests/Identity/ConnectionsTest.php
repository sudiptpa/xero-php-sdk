<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Identity;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Identity\Connection;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ConnectionsTest extends TestCase
{
    public function test_it_can_list_connections_without_sending_a_tenant_header(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                [
                    'id' => 'connection-1',
                    'tenantId' => 'tenant-1',
                    'tenantName' => 'Acme Pty Ltd',
                    'tenantType' => 'ORGANISATION',
                    'createdDateUtc' => '2026-03-25T00:00:00',
                    'updatedDateUtc' => '2026-03-25T00:00:00',
                ],
            ], JSON_THROW_ON_ERROR))
        );

        $connections = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-should-not-be-used')
            ->identity()
            ->connections()
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/connections', $request->path);
        self::assertArrayNotHasKey('Xero-Tenant-Id', $request->headers);
        $firstConn = $connections->first();
        self::assertNotNull($firstConn);
        self::assertSame('tenant-1', $firstConn->getTenantId());
    }

    public function test_it_can_filter_connections_by_auth_event_id(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                [
                    'id' => 'connection-1',
                    'authEventId' => 'event-1',
                    'tenantId' => 'tenant-1',
                    'tenantName' => 'Acme Pty Ltd',
                    'tenantType' => 'ORGANISATION',
                    'createdDateUtc' => '2026-03-25T00:00:00',
                    'updatedDateUtc' => '2026-03-25T00:00:00',
                ],
            ], JSON_THROW_ON_ERROR))
        );

        $connections = Xero::withAccessToken('token', $transport)
            ->identity()
            ->connections()
            ->get('event-1');

        $request = $transport->requests()[0];

        self::assertSame('/connections?authEventId=event-1', $request->path . '?' . http_build_query($request->query));
        $firstConn = $connections->first();
        self::assertNotNull($firstConn);
        self::assertSame('event-1', $firstConn->getAuthEventId());
    }

    public function test_it_can_find_a_connection_by_tenant(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                [
                    'id' => 'connection-1',
                    'tenantId' => 'tenant-1',
                    'tenantName' => 'Acme Pty Ltd',
                ],
                [
                    'id' => 'connection-2',
                    'tenantId' => 'tenant-2',
                    'tenantName' => 'Beta Pty Ltd',
                ],
            ], JSON_THROW_ON_ERROR))
        );

        $connection = Xero::withAccessToken('token', $transport)
            ->identity()
            ->connections()
            ->findByTenant('tenant-2');

        self::assertNotNull($connection);
        self::assertSame('connection-2', $connection->getId());
        self::assertSame('Beta Pty Ltd', $connection->getTenantName());
    }

    public function test_it_returns_null_when_no_connection_matches_the_tenant(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                [
                    'id' => 'connection-1',
                    'tenantId' => 'tenant-1',
                ],
            ], JSON_THROW_ON_ERROR))
        );

        $connection = Xero::withAccessToken('token', $transport)
            ->identity()
            ->connections()
            ->findByTenant('tenant-unknown');

        self::assertNull($connection);
    }

    public function test_connection_exposes_all_hydrated_fields(): void
    {
        $connection = (new Connection())
            ->setTenantType('ORGANISATION')
            ->setCreatedDateUtc('2026-03-25T00:00:00')
            ->setUpdatedDateUtc('2026-03-26T00:00:00');

        self::assertSame('ORGANISATION', $connection->getTenantType());
        self::assertSame('2026-03-25T00:00:00', $connection->getCreatedDateUtc());
        self::assertSame('2026-03-26T00:00:00', $connection->getUpdatedDateUtc());
    }

    public function test_disconnect_requires_a_bound_client_context(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cannot disconnect a connection without a bound client context and connection id.');

        (new Connection())->disconnect();
    }

    public function test_it_can_disconnect_a_connection_without_sending_a_tenant_header(): void
    {
        $transport = (new FakeTransport())->push(new Response(204));

        $disconnected = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-should-not-be-used')
            ->identity()
            ->connections()
            ->disconnect('connection-1');

        $request = $transport->requests()[0];

        self::assertTrue($disconnected);
        self::assertSame('/connections/connection-1', $request->path);
        self::assertArrayNotHasKey('Xero-Tenant-Id', $request->headers);
    }

    public function test_loaded_connection_can_disconnect_itself(): void
    {
        $transport = new FakeTransport();
        $transport->push(
            new Response(200, body: json_encode([
                [
                    'id' => 'connection-1',
                    'tenantId' => 'tenant-1',
                    'tenantName' => 'Acme Pty Ltd',
                ],
            ], JSON_THROW_ON_ERROR))
        );
        $transport->push(new Response(204));

        $connection = Xero::withAccessToken('token', $transport)
            ->identity()
            ->connections()
            ->get()
            ->first();

        self::assertNotNull($connection);
        self::assertTrue($connection->disconnect());
    }
}
