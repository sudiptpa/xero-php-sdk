<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class InvoiceRemindersTest extends TestCase
{
    public function test_it_can_fetch_invoice_reminder_settings(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'InvoiceReminders' => [
                'Enabled' => true,
                'Days' => [7, 14],
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $settings = $client->accounting()->invoiceReminders()->settings();

        self::assertSame('/api.xro/2.0/InvoiceReminders/Settings', $transport->requests()[0]->path);
        self::assertTrue($settings->getEnabled());
        self::assertSame([7, 14], $settings->getDays());
    }

    public function test_it_reads_settings_from_the_invoice_reminder_settings_key(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'InvoiceReminderSettings' => [
                'Enabled' => false,
                'Days' => [30],
            ],
        ], JSON_THROW_ON_ERROR)));

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoiceReminders()
            ->settings();

        self::assertFalse($settings->getEnabled());
        self::assertSame([30], $settings->getDays());
    }

    public function test_it_exposes_required_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->invoiceReminders()
            ->scopes();

        self::assertNotSame([], $scopes->broad);
        self::assertNotSame([], $scopes->granular);
    }
}
