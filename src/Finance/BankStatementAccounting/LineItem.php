<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\BankStatementAccounting;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class LineItem extends Model
{
    private ?string $accountId = null;

    private ?string $reportingCode = null;

    private int|float|null $lineAmount = null;

    private ?string $accountType = null;

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(?string $accountId): self
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getReportingCode(): ?string
    {
        return $this->reportingCode;
    }

    public function setReportingCode(?string $reportingCode): self
    {
        $this->reportingCode = $reportingCode;

        return $this;
    }

    public function getLineAmount(): int|float|null
    {
        return $this->lineAmount;
    }

    public function setLineAmount(int|float|null $lineAmount): self
    {
        $this->lineAmount = $lineAmount;

        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(?string $accountType): self
    {
        $this->accountType = $accountType;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'accountId' => Field::string(),
            'reportingCode' => Field::string(),
            'lineAmount' => Field::number(),
            'accountType' => Field::string(),
        ];
    }
}
