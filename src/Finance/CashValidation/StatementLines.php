<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class StatementLines extends Model
{
    private int|float|null $unreconciledAmountPos = null;

    private int|float|null $unreconciledAmountNeg = null;

    private ?int $unreconciledLines = null;

    private int|float|null $avgDaysUnreconciledPos = null;

    private int|float|null $avgDaysUnreconciledNeg = null;

    private ?string $earliestUnreconciledTransaction = null;

    private ?string $latestUnreconciledTransaction = null;

    private int|float|null $deletedAmount = null;

    private int|float|null $totalAmount = null;

    private ?DataSource $dataSource = null;

    private ?string $earliestReconciledTransaction = null;

    private ?string $latestReconciledTransaction = null;

    private int|float|null $reconciledAmountPos = null;

    private int|float|null $reconciledAmountNeg = null;

    private ?int $reconciledLines = null;

    private int|float|null $totalAmountPos = null;

    private int|float|null $totalAmountNeg = null;

    public function getUnreconciledAmountPos(): int|float|null
    {
        return $this->unreconciledAmountPos;
    }

    public function setUnreconciledAmountPos(int|float|null $unreconciledAmountPos): self
    {
        $this->unreconciledAmountPos = $unreconciledAmountPos;

        return $this;
    }

    public function getUnreconciledAmountNeg(): int|float|null
    {
        return $this->unreconciledAmountNeg;
    }

    public function setUnreconciledAmountNeg(int|float|null $unreconciledAmountNeg): self
    {
        $this->unreconciledAmountNeg = $unreconciledAmountNeg;

        return $this;
    }

    public function getUnreconciledLines(): ?int
    {
        return $this->unreconciledLines;
    }

    public function setUnreconciledLines(?int $unreconciledLines): self
    {
        $this->unreconciledLines = $unreconciledLines;

        return $this;
    }

    public function getAvgDaysUnreconciledPos(): int|float|null
    {
        return $this->avgDaysUnreconciledPos;
    }

    public function setAvgDaysUnreconciledPos(int|float|null $avgDaysUnreconciledPos): self
    {
        $this->avgDaysUnreconciledPos = $avgDaysUnreconciledPos;

        return $this;
    }

    public function getAvgDaysUnreconciledNeg(): int|float|null
    {
        return $this->avgDaysUnreconciledNeg;
    }

    public function setAvgDaysUnreconciledNeg(int|float|null $avgDaysUnreconciledNeg): self
    {
        $this->avgDaysUnreconciledNeg = $avgDaysUnreconciledNeg;

        return $this;
    }

    public function getEarliestUnreconciledTransaction(): ?string
    {
        return $this->earliestUnreconciledTransaction;
    }

    public function setEarliestUnreconciledTransaction(?string $earliestUnreconciledTransaction): self
    {
        $this->earliestUnreconciledTransaction = $earliestUnreconciledTransaction;

        return $this;
    }

    public function getLatestUnreconciledTransaction(): ?string
    {
        return $this->latestUnreconciledTransaction;
    }

    public function setLatestUnreconciledTransaction(?string $latestUnreconciledTransaction): self
    {
        $this->latestUnreconciledTransaction = $latestUnreconciledTransaction;

        return $this;
    }

    public function getDeletedAmount(): int|float|null
    {
        return $this->deletedAmount;
    }

    public function setDeletedAmount(int|float|null $deletedAmount): self
    {
        $this->deletedAmount = $deletedAmount;

        return $this;
    }

    public function getTotalAmount(): int|float|null
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(int|float|null $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getDataSource(): ?DataSource
    {
        return $this->dataSource;
    }

    public function setDataSource(?DataSource $dataSource): self
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    public function getEarliestReconciledTransaction(): ?string
    {
        return $this->earliestReconciledTransaction;
    }

    public function setEarliestReconciledTransaction(?string $earliestReconciledTransaction): self
    {
        $this->earliestReconciledTransaction = $earliestReconciledTransaction;

        return $this;
    }

    public function getLatestReconciledTransaction(): ?string
    {
        return $this->latestReconciledTransaction;
    }

    public function setLatestReconciledTransaction(?string $latestReconciledTransaction): self
    {
        $this->latestReconciledTransaction = $latestReconciledTransaction;

        return $this;
    }

    public function getReconciledAmountPos(): int|float|null
    {
        return $this->reconciledAmountPos;
    }

    public function setReconciledAmountPos(int|float|null $reconciledAmountPos): self
    {
        $this->reconciledAmountPos = $reconciledAmountPos;

        return $this;
    }

    public function getReconciledAmountNeg(): int|float|null
    {
        return $this->reconciledAmountNeg;
    }

    public function setReconciledAmountNeg(int|float|null $reconciledAmountNeg): self
    {
        $this->reconciledAmountNeg = $reconciledAmountNeg;

        return $this;
    }

    public function getReconciledLines(): ?int
    {
        return $this->reconciledLines;
    }

    public function setReconciledLines(?int $reconciledLines): self
    {
        $this->reconciledLines = $reconciledLines;

        return $this;
    }

    public function getTotalAmountPos(): int|float|null
    {
        return $this->totalAmountPos;
    }

    public function setTotalAmountPos(int|float|null $totalAmountPos): self
    {
        $this->totalAmountPos = $totalAmountPos;

        return $this;
    }

    public function getTotalAmountNeg(): int|float|null
    {
        return $this->totalAmountNeg;
    }

    public function setTotalAmountNeg(int|float|null $totalAmountNeg): self
    {
        $this->totalAmountNeg = $totalAmountNeg;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'unreconciledAmountPos' => Field::number(),
            'unreconciledAmountNeg' => Field::number(),
            'unreconciledLines' => Field::number(),
            'avgDaysUnreconciledPos' => Field::number(),
            'avgDaysUnreconciledNeg' => Field::number(),
            'earliestUnreconciledTransaction' => Field::string(),
            'latestUnreconciledTransaction' => Field::string(),
            'deletedAmount' => Field::number(),
            'totalAmount' => Field::number(),
            'dataSource' => Field::object(DataSource::class),
            'earliestReconciledTransaction' => Field::string(),
            'latestReconciledTransaction' => Field::string(),
            'reconciledAmountPos' => Field::number(),
            'reconciledAmountNeg' => Field::number(),
            'reconciledLines' => Field::number(),
            'totalAmountPos' => Field::number(),
            'totalAmountNeg' => Field::number(),
        ];
    }
}
