<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

use DateTimeImmutable;

final readonly class Token
{
    /**
     * @param list<string> $scopes
     */
    public function __construct(
        public string $accessToken,
        public ?string $refreshToken = null,
        public ?DateTimeImmutable $expiresAt = null,
        public array $scopes = [],
        public ?string $idToken = null,
        public ?string $tokenType = 'Bearer'
    ) {
    }

    public function hasRefreshToken(): bool
    {
        return $this->refreshToken !== null && $this->refreshToken !== '';
    }

    public function isExpired(?DateTimeImmutable $now = null): bool
    {
        if ($this->expiresAt === null) {
            return false;
        }

        return $this->expiresAt <= ($now ?? new DateTimeImmutable());
    }
}
