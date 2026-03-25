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
}
