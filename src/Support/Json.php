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

        $result = [];
        foreach ($decoded as $k => $v) {
            $result[(string) $k] = $v;
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public static function decode(string $value): mixed
    {
        self::ensureAvailable();

        return json_decode($value, true, flags: JSON_THROW_ON_ERROR);
    }

    /**
     * @param array<string, mixed> $payload
     * @return list<array<string, mixed>>
     */
    public static function extractList(array $payload, string $key): array
    {
        $raw = $payload[$key] ?? null;

        if (! is_array($raw)) {
            return [];
        }

        $result = [];
        foreach ($raw as $item) {
            if (is_array($item)) {
                $typed = [];
                foreach ($item as $k => $v) {
                    $typed[(string) $k] = $v;
                }
                $result[] = $typed;
            }
        }

        return $result;
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>|null
     */
    public static function extractFirst(array $payload, string $key): ?array
    {
        return self::extractList($payload, $key)[0] ?? null;
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public static function extractObject(array $payload, string $key): array
    {
        $raw = $payload[$key] ?? null;

        if (! is_array($raw)) {
            return [];
        }

        $result = [];
        foreach ($raw as $k => $v) {
            $result[(string) $k] = $v;
        }

        return $result;
    }

    public static function ensureAvailable(): void
    {
        // The json extension is a hard requirement and cannot be unloaded at
        // runtime, so this guard is unreachable in tests.
        // @codeCoverageIgnoreStart
        if (! function_exists('json_encode') || ! function_exists('json_decode')) {
            throw new RuntimeException('The json extension is required for JSON request and response handling.');
        }
        // @codeCoverageIgnoreEnd
    }
}
