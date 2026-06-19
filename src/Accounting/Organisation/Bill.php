<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Bill extends Model implements SerializesRequest
{
    private ?int $day = null;

    private ?string $type = null;

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(?int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Day' => Field::number(),
            'Type' => Field::string(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Day' => $this->getDay(),
            'Type' => $this->getType(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
