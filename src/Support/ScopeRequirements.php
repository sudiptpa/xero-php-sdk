<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

final readonly class ScopeRequirements
{
    /**
     * @param list<string> $broad
     * @param list<string> $granular
     */
    public function __construct(
        public array $broad = [],
        public array $granular = []
    ) {
    }
}
