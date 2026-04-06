<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

use LogicException;

abstract class Model
{
    /**
     * @param array<string, mixed> $payload
     */
    public function fill(array $payload): static
    {
        foreach (static::getDefinitions() as $field => $definition) {
            if (! array_key_exists($field, $payload)) {
                continue;
            }

            $value = $payload[$field] ?? null;

            if ($definition->type === 'string') {
                $this->applyStringField($field, $definition, $value);

                continue;
            }

            if ($definition->type === 'number') {
                $this->applyNumberField($field, $definition, $value);

                continue;
            }

            if ($definition->type === 'boolean') {
                $this->applyBooleanField($field, $definition, $value);

                continue;
            }

            if ($definition->type === 'array') {
                $this->applyArrayField($field, $definition, $value);

                continue;
            }

            if ($definition->type === 'object') {
                $this->applyObjectField($field, $definition, $value);

                continue;
            }

            if ($definition->type === 'many') {
                $this->applyManyField($field, $definition, $value);
            }
        }

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    abstract protected static function getDefinitions(): array;

    private function applyStringField(string $field, Field $definition, mixed $value): void
    {
        $method = $definition->method ?? 'set' . $field;

        if (! method_exists($this, $method)) {
            throw new LogicException(sprintf('Missing method [%s] for field [%s].', $method, $field));
        }

        $this->{$method}(is_scalar($value) ? (string) $value : null);
    }

    private function applyNumberField(string $field, Field $definition, mixed $value): void
    {
        $method = $definition->method ?? 'set' . $field;

        if (! method_exists($this, $method)) {
            throw new LogicException(sprintf('Missing method [%s] for field [%s].', $method, $field));
        }

        $this->{$method}(is_numeric($value) ? $value + 0 : null);
    }

    private function applyBooleanField(string $field, Field $definition, mixed $value): void
    {
        $method = $definition->method ?? 'set' . $field;

        if (! method_exists($this, $method)) {
            throw new LogicException(sprintf('Missing method [%s] for field [%s].', $method, $field));
        }

        $this->{$method}($value === null ? null : (bool) $value);
    }

    private function applyArrayField(string $field, Field $definition, mixed $value): void
    {
        $method = $definition->method ?? 'set' . $field;

        if (! method_exists($this, $method)) {
            throw new LogicException(sprintf('Missing method [%s] for field [%s].', $method, $field));
        }

        $this->{$method}(is_array($value) ? $value : []);
    }

    private function applyObjectField(string $field, Field $definition, mixed $value): void
    {
        if (! is_array($value) || $definition->class === null) {
            return;
        }

        $method = $definition->method ?? 'set' . $field;

        if (! method_exists($this, $method)) {
            throw new LogicException(sprintf('Missing method [%s] for field [%s].', $method, $field));
        }

        $instance = $this->newDefinitionInstance($definition->class);

        if (! method_exists($instance, 'fill')) {
            throw new LogicException(sprintf('Model [%s] must define fill().', $definition->class));
        }

        $this->{$method}($instance->fill($value));
    }

    private function applyManyField(string $field, Field $definition, mixed $value): void
    {
        if (! is_array($value) || $definition->class === null) {
            return;
        }

        $method = $definition->method ?? 'add' . $this->singular($field);

        if (! method_exists($this, $method)) {
            throw new LogicException(sprintf('Missing method [%s] for field [%s].', $method, $field));
        }

        foreach ($value as $item) {
            if (is_array($item)) {
                $instance = $this->newDefinitionInstance($definition->class);

                if (! method_exists($instance, 'fill')) {
                    throw new LogicException(sprintf('Model [%s] must define fill().', $definition->class));
                }

                $this->{$method}($instance->fill($item));
            }
        }
    }

    protected function newDefinitionInstance(string $class): object
    {
        return new $class();
    }

    private function singular(string $field): string
    {
        if (str_ends_with($field, 'ies')) {
            return substr($field, 0, -3) . 'y';
        }

        if (preg_match('/(sses|shes|ches|xes|zes)$/', $field) === 1) {
            return substr($field, 0, -2);
        }

        if (str_ends_with($field, 's')) {
            return substr($field, 0, -1);
        }

        return $field;
    }
}
