<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Support;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Support\Json;

final class JsonTest extends TestCase
{
    public function test_it_encodes_an_array_to_json(): void
    {
        self::assertSame('{"name":"Acme"}', Json::encode(['name' => 'Acme']));
    }

    public function test_it_decodes_a_json_object(): void
    {
        self::assertSame(['name' => 'Acme'], Json::decodeObject('{"name":"Acme"}'));
    }

    public function test_it_throws_when_the_decoded_value_is_not_an_array(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unable to decode JSON response body.');

        Json::decodeObject('true');
    }

    public function test_it_decodes_arbitrary_json_values(): void
    {
        self::assertSame(42, Json::decode('42'));
        self::assertSame(['a' => 1], Json::decode('{"a":1}'));
    }

    public function test_it_extracts_a_typed_list(): void
    {
        $payload = ['Invoices' => [['InvoiceID' => '1'], 'skipme', ['InvoiceID' => '2']]];

        self::assertSame(
            [['InvoiceID' => '1'], ['InvoiceID' => '2']],
            Json::extractList($payload, 'Invoices')
        );
    }

    public function test_it_returns_an_empty_list_for_a_missing_or_non_array_key(): void
    {
        self::assertSame([], Json::extractList(['Invoices' => 'nope'], 'Invoices'));
        self::assertSame([], Json::extractList([], 'Invoices'));
    }

    public function test_it_extracts_the_first_list_item(): void
    {
        self::assertSame(
            ['InvoiceID' => '1'],
            Json::extractFirst(['Invoices' => [['InvoiceID' => '1']]], 'Invoices')
        );
        self::assertNull(Json::extractFirst(['Invoices' => []], 'Invoices'));
    }

    public function test_it_extracts_a_typed_object(): void
    {
        self::assertSame(
            ['Name' => 'Acme', '0' => 'x'],
            Json::extractObject(['Organisation' => ['Name' => 'Acme', 'x']], 'Organisation')
        );
        self::assertSame([], Json::extractObject(['Organisation' => 'nope'], 'Organisation'));
    }

    public function test_ensure_available_passes_when_the_json_extension_is_loaded(): void
    {
        Json::ensureAvailable();

        $this->expectNotToPerformAssertions();
    }
}
