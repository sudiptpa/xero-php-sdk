<?php

declare(strict_types=1);

namespace Sujip\Xero\Webhooks;

final class Webhooks
{
    public function verifier(string $signingKey): WebhookVerifier
    {
        return new WebhookVerifier($signingKey);
    }
}
