<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Type;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private const BASE_PATH = '/assets.xro/1.0/AssetTypes';

    private ?string $name = null;

    private ?string $fixedAssetAccountId = null;

    private ?string $depreciationExpenseAccountId = null;

    private ?string $accumulatedDepreciationAccountId = null;

    private ?string $depreciationMethod = null;

    private ?string $averagingMethod = null;

    private int|float|null $depreciationRate = null;

    private ?string $depreciationCalculationMethod = null;

    private ?string $poolName = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;

        return $clone;
    }

    public function fixedAssetAccount(string $accountId): self
    {
        $clone = clone $this;
        $clone->fixedAssetAccountId = $accountId;

        return $clone;
    }

    public function depreciationExpenseAccount(string $accountId): self
    {
        $clone = clone $this;
        $clone->depreciationExpenseAccountId = $accountId;

        return $clone;
    }

    public function accumulatedDepreciationAccount(string $accountId): self
    {
        $clone = clone $this;
        $clone->accumulatedDepreciationAccountId = $accountId;

        return $clone;
    }

    public function depreciationMethod(string $method): self
    {
        $clone = clone $this;
        $clone->depreciationMethod = $method;

        return $clone;
    }

    public function averagingMethod(string $method): self
    {
        $clone = clone $this;
        $clone->averagingMethod = $method;

        return $clone;
    }

    public function depreciationRate(int|float $rate): self
    {
        $clone = clone $this;
        $clone->depreciationRate = $rate;

        return $clone;
    }

    public function depreciationCalculationMethod(string $method): self
    {
        $clone = clone $this;
        $clone->depreciationCalculationMethod = $method;

        return $clone;
    }

    public function poolName(string $poolName): self
    {
        $clone = clone $this;
        $clone->poolName = $poolName;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Type
    {
        $response = $this->client
            ->post(self::BASE_PATH)
            ->withHeaders($this->headers())
            ->withJson(array_filter([
                'AssetTypeName' => $this->name,
                'FixedAssetAccountId' => $this->fixedAssetAccountId,
                'DepreciationExpenseAccountId' => $this->depreciationExpenseAccountId,
                'AccumulatedDepreciationAccountId' => $this->accumulatedDepreciationAccountId,
                'BookDepreciationSetting' => array_filter([
                    'DepreciationMethod' => $this->depreciationMethod,
                    'AveragingMethod' => $this->averagingMethod,
                    'DepreciationRate' => $this->depreciationRate,
                    'DepreciationCalculationMethod' => $this->depreciationCalculationMethod,
                    'PoolName' => $this->poolName,
                ], static fn (mixed $value): bool => $value !== null),
            ], static function (mixed $value, string $key): bool {
                if ($key === 'BookDepreciationSetting') {
                    return is_array($value) && $value !== [];
                }

                return $value !== null;
            }, ARRAY_FILTER_USE_BOTH))
            ->send();

        $payload = $response->json();
        $type = Json::extractFirst($payload, 'Items') ?? [];

        if ($type === []) {
            return new Type();
        }

        return (new Types($this->client))->mapType($type);
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        if ($this->idempotencyKey === null) {
            return [];
        }

        return ['Idempotency-Key' => $this->idempotencyKey];
    }
}
