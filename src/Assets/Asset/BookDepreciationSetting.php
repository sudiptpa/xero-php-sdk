<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Asset;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BookDepreciationSetting extends Model
{
    private ?string $depreciationMethod = null;

    private ?string $averagingMethod = null;

    private int|float|null $depreciationRate = null;

    private int|float|null $effectiveLifeYears = null;

    private ?string $depreciationCalculationMethod = null;

    private ?string $depreciableObjectId = null;

    private ?string $depreciableObjectType = null;

    private ?string $bookEffectiveDateOfChangeId = null;

    public function getDepreciationMethod(): ?string
    {
        return $this->depreciationMethod;
    }

    public function setDepreciationMethod(?string $depreciationMethod): self
    {
        $this->depreciationMethod = $depreciationMethod;

        return $this;
    }

    public function getAveragingMethod(): ?string
    {
        return $this->averagingMethod;
    }

    public function setAveragingMethod(?string $averagingMethod): self
    {
        $this->averagingMethod = $averagingMethod;

        return $this;
    }

    public function getDepreciationRate(): int|float|null
    {
        return $this->depreciationRate;
    }

    public function setDepreciationRate(int|float|null $depreciationRate): self
    {
        $this->depreciationRate = $depreciationRate;

        return $this;
    }

    public function getEffectiveLifeYears(): int|float|null
    {
        return $this->effectiveLifeYears;
    }

    public function setEffectiveLifeYears(int|float|null $effectiveLifeYears): self
    {
        $this->effectiveLifeYears = $effectiveLifeYears;

        return $this;
    }

    public function getDepreciationCalculationMethod(): ?string
    {
        return $this->depreciationCalculationMethod;
    }

    public function setDepreciationCalculationMethod(?string $depreciationCalculationMethod): self
    {
        $this->depreciationCalculationMethod = $depreciationCalculationMethod;

        return $this;
    }

    public function getDepreciableObjectId(): ?string
    {
        return $this->depreciableObjectId;
    }

    public function setDepreciableObjectId(?string $depreciableObjectId): self
    {
        $this->depreciableObjectId = $depreciableObjectId;

        return $this;
    }

    public function getDepreciableObjectType(): ?string
    {
        return $this->depreciableObjectType;
    }

    public function setDepreciableObjectType(?string $depreciableObjectType): self
    {
        $this->depreciableObjectType = $depreciableObjectType;

        return $this;
    }

    public function getBookEffectiveDateOfChangeId(): ?string
    {
        return $this->bookEffectiveDateOfChangeId;
    }

    public function setBookEffectiveDateOfChangeId(?string $bookEffectiveDateOfChangeId): self
    {
        $this->bookEffectiveDateOfChangeId = $bookEffectiveDateOfChangeId;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'depreciationMethod' => Field::string(),
            'averagingMethod' => Field::string(),
            'depreciationRate' => Field::number(),
            'effectiveLifeYears' => Field::number(),
            'depreciationCalculationMethod' => Field::string(),
            'depreciableObjectId' => Field::string(),
            'depreciableObjectType' => Field::string(),
            'bookEffectiveDateOfChangeId' => Field::string(),
        ];
    }
}
