<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

final readonly class Headers
{
    /**
     * @return array<string, string>
     */
    public static function idempotency(?string $key): array
    {
        return $key === null ? [] : ['Idempotency-Key' => $key];
    }
}
