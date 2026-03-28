<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

use Sujip\Xero\Client;
use Sujip\Xero\Identity\Connection;

final class ConnectedAccount
{
    public function __construct(
        private Token $token,
        private Connection $connection,
        private Client $client
    ) {
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
