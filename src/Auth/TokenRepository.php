<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

interface TokenRepository
{
    public function get(string $key): ?Token;

    public function put(string $key, Token $token): void;
}
