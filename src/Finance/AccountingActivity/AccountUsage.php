<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final readonly class AccountUsage
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $accountId,
        public ?string $accountCode,
        public ?string $accountName,
        public ?float $amount,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['AccountID']) ? (string) $payload['AccountID'] : null,
            isset($payload['AccountCode']) ? (string) $payload['AccountCode'] : null,
            isset($payload['AccountName']) ? (string) $payload['AccountName'] : null,
            isset($payload['Amount']) ? (float) $payload['Amount'] : null,
            $payload
        );
    }
}
