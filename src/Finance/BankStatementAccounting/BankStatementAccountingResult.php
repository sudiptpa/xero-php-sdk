<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\BankStatementAccounting;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BankStatementAccountingResult extends Model
{
    private ?string $bankAccountId = null;

    private ?string $bankAccountName = null;

    private ?string $bankAccountCurrencyCode = null;

    /**
     * @var list<Statement>
     */
    private array $statements = [];

    public function getBankAccountId(): ?string
    {
        return $this->bankAccountId;
    }

    public function setBankAccountId(?string $bankAccountId): self
    {
        $this->bankAccountId = $bankAccountId;

        return $this;
    }

    public function getBankAccountName(): ?string
    {
        return $this->bankAccountName;
    }

    public function setBankAccountName(?string $bankAccountName): self
    {
        $this->bankAccountName = $bankAccountName;

        return $this;
    }

    public function getBankAccountCurrencyCode(): ?string
    {
        return $this->bankAccountCurrencyCode;
    }

    public function setBankAccountCurrencyCode(?string $bankAccountCurrencyCode): self
    {
        $this->bankAccountCurrencyCode = $bankAccountCurrencyCode;

        return $this;
    }

    /**
     * @return list<Statement>
     */
    public function getStatements(): array
    {
        return $this->statements;
    }

    /**
     * @param list<Statement> $statements
     */
    public function setStatements(array $statements): self
    {
        $this->statements = $statements;

        return $this;
    }

    public function addStatement(Statement $statement): self
    {
        $this->statements[] = $statement;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'bankAccountId' => Field::string(),
            'bankAccountName' => Field::string(),
            'bankAccountCurrencyCode' => Field::string(),
            'statements' => Field::many(Statement::class),
        ];
    }
}
