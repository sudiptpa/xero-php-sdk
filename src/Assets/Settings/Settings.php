<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Settings;

use Sujip\Xero\Client;

final readonly class Settings
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public bool|null $depreciationCalculationEnabled,
        public ?string $defaultGainOnDisposalAccountId = null,
        public ?string $defaultLossOnDisposalAccountId = null,
        public ?string $defaultCapitalGainOnDisposalAccountId = null,
        public array $raw = []
    ) {
    }

    public static function fetch(Client $client): ?self
    {
        $response = $client
            ->get('/assets.xro/1.0/Settings')
            ->send();

        $payload = $response->json();
        $settings = $payload['Items'][0] ?? null;

        return is_array($settings) ? self::fromArray($settings) : null;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['DepreciationCalculationEnabled'] ?? null,
            $payload['DefaultGainOnDisposalAccountId'] ?? null,
            $payload['DefaultLossOnDisposalAccountId'] ?? null,
            $payload['DefaultCapitalGainOnDisposalAccountId'] ?? null,
            $payload
        );
    }
}
