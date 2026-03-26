<?php

declare(strict_types=1);

namespace Sujip\Xero\Webhooks;

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
