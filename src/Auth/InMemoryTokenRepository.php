<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

final class InMemoryTokenRepository implements TokenRepository
{
    /**
     * @var array<string, Token>
     */
    private array $tokens = [];

    public function get(string $key): ?Token
    {
        return $this->tokens[$key] ?? null;
    }

    public function put(string $key, Token $token): void
    {
        $this->tokens[$key] = $token;
    }
}
