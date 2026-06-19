<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PayTemplate extends Model
{
    /**
     * @param list<array<string, mixed>> $earningsLines
     * @param list<array<string, mixed>> $deductionLines
     * @param list<array<string, mixed>> $superLines
     * @param list<array<string, mixed>> $reimbursementLines
     * @param list<array<string, mixed>> $leaveLines
     */
    public function __construct(
        private array $earningsLines = [],
        private array $deductionLines = [],
        private array $superLines = [],
        private array $reimbursementLines = [],
        private array $leaveLines = [],
    ) {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getEarningsLines(): array
    {
        return $this->earningsLines;
    }

    /**
     * @param list<array<string, mixed>> $earningsLines
     */
    public function setEarningsLines(array $earningsLines): self
    {
        $this->earningsLines = $earningsLines;
        return $this;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getDeductionLines(): array
    {
        return $this->deductionLines;
    }

    /**
     * @param list<array<string, mixed>> $deductionLines
     */
    public function setDeductionLines(array $deductionLines): self
    {
        $this->deductionLines = $deductionLines;
        return $this;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getSuperLines(): array
    {
        return $this->superLines;
    }

    /**
     * @param list<array<string, mixed>> $superLines
     */
    public function setSuperLines(array $superLines): self
    {
        $this->superLines = $superLines;
        return $this;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getReimbursementLines(): array
    {
        return $this->reimbursementLines;
    }

    /**
     * @param list<array<string, mixed>> $reimbursementLines
     */
    public function setReimbursementLines(array $reimbursementLines): self
    {
        $this->reimbursementLines = $reimbursementLines;
        return $this;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getLeaveLines(): array
    {
        return $this->leaveLines;
    }

    /**
     * @param list<array<string, mixed>> $leaveLines
     */
    public function setLeaveLines(array $leaveLines): self
    {
        $this->leaveLines = $leaveLines;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'EarningsLines' => Field::array()->using('setEarningsLines'),
            'DeductionLines' => Field::array()->using('setDeductionLines'),
            'SuperLines' => Field::array()->using('setSuperLines'),
            'ReimbursementLines' => Field::array()->using('setReimbursementLines'),
            'LeaveLines' => Field::array()->using('setLeaveLines'),
        ];
    }
}
