<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final readonly class UserActivity
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $userId,
        public ?string $fullName,
        public ?int $transactionCount,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['UserId']) ? (string) $payload['UserId'] : null,
            isset($payload['FullName']) ? (string) $payload['FullName'] : null,
            isset($payload['TransactionCount']) ? (int) $payload['TransactionCount'] : null,
            $payload
        );
    }
}
