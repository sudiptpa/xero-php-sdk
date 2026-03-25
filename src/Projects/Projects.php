<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects;

use Sujip\Xero\Client;

final readonly class Projects
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
