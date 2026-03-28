<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\InvoiceReminder\InvoiceReminderSettings;
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
        self::assertInstanceOf(InvoiceReminderSettings::class, $settings);
        self::assertTrue($settings->getEnabled());
        self::assertSame([7, 14], $settings->getDays());
    }
}
