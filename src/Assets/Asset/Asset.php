<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Asset;

final readonly class Asset
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $number,
        public ?string $status,
        public ?string $assetTypeId = null,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        $assetType = $payload['AssetType'] ?? null;

        return new self(
            $payload['AssetId'] ?? $payload['Id'] ?? null,
            $payload['AssetName'] ?? $payload['Name'] ?? null,
            $payload['AssetNumber'] ?? null,
            $payload['Status'] ?? null,
            is_array($assetType) ? ($assetType['AssetTypeId'] ?? null) : ($payload['AssetTypeId'] ?? null),
            $payload
        );
    }
}
