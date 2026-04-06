<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

final readonly class Field
{
    private function __construct(
        public string $type,
        public ?string $class = null,
        public ?string $method = null
    ) {
    }

    public static function string(): self
    {
        return new self('string');
    }

    public static function number(): self
    {
        return new self('number');
    }

    public static function boolean(): self
    {
        return new self('boolean');
    }

    public static function array(): self
    {
        return new self('array');
    }

    public static function object(string $class): self
    {
        return new self('object', $class);
    }

    public static function many(string $class): self
    {
        return new self('many', $class);
    }

    public function using(string $method): self
    {
        return new self($this->type, $this->class, $method);
    }
}
