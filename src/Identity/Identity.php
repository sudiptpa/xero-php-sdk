<?php

declare(strict_types=1);

namespace Sujip\Xero\Identity;

use Sujip\Xero\Client;

final readonly class Identity
{
    public function __construct(
        private Client $client
    ) {
    }

    public function connections(): Connections
    {
        return new Connections($this->client);
    }
}
