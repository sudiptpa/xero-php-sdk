<?php

declare(strict_types=1);

namespace Sujip\Xero\Support\Contracts;

interface SerializesForRequest
{
    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array;
}
