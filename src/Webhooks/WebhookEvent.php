<?php

declare(strict_types=1);

namespace Sujip\Xero\Webhooks;

use DateTimeImmutable;
use DateTimeInterface;

final readonly class WebhookEvent
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public ?string $resourceUrl,
        public ?string $resourceId,
        public ?string $eventCategory,
        public ?string $eventType,
        public ?string $eventDateUtc,
        public array $payload = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['resourceUrl'] ?? null,
            $payload['resourceId'] ?? null,
            $payload['eventCategory'] ?? null,
            $payload['eventType'] ?? null,
            $payload['eventDateUtc'] ?? null,
            $payload
        );
    }

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
