<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\BankStatementAccounting;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Statement extends Model
{
    private ?string $statementId = null;

    private ?string $startDate = null;

    private ?string $endDate = null;

    private ?string $importedDateTimeUtc = null;

    private ?string $importSource = null;

    private int|float|null $startBalance = null;

    private int|float|null $endBalance = null;

    private int|float|null $indicativeStartBalance = null;

    private int|float|null $indicativeEndBalance = null;

    /**
     * @var list<StatementLine>
     */
    private array $statementLines = [];

    public function getStatementId(): ?string
    {
        return $this->statementId;
    }

    public function setStatementId(?string $statementId): self
    {
        $this->statementId = $statementId;

        return $this;
    }

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

    public function getImportedDateTimeUtc(): ?string
    {
        return $this->importedDateTimeUtc;
    }

    public function setImportedDateTimeUtc(?string $importedDateTimeUtc): self
    {
        $this->importedDateTimeUtc = $importedDateTimeUtc;

        return $this;
    }

    public function getImportSource(): ?string
    {
        return $this->importSource;
    }

    public function setImportSource(?string $importSource): self
    {
        $this->importSource = $importSource;

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

    public function getIndicativeStartBalance(): int|float|null
    {
        return $this->indicativeStartBalance;
    }

    public function setIndicativeStartBalance(int|float|null $indicativeStartBalance): self
    {
        $this->indicativeStartBalance = $indicativeStartBalance;

        return $this;
    }

    public function getIndicativeEndBalance(): int|float|null
    {
        return $this->indicativeEndBalance;
    }

    public function setIndicativeEndBalance(int|float|null $indicativeEndBalance): self
    {
        $this->indicativeEndBalance = $indicativeEndBalance;

        return $this;
    }

    /**
     * @return list<StatementLine>
     */
    public function getStatementLines(): array
    {
        return $this->statementLines;
    }

    /**
     * @param list<StatementLine> $statementLines
     */
    public function setStatementLines(array $statementLines): self
    {
        $this->statementLines = $statementLines;

        return $this;
    }

    public function addStatementLine(StatementLine $statementLine): self
    {
        $this->statementLines[] = $statementLine;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'statementId' => Field::string(),
            'startDate' => Field::string(),
            'endDate' => Field::string(),
            'importedDateTimeUtc' => Field::string(),
            'importSource' => Field::string(),
            'startBalance' => Field::number(),
            'endBalance' => Field::number(),
            'indicativeStartBalance' => Field::number(),
            'indicativeEndBalance' => Field::number(),
            'statementLines' => Field::many(StatementLine::class),
        ];
    }
}
