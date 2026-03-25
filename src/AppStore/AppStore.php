<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore;

use Sujip\Xero\Client;

final readonly class AppStore
{
    public function __construct(
        private Client $client
    ) {
    }

    public function client(): Client
    {
        return $this->client;
    }
}
