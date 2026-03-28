<?php

declare(strict_types=1);

namespace Sujip\Xero\Identity;

use RuntimeException;
use Sujip\Xero\Client;

final class Connection
{
    public function __construct(
        private ?Client $client = null,
        private ?string $id = null,
        private ?string $tenantId = null,
        private ?string $tenantName = null,
        private ?string $tenantType = null,
        private ?string $createdDateUtc = null,
        private ?string $updatedDateUtc = null,
    ) {
    }

    public function getId(): ?string { return $this->id; }
    public function setId(?string $id): self { $this->id = $id; return $this; }
    public function getTenantId(): ?string { return $this->tenantId; }
    public function setTenantId(?string $tenantId): self { $this->tenantId = $tenantId; return $this; }
    public function getTenantName(): ?string { return $this->tenantName; }
    public function setTenantName(?string $tenantName): self { $this->tenantName = $tenantName; return $this; }
    public function getTenantType(): ?string { return $this->tenantType; }
    public function setTenantType(?string $tenantType): self { $this->tenantType = $tenantType; return $this; }
    public function getCreatedDateUtc(): ?string { return $this->createdDateUtc; }
    public function setCreatedDateUtc(?string $createdDateUtc): self { $this->createdDateUtc = $createdDateUtc; return $this; }
    public function getUpdatedDateUtc(): ?string { return $this->updatedDateUtc; }
    public function setUpdatedDateUtc(?string $updatedDateUtc): self { $this->updatedDateUtc = $updatedDateUtc; return $this; }
    public function disconnect(): bool
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot disconnect a connection without a bound client context and connection id.');
        }

        return (new Connections($this->client))->disconnect($this->id);
    }
}
