<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

use Sujip\Xero\Client;
use Sujip\Xero\Identity\Connection;

final readonly class ConnectedAccount
{
    public function __construct(
        public Token $token,
        public Connection $connection,
        public Client $client
    ) {
    }
}
