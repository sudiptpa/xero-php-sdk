<?php

declare(strict_types=1);

namespace Sujip\Xero\Support\Concerns;

trait InteractsWithBindings
{
    /**
     * @param array<int|string, mixed> $bindings
     */
    private function interpolateBindings(string $expression, array $bindings): string
    {
        $resolved = $expression;

        foreach ($bindings as $key => $value) {
            $resolved = str_replace(':' . $key, $this->wrapBinding($value), $resolved);
        }

        return $resolved;
    }

    private function wrapBinding(mixed $value): string
    {
        return match (true) {
            is_bool($value) => $value ? 'true' : 'false',
            is_int($value), is_float($value) => (string) $value,
            $value === null => 'null',
            default => '"' . str_replace('"', '\"', (string) $value) . '"',
        };
    }
}
