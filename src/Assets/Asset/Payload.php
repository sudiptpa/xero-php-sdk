<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Asset;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private const BASE_PATH = '/assets.xro/1.0/Assets';

    private ?string $name = null;

    private ?string $number = null;

    private ?string $status = null;

    private ?string $assetTypeId = null;

    private ?string $purchaseDate = null;

    private int|float|null $purchasePrice = null;

    private ?string $serialNumber = null;

    private ?string $warrantyExpiryDate = null;

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

    public function number(string $number): self
    {
        $clone = clone $this;
        $clone->number = $number;

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->status = strtoupper($status);

        return $clone;
    }

    public function assetType(string $assetTypeId): self
    {
        $clone = clone $this;
        $clone->assetTypeId = $assetTypeId;

        return $clone;
    }

    public function purchaseDate(string $purchaseDate): self
    {
        $clone = clone $this;
        $clone->purchaseDate = $purchaseDate;

        return $clone;
    }

    public function purchasePrice(int|float $purchasePrice): self
    {
        $clone = clone $this;
        $clone->purchasePrice = $purchasePrice;

        return $clone;
    }

    public function serialNumber(string $serialNumber): self
    {
        $clone = clone $this;
        $clone->serialNumber = $serialNumber;

        return $clone;
    }

    public function warrantyExpiryDate(string $warrantyExpiryDate): self
    {
        $clone = clone $this;
        $clone->warrantyExpiryDate = $warrantyExpiryDate;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Asset
    {
        $response = $this->client
            ->post(self::BASE_PATH)
            ->withHeaders($this->headers())
            ->withJson(array_filter([
                'AssetName' => $this->name,
                'AssetNumber' => $this->number,
                'Status' => $this->status,
                'AssetTypeId' => $this->assetTypeId,
                'PurchaseDate' => $this->purchaseDate,
                'PurchasePrice' => $this->purchasePrice,
                'SerialNumber' => $this->serialNumber,
                'WarrantyExpiryDate' => $this->warrantyExpiryDate,
            ], static fn (mixed $value): bool => $value !== null))
            ->send();

        $payload = $response->json();
        $asset = Json::extractFirst($payload, 'Items') ?? [];

        if ($asset === []) {
    return new Asset();
        }

        return (new Assets($this->client))->mapAsset($asset);
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
