<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

final readonly class UsageRecord
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $subscriptionItemId,
        public ?float $quantity,
        public ?string $startDate,
        public ?string $endDate,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['id']) ? (string) $payload['id'] : null,
            isset($payload['subscriptionItemId']) ? (string) $payload['subscriptionItemId'] : null,
            isset($payload['quantity']) ? (float) $payload['quantity'] : null,
            isset($payload['startDate']) ? (string) $payload['startDate'] : null,
            isset($payload['endDate']) ? (string) $payload['endDate'] : null,
            $payload
        );
    }
}
