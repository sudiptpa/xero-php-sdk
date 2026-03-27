<?php

declare(strict_types=1);

namespace Sujip\Xero\Support\Contracts;

use Sujip\Xero\Client;

interface BuildsFromPayload
{
    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?Client $client = null): static;
}
