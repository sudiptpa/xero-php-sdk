<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CurrentStatement extends Model
{
    private ?string $startDate = null;

    private ?string $endDate = null;

    private int|float|null $startBalance = null;

    private int|float|null $endBalance = null;

    private ?string $importedDateTimeUtc = null;

    private ?string $importSourceType = null;

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStartBalance(): int|float|null
    {
        return $this->startBalance;
    }

    public function setStartBalance(int|float|null $startBalance): self
    {
        $this->startBalance = $startBalance;

        return $this;
    }

    public function getEndBalance(): int|float|null
    {
        return $this->endBalance;
    }

    public function setEndBalance(int|float|null $endBalance): self
    {
        $this->endBalance = $endBalance;

        return $this;
    }

    public function getImportedDateTimeUtc(): ?string
    {
        return $this->importedDateTimeUtc;
    }

    public function setImportedDateTimeUtc(?string $importedDateTimeUtc): self
    {
        $this->importedDateTimeUtc = $importedDateTimeUtc;

        return $this;
    }

    public function getImportSourceType(): ?string
    {
        return $this->importSourceType;
    }

    public function setImportSourceType(?string $importSourceType): self
    {
        $this->importSourceType = $importSourceType;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'startDate' => Field::string(),
            'endDate' => Field::string(),
            'startBalance' => Field::number(),
            'endBalance' => Field::number(),
            'importedDateTimeUtc' => Field::string(),
            'importSourceType' => Field::string(),
        ];
    }
}
