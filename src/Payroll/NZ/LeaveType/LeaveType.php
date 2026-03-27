<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\LeaveType;

final readonly class LeaveType
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?bool $isActive,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['LeaveTypeID'] ?? null,
            $payload['Name'] ?? null,
            isset($payload['IsActive']) ? (bool) $payload['IsActive'] : null,
            $payload
        );
    }
}
