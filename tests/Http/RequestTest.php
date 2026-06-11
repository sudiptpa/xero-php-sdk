<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Http;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\Request;

final class RequestTest extends TestCase
{
    public function test_it_builds_a_url_from_base_uri_and_path(): void
    {
        $request = (new Request('GET', '/Invoices'))->withBaseUri('https://api.xero.com/');

        self::assertSame('https://api.xero.com/Invoices', $request->url());
    }

    public function test_it_appends_the_query_string(): void
    {
        $request = new Request('GET', '/Invoices', query: ['page' => 2, 'where' => 'Type=="ACCREC"']);

        self::assertSame('/Invoices?page=2&where=Type%3D%3D%22ACCREC%22', $request->url());
    }

    public function test_it_uses_the_path_alone_without_a_base_uri(): void
    {
        self::assertSame('/Invoices', (new Request('GET', '/Invoices'))->url());
    }

    public function test_it_merges_headers_with_existing_headers_taking_precedence(): void
    {
        $request = (new Request('GET', '/Invoices', ['Accept' => 'application/pdf']))
            ->mergeHeaders(['Accept' => 'application/json', 'X-Extra' => '1']);

        self::assertSame('application/pdf', $request->headers['Accept']);
        self::assertSame('1', $request->headers['X-Extra']);
    }

    public function test_it_can_drop_the_tenant_header(): void
    {
        $request = new Request('GET', '/connections');

        self::assertTrue($request->includeTenantHeader);
        self::assertFalse($request->withoutTenantHeader()->includeTenantHeader);
    }
}
