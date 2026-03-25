<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Type;

final readonly class Type
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $fixedAssetAccountId = null,
        public ?string $depreciationExpenseAccountId = null,
        public ?string $accumulatedDepreciationAccountId = null,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['AssetTypeId'] ?? null,
            $payload['AssetTypeName'] ?? null,
            $payload['FixedAssetAccountId'] ?? null,
            $payload['DepreciationExpenseAccountId'] ?? null,
            $payload['AccumulatedDepreciationAccountId'] ?? null,
            $payload
        );
    }
}
