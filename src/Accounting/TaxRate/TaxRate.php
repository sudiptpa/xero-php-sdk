<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class TaxRate
{
    /**
     * @param list<array<string, mixed>> $components
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $name,
        public ?string $taxType,
        public ?string $status,
        public array $components = [],
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['Name'] ?? null,
            $payload['TaxType'] ?? null,
            $payload['Status'] ?? null,
            $payload['TaxComponents'] ?? [],
            $payload,
            $client
        );
    }

    public function name(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self($name, $this->taxType, $this->status, $this->components, $payload, $this->client);
    }

    public function component(string $name, int|float $rate): self
    {
        $components = $this->components;
        $components[] = ['Name' => $name, 'Rate' => $rate];

        $payload = $this->raw;
        $payload['TaxComponents'] = $components;

        return new self($this->name, $this->taxType, $this->status, $components, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a tax rate without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->taxType !== null) {
            $payload = $payload->taxType($this->taxType);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        foreach ($this->components as $component) {
            $payload = $payload->component(
                (string) ($component['Name'] ?? ''),
                (float) ($component['Rate'] ?? 0)
            );
        }

        return $payload->save();
    }
}
