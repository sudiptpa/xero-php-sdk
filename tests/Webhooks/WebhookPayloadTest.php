<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Webhooks;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Webhooks\WebhookPayload;

final class WebhookPayloadTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function samplePayload(): array
    {
        return [
            'firstEventSequence' => 1,
            'lastEventSequence' => 2,
            'entropy' => 'abc123',
            'events' => [
                [
                    'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Invoices/invoice-1',
                    'resourceId' => 'invoice-1',
                    'eventCategory' => 'INVOICE',
                    'eventType' => 'CREATE',
                    'eventDateUtc' => '2026-03-25T10:30:00',
                    'tenantId' => 'tenant-1',
                    'tenantType' => 'ORGANISATION',
                    'data' => ['key' => 'value'],
                ],
                [
                    'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Contacts/contact-1',
                    'resourceId' => 'contact-1',
                    'eventCategory' => 'CONTACT',
                    'eventType' => 'UPDATE',
                    'eventDateUtc' => '2026-03-25T11:00:00',
                ],
            ],
        ];
    }

    public function test_it_exposes_sequence_and_entropy_metadata(): void
    {
        $payload = (new WebhookPayload())->fill($this->samplePayload());

        self::assertSame(1, $payload->getFirstEventSequence());
        self::assertSame(2, $payload->getLastEventSequence());
        self::assertSame('abc123', $payload->getEntropy());
        self::assertTrue($payload->hasEvents());
        self::assertFalse($payload->isEmpty());
        self::assertSame(2, $payload->count());
        self::assertSame(2, $payload->getEvents()->count());
    }

    public function test_it_aggregates_categories_types_ids_and_paths(): void
    {
        $payload = (new WebhookPayload())->fill($this->samplePayload());

        self::assertSame(['INVOICE', 'CONTACT'], $payload->categories());
        self::assertSame(['CREATE', 'UPDATE'], $payload->eventTypes());
        self::assertSame(['invoice-1', 'contact-1'], $payload->resourceIds());
        self::assertSame(
            ['/api.xro/2.0/Invoices/invoice-1', '/api.xro/2.0/Contacts/contact-1'],
            $payload->paths()
        );
    }

    public function test_it_filters_and_matches_events_by_category(): void
    {
        $payload = (new WebhookPayload())->fill($this->samplePayload());

        self::assertTrue($payload->contains('INVOICE'));
        self::assertTrue($payload->has('CONTACT', 'UPDATE'));
        self::assertFalse($payload->has('INVOICE', 'DELETE'));

        $invoices = $payload->only('INVOICE');
        self::assertSame(1, $invoices->count());

        $first = $payload->first();
        $last = $payload->last();
        self::assertNotNull($first);
        self::assertNotNull($last);
        self::assertSame('invoice-1', $first->getResourceId());
        self::assertSame('contact-1', $last->getResourceId());
    }

    public function test_event_helpers_handle_missing_url_and_date(): void
    {
        $payload = (new WebhookPayload())->fill([
            'events' => [['eventCategory' => 'INVOICE', 'eventType' => 'CREATE']],
        ]);

        $event = $payload->first();
        self::assertNotNull($event);
        self::assertNull($event->occurredAt());
        self::assertNull($event->path());
        self::assertNull($event->resourceName());
    }

    public function test_resource_name_returns_last_segment_when_not_the_id(): void
    {
        $payload = (new WebhookPayload())->fill([
            'events' => [[
                'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Organisation',
                'eventCategory' => 'ORGANISATION',
                'eventType' => 'UPDATE',
            ]],
        ]);

        $event = $payload->first();
        self::assertNotNull($event);
        self::assertSame('Organisation', $event->resourceName());
    }

    public function test_resource_name_is_null_for_a_root_path(): void
    {
        $payload = (new WebhookPayload())->fill([
            'events' => [[
                'resourceUrl' => 'https://api.xero.com/',
                'eventCategory' => 'INVOICE',
                'eventType' => 'CREATE',
            ]],
        ]);

        $event = $payload->first();
        self::assertNotNull($event);
        self::assertNull($event->resourceName());
    }

    public function test_it_reports_an_empty_payload(): void
    {
        $payload = (new WebhookPayload())->fill(['events' => []]);

        self::assertFalse($payload->hasEvents());
        self::assertTrue($payload->isEmpty());
        self::assertSame(0, $payload->count());
        self::assertNull($payload->first());
        self::assertNull($payload->last());
        self::assertSame([], $payload->categories());
    }

    public function test_event_exposes_tenant_and_helper_accessors(): void
    {
        $payload = (new WebhookPayload())->fill($this->samplePayload());

        $event = $payload->first();
        self::assertNotNull($event);

        self::assertSame('tenant-1', $event->getTenantId());
        self::assertSame('ORGANISATION', $event->getTenantType());
        self::assertSame('https://api.xero.com/api.xro/2.0/Invoices/invoice-1', $event->getResourceUrl());
        self::assertSame('2026-03-25T10:30:00', $event->getEventDateUtc());
        self::assertSame(['key' => 'value'], $event->getData());
        self::assertArrayHasKey('data', $event->getPayload());
        self::assertTrue($event->category('invoice'));
        self::assertTrue($event->type('create'));
        self::assertTrue($event->resource('invoice-1'));
        self::assertTrue($event->isCreate());
        self::assertSame('Invoices', $event->resourceName());
        self::assertSame('/api.xro/2.0/Invoices/invoice-1', $event->path());
        self::assertSame('2026-03-25T10:30:00', $event->occurredAt()?->format('Y-m-d\TH:i:s'));
    }
}
