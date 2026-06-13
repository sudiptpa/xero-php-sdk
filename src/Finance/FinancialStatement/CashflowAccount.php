<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CashflowAccount extends Model
{
    private ?string $accountId = null;

    private ?string $accountType = null;

    private ?string $accountClass = null;

    private ?string $code = null;

    private ?string $name = null;

    private ?string $reportingCode = null;

    private int|float|null $total = null;

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(?string $accountId): self
    {
        $this->accountId = $accountId;

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

    public function getAccountClass(): ?string
    {
        return $this->accountClass;
    }

    public function setAccountClass(?string $accountClass): self
    {
        $this->accountClass = $accountClass;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'accountId' => Field::string(),
            'accountType' => Field::string(),
            'accountClass' => Field::string(),
            'code' => Field::string(),
            'name' => Field::string(),
            'reportingCode' => Field::string(),
            'total' => Field::number(),
        ];
    }
}
