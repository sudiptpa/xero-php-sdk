<?php

declare(strict_types=1);

namespace Sujip\Xero\Webhooks;

use Sujip\Xero\Exceptions\InvalidWebhookSignatureException;

final readonly class WebhookVerifier
{
    public function __construct(
        private string $signingKey
    ) {
    }

    public function signatureFor(string $payload): string
    {
        return base64_encode(hash_hmac('sha256', $payload, $this->signingKey, true));
    }

    public function verify(string $payload, ?string $signature): bool
    {
        if ($signature === null || $signature === '') {
            return false;
        }

        return hash_equals($this->signatureFor($payload), trim($signature));
    }

    public function assertValid(string $payload, ?string $signature): void
    {
        if (! $this->verify($payload, $signature)) {
            throw new InvalidWebhookSignatureException('The Xero webhook signature is invalid.');
        }
    }

    public function parse(string $payload): WebhookPayload
    {
        /** @var array<string, mixed> $decoded */
        $decoded = json_decode($payload, true, flags: JSON_THROW_ON_ERROR);

        return WebhookPayload::fromArray($decoded);
    }

    public function verifyAndParse(string $payload, ?string $signature): WebhookPayload
    {
        $this->assertValid($payload, $signature);

        return $this->parse($payload);
    }
}
