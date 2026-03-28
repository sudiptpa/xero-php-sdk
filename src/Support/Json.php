<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

use RuntimeException;

final class Json
{
    /**
     * @param array<string, mixed> $value
     */
    public static function encode(array $value): string
    {
        self::ensureAvailable();

        return json_encode($value, JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string, mixed>
     */
    public static function decodeObject(string $value): array
    {
        self::ensureAvailable();

        $decoded = json_decode($value, true, flags: JSON_THROW_ON_ERROR);

        if (! is_array($decoded)) {
            throw new RuntimeException('Unable to decode JSON response body.');
        }

        return $decoded;
    }

    /**
     * @return mixed
     */
    public static function decode(string $value): mixed
    {
        self::ensureAvailable();

        return json_decode($value, true, flags: JSON_THROW_ON_ERROR);
    }

    public static function ensureAvailable(): void
    {
        if (! function_exists('json_encode') || ! function_exists('json_decode')) {
            throw new RuntimeException('The json extension is required for JSON request and response handling.');
        }
    }
}
