<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

final readonly class CisSetting
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?bool $cisEnabled,
        public ?float $rate,
        public array $raw = []
    ) {
    }
}
