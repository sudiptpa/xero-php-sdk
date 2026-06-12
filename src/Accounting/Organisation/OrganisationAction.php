<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

final readonly class OrganisationAction
{
    public function __construct(
        public ?string $name,
        public ?string $status
    ) {
    }

    public function isAllowed(): bool
    {
        return $this->status === 'ALLOWED';
    }
}
