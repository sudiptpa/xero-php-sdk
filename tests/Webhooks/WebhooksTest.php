<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Webhooks;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Webhooks\Webhooks;

final class WebhooksTest extends TestCase
{
    public function test_it_builds_a_verifier_bound_to_the_signing_key(): void
    {
        $verifier = (new Webhooks())->verifier('signing-key');

        $payload = '{"events":[]}';

        self::assertTrue($verifier->verify($payload, $verifier->signatureFor($payload)));
    }
}
