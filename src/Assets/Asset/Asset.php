<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Asset;

final class Asset
{
    private ?string $assetId = null;

    private ?string $assetName = null;

    private ?string $assetNumber = null;

    private ?string $status = null;

    private ?string $assetTypeId = null;

    public function getAssetId(): ?string
    {
        return $this->assetId;
    }

    public function setAssetId(?string $assetId): self
    {
        $this->assetId = $assetId;

        return $this;
    }

    public function getAssetName(): ?string
    {
        return $this->assetName;
    }

    public function setAssetName(?string $assetName): self
    {
        $this->assetName = $assetName;

        return $this;
    }

    public function getAssetNumber(): ?string
    {
        return $this->assetNumber;
    }

    public function setAssetNumber(?string $assetNumber): self
    {
        $this->assetNumber = $assetNumber;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status === null ? null : strtoupper($status);

        return $this;
    }

    public function getAssetTypeId(): ?string
    {
        return $this->assetTypeId;
    }

    public function setAssetTypeId(?string $assetTypeId): self
    {
        $this->assetTypeId = $assetTypeId;

        return $this;
    }

}
