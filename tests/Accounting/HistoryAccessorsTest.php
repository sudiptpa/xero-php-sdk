<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class HistoryAccessorsTest extends TestCase
{
    public function test_resources_expose_history_at_their_spec_paths(): void
    {
        $transport = new FakeTransport();

        $expectations = [
            ['contacts', '/api.xro/2.0/Contacts/id-1/History'],
            ['bankTransfers', '/api.xro/2.0/BankTransfers/id-1/History'],
            ['expenseClaims', '/api.xro/2.0/ExpenseClaims/id-1/History'],
            ['quotes', '/api.xro/2.0/Quotes/id-1/History'],
            ['overpayments', '/api.xro/2.0/Overpayments/id-1/History'],
            ['prepayments', '/api.xro/2.0/Prepayments/id-1/History'],
            ['repeatingInvoices', '/api.xro/2.0/RepeatingInvoices/id-1/History'],
        ];

        for ($i = 0; $i < count($expectations); $i++) {
            $transport->push(new Response(200, body: json_encode([
                'HistoryRecords' => [['Details' => 'Created', 'User' => 'System', 'DateUTC' => '/Date(1573755038314)/']],
            ], JSON_THROW_ON_ERROR)));
        }

        $accounting = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting();

        foreach ($expectations as $index => [$method, $path]) {
            $records = $accounting->{$method}()->history('id-1')->get();

            self::assertSame($path, $transport->requests()[$index]->path);
            self::assertSame('Created', $records->first()?->details);
        }
    }

    public function test_a_history_record_can_be_created_against_a_contact(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'HistoryRecords' => [['Details' => 'Note added', 'User' => 'System', 'DateUTC' => '/Date(1573755038314)/']],
        ], JSON_THROW_ON_ERROR)));

        $record = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->history('contact-1')
            ->record('Note added');

        $request = $transport->requests()[0];
        self::assertSame('PUT', $request->method);
        self::assertSame('/api.xro/2.0/Contacts/contact-1/History', $request->path);
        self::assertSame(['HistoryRecords' => [['Details' => 'Note added']]], $request->json);
        self::assertSame('Note added', $record->details);
    }
}
