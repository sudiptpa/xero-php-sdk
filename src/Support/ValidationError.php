<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

final class ValidationError extends Model
{
    public function __construct(
        private ?string $message = null,
    ) {
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Message' => Field::string()->using('setMessage'),
        ];
    }
}
