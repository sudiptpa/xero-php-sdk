<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Webhooks;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Exceptions\InvalidWebhookSignatureException;
use Sujip\Xero\Webhooks\WebhookPayload;
use Sujip\Xero\Xero;

final class WebhookVerifierTest extends TestCase
{
    public function test_it_verifies_a_valid_signature(): void
    {
        $payload = json_encode([
            'firstEventSequence' => 1,
            'lastEventSequence' => 1,
            'events' => [[
                'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Invoices/invoice-1',
                'resourceId' => 'invoice-1',
                'eventCategory' => 'INVOICE',
                'eventType' => 'CREATE',
                'eventDateUtc' => '2026-03-25T00:00:00',
            ]],
        ], JSON_THROW_ON_ERROR);

        $verifier = Xero::webhookVerifier('webhook-key');
        $signature = $verifier->signatureFor($payload);

        self::assertTrue($verifier->verify($payload, $signature));
    }

    public function test_it_throws_for_an_invalid_signature(): void
    {
        $this->expectException(InvalidWebhookSignatureException::class);

        Xero::webhookVerifier('webhook-key')
            ->assertValid('{"events":[]}', 'invalid-signature');
    }

    public function test_it_parses_a_webhook_payload(): void
    {
        $payload = json_encode([
            'firstEventSequence' => 1,
            'lastEventSequence' => 2,
            'entropy' => 'random-entropy',
            'events' => [
                [
                    'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Invoices/invoice-1',
                    'resourceId' => 'invoice-1',
                    'eventCategory' => 'INVOICE',
                    'eventType' => 'CREATE',
                    'eventDateUtc' => '2026-03-25T00:00:00',
                    'tenantId' => 'tenant-1',
                    'tenantType' => 'ORGANISATION',
                ],
                [
                    'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Contacts/contact-1',
                    'resourceId' => 'contact-1',
                    'eventCategory' => 'CONTACT',
                    'eventType' => 'UPDATE',
                    'eventDateUtc' => '2026-03-25T00:05:00',
                    'tenantId' => 'tenant-1',
                    'tenantType' => 'ORGANISATION',
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $webhook = Xero::webhookVerifier('webhook-key')->parse($payload);

        self::assertSame(1, $webhook->getFirstEventSequence());
        self::assertSame(2, $webhook->getLastEventSequence());
        self::assertSame('random-entropy', $webhook->getEntropy());
        self::assertTrue($webhook->hasEvents());
        $firstEvent = $webhook->first();
        self::assertNotNull($firstEvent);
        self::assertSame('invoice-1', $firstEvent->getResourceId());
        self::assertSame('tenant-1', $firstEvent->getTenantId());
        self::assertSame('ORGANISATION', $firstEvent->getTenantType());
        $lastEvent = $webhook->last();
        self::assertNotNull($lastEvent);
        self::assertSame('contact-1', $lastEvent->getResourceId());
        self::assertSame(['INVOICE', 'CONTACT'], $webhook->categories());
        self::assertSame(['CREATE', 'UPDATE'], $webhook->eventTypes());
        self::assertSame(2, $webhook->count());
        self::assertTrue($webhook->contains('invoice'));
        self::assertTrue($webhook->has('contact', 'update'));
        self::assertSame(['invoice-1', 'contact-1'], $webhook->resourceIds());
        self::assertSame([
            '/api.xro/2.0/Invoices/invoice-1',
            '/api.xro/2.0/Contacts/contact-1',
        ], $webhook->paths());
        self::assertCount(1, $webhook->only('contact', 'update'));
        self::assertTrue($webhook->contains('contact', 'update'));
        $fe = $webhook->first();
        self::assertNotNull($fe);
        self::assertSame('/api.xro/2.0/Invoices/invoice-1', $fe->path());
        self::assertSame('Invoices', $fe->resourceName());
        self::assertTrue($fe->category('invoice'));
        self::assertTrue($fe->type('create'));
        self::assertTrue($fe->resource('invoice-1'));
        self::assertSame('2026-03-25T00:00:00+00:00', $fe->occurredAt()?->format(\DateTimeInterface::ATOM));
        self::assertTrue($fe->isCreate());
        $le = $webhook->last();
        self::assertNotNull($le);
        self::assertTrue($le->isUpdate());
    }

    public function test_it_can_verify_and_parse_in_one_step(): void
    {
        $payload = json_encode([
            'firstEventSequence' => 1,
            'lastEventSequence' => 1,
            'events' => [[
                'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Invoices/invoice-1',
                'resourceId' => 'invoice-1',
                'eventCategory' => 'INVOICE',
                'eventType' => 'DELETE',
                'eventDateUtc' => '2026-03-25T00:00:00',
            ]],
        ], JSON_THROW_ON_ERROR);

        $verifier = Xero::webhookVerifier('webhook-key');
        $signature = $verifier->signatureFor($payload);
        $webhook = $verifier->verifyAndParse($payload, $signature);

        $fe = $webhook->first();
        self::assertNotNull($fe);
        self::assertSame('invoice-1', $fe->getResourceId());
        self::assertTrue($fe->isDelete());
    }

    public function test_it_can_work_with_header_arrays_directly(): void
    {
        $payload = json_encode([
            'firstEventSequence' => 10,
            'lastEventSequence' => 10,
            'events' => [[
                'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Invoices/invoice-1',
                'resourceId' => 'invoice-1',
                'eventCategory' => 'INVOICE',
                'eventType' => 'UPDATE',
                'eventDateUtc' => '2026-03-25T00:00:00',
            ]],
        ], JSON_THROW_ON_ERROR);

        $verifier = Xero::webhookVerifier('webhook-key');
        $signature = $verifier->signatureFor($payload);
        $headers = [
            'Content-Type' => 'application/json',
            'X-Xero-Signature' => $signature,
        ];

        self::assertSame($signature, $verifier->signatureFromHeaders($headers));
        self::assertTrue($verifier->verifyHeaders($payload, $headers));

        $parsed = $verifier->verifyAndParseHeaders($payload, $headers);

        $parsedFirst = $parsed->first();
        self::assertNotNull($parsedFirst);
        self::assertSame('invoice-1', $parsedFirst->getResourceId());
        self::assertTrue($parsedFirst->isUpdate());
    }

    public function test_it_rejects_null_and_empty_signatures(): void
    {
        $verifier = Xero::webhookVerifier('webhook-key');

        self::assertFalse($verifier->verify('{"events":[]}', null));
        self::assertFalse($verifier->verify('{"events":[]}', ''));
    }

    public function test_assert_valid_passes_for_a_matching_signature(): void
    {
        $verifier = Xero::webhookVerifier('webhook-key');
        $payload = '{"events":[]}';

        $verifier->assertValid($payload, $verifier->signatureFor($payload));

        $this->expectNotToPerformAssertions();
    }

    public function test_it_reads_signatures_from_header_arrays(): void
    {
        $verifier = Xero::webhookVerifier('webhook-key');

        self::assertSame(
            'sig-value',
            $verifier->signatureFromHeaders(['X-Xero-Signature' => ['sig-value', 'ignored']])
        );
    }

    public function test_it_returns_null_for_missing_or_blank_header_signatures(): void
    {
        $verifier = Xero::webhookVerifier('webhook-key');

        self::assertNull($verifier->signatureFromHeaders(['Content-Type' => 'application/json']));
        self::assertNull($verifier->signatureFromHeaders(['X-Xero-Signature' => '']));
        self::assertNull($verifier->signatureFromHeaders(['X-Xero-Signature' => []]));
    }

    public function test_assert_valid_headers_enforces_the_signature(): void
    {
        $verifier = Xero::webhookVerifier('webhook-key');
        $payload = '{"events":[]}';
        $headers = ['X-Xero-Signature' => $verifier->signatureFor($payload)];

        $verifier->assertValidHeaders($payload, $headers);

        $this->expectException(InvalidWebhookSignatureException::class);
        $verifier->assertValidHeaders($payload, ['X-Xero-Signature' => 'wrong']);
    }
}
