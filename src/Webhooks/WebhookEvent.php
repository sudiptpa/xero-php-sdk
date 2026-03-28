<?php

declare(strict_types=1);

namespace Sujip\Xero\Webhooks;

use DateTimeImmutable;
use DateTimeInterface;

final class WebhookEvent
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        private ?string $resourceUrl = null,
        private ?string $resourceId = null,
        private ?string $eventCategory = null,
        private ?string $eventType = null,
        private ?string $eventDateUtc = null,
        private array $payload = []
    ) {
    }

    public function getResourceUrl(): ?string { return $this->resourceUrl; }
    public function setResourceUrl(?string $resourceUrl): self { $this->resourceUrl = $resourceUrl; return $this; }
    public function getResourceId(): ?string { return $this->resourceId; }
    public function setResourceId(?string $resourceId): self { $this->resourceId = $resourceId; return $this; }
    public function getEventCategory(): ?string { return $this->eventCategory; }
    public function setEventCategory(?string $eventCategory): self { $this->eventCategory = $eventCategory; return $this; }
    public function getEventType(): ?string { return $this->eventType; }
    public function setEventType(?string $eventType): self { $this->eventType = $eventType; return $this; }
    public function getEventDateUtc(): ?string { return $this->eventDateUtc; }
    public function setEventDateUtc(?string $eventDateUtc): self { $this->eventDateUtc = $eventDateUtc; return $this; }
    /**
     * @return array<string, mixed>
     */
    public function getPayload(): array { return $this->payload; }
    /**
     * @param array<string, mixed> $payload
     */
    public function setPayload(array $payload): self { $this->payload = $payload; return $this; }

    public function is(string $category, ?string $type = null): bool
    {
        if ($this->eventCategory !== strtoupper($category)) {
            return false;
        }

        if ($type === null) {
            return true;
        }

        return $this->eventType === strtoupper($type);
    }

    public function isCreate(): bool
    {
        return $this->eventType === 'CREATE';
    }

    public function isUpdate(): bool
    {
        return $this->eventType === 'UPDATE';
    }

    public function isDelete(): bool
    {
        return $this->eventType === 'DELETE';
    }

    public function category(string $category): bool
    {
        return $this->eventCategory === strtoupper($category);
    }

    public function type(string $type): bool
    {
        return $this->eventType === strtoupper($type);
    }

    public function resource(string $resourceId): bool
    {
        return $this->resourceId === $resourceId;
    }

    public function occurredAt(): ?DateTimeImmutable
    {
        if ($this->eventDateUtc === null || $this->eventDateUtc === '') {
            return null;
        }

        return new DateTimeImmutable($this->eventDateUtc);
    }

    public function resourceName(): ?string
    {
        $path = $this->path();

        if ($path === null) {
            return null;
        }

        $segments = array_values(array_filter(explode('/', $path), static fn (string $segment): bool => $segment !== ''));

        if ($segments === []) {
            return null;
        }

        $lastIndex = count($segments) - 1;
        $resource = $segments[$lastIndex];

        if ($this->resourceId !== null && $resource === $this->resourceId) {
            return $segments[$lastIndex - 1] ?? null;
        }

        return $resource;
    }

    public function path(): ?string
    {
        if ($this->resourceUrl === null || $this->resourceUrl === '') {
            return null;
        }

        $parts = parse_url($this->resourceUrl);
        $path = $parts['path'] ?? null;

        return is_string($path) ? $path : null;
    }
}
