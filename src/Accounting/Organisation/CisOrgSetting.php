<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

final readonly class CisOrgSetting
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?bool $cisContractorEnabled,
        public ?bool $cisSubContractorEnabled,
        public ?float $rate,
        public array $raw = []
    ) {
    }
}
