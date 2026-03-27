<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance;

final readonly class BankStatementEntry
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $accountId,
        public ?string $accountName,
        public ?float $statementBalance,
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
            isset($payload['AccountName']) ? (string) $payload['AccountName'] : null,
            isset($payload['StatementBalance']) ? (float) $payload['StatementBalance'] : null,
            $payload
        );
    }
}
