<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BankStatement extends Model
{
    private ?StatementLines $statementLines = null;

    private ?CurrentStatement $currentStatement = null;

    public function getStatementLines(): ?StatementLines
    {
        return $this->statementLines;
    }

    public function setStatementLines(?StatementLines $statementLines): self
    {
        $this->statementLines = $statementLines;

        return $this;
    }

    public function getCurrentStatement(): ?CurrentStatement
    {
        return $this->currentStatement;
    }

    public function setCurrentStatement(?CurrentStatement $currentStatement): self
    {
        $this->currentStatement = $currentStatement;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'statementLines' => Field::object(StatementLines::class),
            'currentStatement' => Field::object(CurrentStatement::class),
        ];
    }
}
