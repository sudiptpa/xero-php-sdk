<?php

declare(strict_types=1);

namespace Sujip\Xero;

final readonly class Context
{
    public function __construct(
        public string $accessToken,
        public ?string $tenantId = null,
        public string $baseUri = 'https://api.xero.com'
    ) {
    }

    public static function make(
        string $accessToken,
        ?string $tenantId = null,
        string $baseUri = 'https://api.xero.com'
    ): self {
        return new self($accessToken, $tenantId, $baseUri);
    }

    public function tenant(string $tenantId): self
    {
        return new self($this->accessToken, $tenantId, $this->baseUri);
    }

    /**
     * @return array<string, string>
     */
    public function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function tenantHeaders(): array
    {
        if ($this->tenantId === null || $this->tenantId === '') {
            return [];
        }

        return [
            'Xero-Tenant-Id' => $this->tenantId,
        ];
    }
}
