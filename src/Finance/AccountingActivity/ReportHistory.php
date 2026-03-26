<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final readonly class ReportHistory
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $reportName,
        public ?string $publishedDateUtc,
        public ?string $publishedBy,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['ReportName']) ? (string) $payload['ReportName'] : null,
            isset($payload['PublishedDateUTC']) ? (string) $payload['PublishedDateUTC'] : null,
            isset($payload['PublishedBy']) ? (string) $payload['PublishedBy'] : null,
            $payload
        );
    }
}
