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
        private string $accessToken,
        private ?string $refreshToken = null,
        private ?DateTimeImmutable $expiresAt = null,
        private array $scopes = [],
        private ?string $idToken = null,
        private ?string $tokenType = 'Bearer'
    ) {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        return $this->expiresAt;
    }

    /**
     * @return list<string>
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function getIdToken(): ?string
    {
        return $this->idToken;
    }

    public function getTokenType(): ?string
    {
        return $this->tokenType;
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
