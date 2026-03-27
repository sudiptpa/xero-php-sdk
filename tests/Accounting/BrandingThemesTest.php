<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\BrandingTheme\BrandingTheme;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class BrandingThemesTest extends TestCase
{
    public function test_it_can_list_and_find_branding_themes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BrandingThemes' => [[
                'BrandingThemeID' => 'branding-1',
                'Name' => 'Standard',
                'SortOrder' => 1,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BrandingThemes' => [[
                'BrandingThemeID' => 'branding-1',
                'Name' => 'Standard',
                'SortOrder' => 1,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $themes = $client->accounting()->brandingThemes()->get();
        $theme = $client->accounting()->brandingThemes()->find('branding-1');

        self::assertSame('/api.xro/2.0/BrandingThemes', $transport->requests()[0]->path);
        self::assertInstanceOf(BrandingTheme::class, $themes->first());
        self::assertSame('/api.xro/2.0/BrandingThemes/branding-1', $transport->requests()[1]->path);
        self::assertSame('branding-1', $theme?->getBrandingThemeID());
    }
}
