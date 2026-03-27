<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\ProjectUser;

final readonly class ProjectUser
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $emailAddress,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['UserID'] ?? $payload['UserId'] ?? null,
            $payload['Name'] ?? null,
            $payload['Email'] ?? $payload['EmailAddress'] ?? null,
            $payload
        );
    }
}
