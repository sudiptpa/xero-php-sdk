<?php

declare(strict_types=1);

namespace Sujip\Xero\Webhooks;

use Sujip\Xero\Exceptions\InvalidWebhookSignatureException;
use Sujip\Xero\Support\Json;

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

    /**
     * @param array<string, string|string[]|null> $headers
     */
    public function signatureFromHeaders(array $headers, string $header = 'x-xero-signature'): ?string
    {
        $target = strtolower($header);

        foreach ($headers as $name => $value) {
            if (strtolower($name) !== $target) {
                continue;
            }

            if (is_array($value)) {
                $value = $value[0] ?? null;
            }

            return is_string($value) && $value !== '' ? $value : null;
        }

        return null;
    }

    /**
     * @param array<string, string|string[]|null> $headers
     */
    public function verifyHeaders(string $payload, array $headers, string $header = 'x-xero-signature'): bool
    {
        return $this->verify($payload, $this->signatureFromHeaders($headers, $header));
    }

    public function assertValid(string $payload, ?string $signature): void
    {
        if (! $this->verify($payload, $signature)) {
            throw new InvalidWebhookSignatureException('The Xero webhook signature is invalid.');
        }
    }

    /**
     * @param array<string, string|string[]|null> $headers
     */
    public function assertValidHeaders(string $payload, array $headers, string $header = 'x-xero-signature'): void
    {
        $this->assertValid($payload, $this->signatureFromHeaders($headers, $header));
    }

    public function parse(string $payload): WebhookPayload
    {
        /** @var array<string, mixed> $decoded */
        $decoded = Json::decodeObject($payload);

        return (new WebhookPayload())->fill($decoded);
    }

    public function verifyAndParse(string $payload, ?string $signature): WebhookPayload
    {
        $this->assertValid($payload, $signature);

        return $this->parse($payload);
    }

    /**
     * @param array<string, string|string[]|null> $headers
     */
    public function verifyAndParseHeaders(string $payload, array $headers, string $header = 'x-xero-signature'): WebhookPayload
    {
        return $this->verifyAndParse($payload, $this->signatureFromHeaders($headers, $header));
    }

}
