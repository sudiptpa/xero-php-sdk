<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Report;

final readonly class Report
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $type,
        public ?string $title,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        $title = null;

        if (isset($payload['ReportTitles'][0]) && is_string($payload['ReportTitles'][0])) {
            $title = $payload['ReportTitles'][0];
        }

        return new self(
            $payload['ReportID'] ?? null,
            $payload['ReportName'] ?? null,
            $payload['ReportType'] ?? null,
            $title,
            $payload
        );
    }
}
