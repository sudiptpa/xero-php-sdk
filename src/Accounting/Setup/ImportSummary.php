<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Setup;

final readonly class ImportSummary
{
    /**
     * @param array<string, mixed> $accounts
     * @param array<string, mixed> $organisation
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public array $accounts,
        public array $organisation,
        public array $raw = []
    ) {
    }
}
