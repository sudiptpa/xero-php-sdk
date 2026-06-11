<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Accounting\TaxRate\Component;
use Sujip\Xero\Accounting\TaxRate\TaxRate;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class TaxRatesTest extends TestCase
{
    public function test_it_can_query_and_find_tax_rates(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'TaxRates' => [[
                'Name' => 'GST',
                'TaxType' => 'OUTPUT',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'TaxRates' => [[
                'Name' => 'GST',
                'TaxType' => 'OUTPUT',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $taxRates = $client->accounting()->taxRates()->where('Status == :status', status: 'ACTIVE')->orderBy('Name')->get();
        $taxRate = $client->accounting()->taxRates()->find('OUTPUT');

        self::assertSame('/api.xro/2.0/TaxRates', $transport->requests()[0]->path);
        self::assertSame('Status == "ACTIVE"', $transport->requests()[0]->query['where']);
        self::assertSame('Name ASC', $transport->requests()[0]->query['order']);
        self::assertNotNull($taxRates->first());
        self::assertSame('/api.xro/2.0/TaxRates/OUTPUT', $transport->requests()[1]->path);
        self::assertSame('OUTPUT', $taxRate?->getTaxType());
    }

    public function test_it_can_create_and_update_tax_rates(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'TaxRates' => [[
                'Name' => 'GST',
                'TaxType' => 'OUTPUT',
                'TaxComponents' => [['Name' => 'GST', 'Rate' => 15]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'TaxRates' => [[
                'Name' => 'GST Plus',
                'TaxType' => 'OUTPUT',
                'TaxComponents' => [['Name' => 'GST', 'Rate' => 16]],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->taxRates()->create()
            ->using(
                (new TaxRate())
                    ->setTaxType('OUTPUT')
                    ->setName('GST')
                    ->addTaxComponent(
                        (new Component())
                            ->setName('GST')
                            ->setRate(15)
                    )
            )
            ->idempotencyKey('tax-key')
            ->save();

        $updated = $created->name('GST Plus')->component('GST', 16)->save();

        self::assertSame('/api.xro/2.0/TaxRates', $transport->requests()[0]->path);
        self::assertSame('tax-key', $transport->requests()[0]->headers['Idempotency-Key']);
        $json0 = $transport->requests()[0]->json ?? [];
        $tr0 = Json::extractFirst($json0, 'TaxRates');
        self::assertNotNull($tr0);
        self::assertSame('OUTPUT', $tr0['TaxType']);
        $components = Json::extractList($tr0, 'TaxComponents');
        self::assertSame('GST', $components[0]['Name'] ?? null);
        self::assertSame('/api.xro/2.0/TaxRates', $transport->requests()[1]->path);
        self::assertSame('GST Plus', $updated->getName());
    }

    public function test_it_updates_via_builder_and_exposes_helpers(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'TaxRates' => [[
                'Name' => 'GST Revised',
                'TaxType' => 'OUTPUT',
                'TaxComponents' => [['Name' => 'GST', 'Rate' => 15]],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $taxRates = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()->taxRates();

        $updated = $taxRates->update('OUTPUT')
            ->name('GST Revised')
            ->component('GST', 15)
            ->save();

        self::assertSame('/api.xro/2.0/TaxRates', $transport->requests()[0]->path);
        $tr = Json::extractFirst($transport->requests()[0]->json ?? [], 'TaxRates');
        self::assertNotNull($tr);
        self::assertSame('OUTPUT', $tr['TaxType']);
        self::assertSame('GST Revised', $updated->getName());

        self::assertNotSame([], $taxRates->scopes()->broad);

        $component = $taxRates->mapComponent(['Name' => 'GST', 'Rate' => 15]);
        self::assertSame('GST', $component->getName());

        $model = (new TaxRate())->setTaxComponents([new Component()]);
        self::assertCount(1, $model->getTaxComponents());
    }

    public function test_saving_a_tax_rate_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('without a bound client context');

        (new TaxRate())->setName('GST')->save();
    }
}
