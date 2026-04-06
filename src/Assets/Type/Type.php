<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Type;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Type extends Model
{
    private ?string $assetTypeId = null;

    private ?string $assetTypeName = null;

    private ?string $fixedAssetAccountId = null;

    private ?string $depreciationExpenseAccountId = null;

    private ?string $accumulatedDepreciationAccountId = null;

    public function getAssetTypeId(): ?string
    {
        return $this->assetTypeId;
    }

    public function setAssetTypeId(?string $assetTypeId): self
    {
        $this->assetTypeId = $assetTypeId;

        return $this;
    }

    public function getAssetTypeName(): ?string
    {
        return $this->assetTypeName;
    }

    public function setAssetTypeName(?string $assetTypeName): self
    {
        $this->assetTypeName = $assetTypeName;

        return $this;
    }

    public function getFixedAssetAccountId(): ?string
    {
        return $this->fixedAssetAccountId;
    }

    public function setFixedAssetAccountId(?string $fixedAssetAccountId): self
    {
        $this->fixedAssetAccountId = $fixedAssetAccountId;

        return $this;
    }

    public function getDepreciationExpenseAccountId(): ?string
    {
        return $this->depreciationExpenseAccountId;
    }

    public function setDepreciationExpenseAccountId(?string $depreciationExpenseAccountId): self
    {
        $this->depreciationExpenseAccountId = $depreciationExpenseAccountId;

        return $this;
    }

    public function getAccumulatedDepreciationAccountId(): ?string
    {
        return $this->accumulatedDepreciationAccountId;
    }

    public function setAccumulatedDepreciationAccountId(?string $accumulatedDepreciationAccountId): self
    {
        $this->accumulatedDepreciationAccountId = $accumulatedDepreciationAccountId;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'AssetTypeId' => Field::string(),
            'AssetTypeName' => Field::string(),
            'FixedAssetAccountId' => Field::string(),
            'DepreciationExpenseAccountId' => Field::string(),
            'AccumulatedDepreciationAccountId' => Field::string(),
        ];
    }
}
