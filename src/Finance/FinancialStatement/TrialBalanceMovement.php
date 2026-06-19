<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TrialBalanceMovement extends Model
{
    private int|float|null $debits = null;

    private int|float|null $credits = null;

    private ?TrialBalanceEntry $movement = null;

    private int|float|null $signedMovement = null;

    public function getDebits(): int|float|null
    {
        return $this->debits;
    }

    public function setDebits(int|float|null $debits): self
    {
        $this->debits = $debits;

        return $this;
    }

    public function getCredits(): int|float|null
    {
        return $this->credits;
    }

    public function setCredits(int|float|null $credits): self
    {
        $this->credits = $credits;

        return $this;
    }

    public function getMovement(): ?TrialBalanceEntry
    {
        return $this->movement;
    }

    public function setMovement(?TrialBalanceEntry $movement): self
    {
        $this->movement = $movement;

        return $this;
    }

    public function getSignedMovement(): int|float|null
    {
        return $this->signedMovement;
    }

    public function setSignedMovement(int|float|null $signedMovement): self
    {
        $this->signedMovement = $signedMovement;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'debits' => Field::number(),
            'credits' => Field::number(),
            'movement' => Field::object(TrialBalanceEntry::class),
            'signedMovement' => Field::number(),
        ];
    }
}
