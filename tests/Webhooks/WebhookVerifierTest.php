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
            'events' => [
                [
                    'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Invoices/invoice-1',
                    'resourceId' => 'invoice-1',
                    'eventCategory' => 'INVOICE',
                    'eventType' => 'CREATE',
                    'eventDateUtc' => '2026-03-25T00:00:00',
                ],
                [
                    'resourceUrl' => 'https://api.xero.com/api.xro/2.0/Contacts/contact-1',
                    'resourceId' => 'contact-1',
                    'eventCategory' => 'CONTACT',
                    'eventType' => 'UPDATE',
                    'eventDateUtc' => '2026-03-25T00:05:00',
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $webhook = Xero::webhookVerifier('webhook-key')->parse($payload);

        self::assertInstanceOf(WebhookPayload::class, $webhook);
        self::assertSame('1', $webhook->firstEventSequence);
        self::assertTrue($webhook->hasEvents());
        self::assertSame('invoice-1', $webhook->first()?->resourceId);
        self::assertSame('contact-1', $webhook->last()?->resourceId);
        self::assertSame(['INVOICE', 'CONTACT'], $webhook->categories());
        self::assertSame(['CREATE', 'UPDATE'], $webhook->eventTypes());
        self::assertTrue($webhook->contains('invoice'));
        self::assertTrue($webhook->contains('contact', 'update'));
        self::assertSame('/api.xro/2.0/Invoices/invoice-1', $webhook->first()->path());
        self::assertTrue($webhook->first()->isCreate());
        self::assertTrue($webhook->last()->isUpdate());
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

        self::assertSame('invoice-1', $webhook->first()->resourceId);
        self::assertTrue($webhook->first()->isDelete());
    }
}
