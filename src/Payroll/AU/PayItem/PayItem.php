<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayItem;

final class PayItem
{
    /**
     * @param list<array<string, mixed>> $earningsRates
     * @param list<array<string, mixed>> $deductionTypes
     * @param list<array<string, mixed>> $leaveTypes
     * @param list<array<string, mixed>> $reimbursementTypes
     * @param list<array<string, mixed>> $superannuationTypes
     */
    public function __construct(
        private array $earningsRates = [],
        private array $deductionTypes = [],
        private array $leaveTypes = [],
        private array $reimbursementTypes = [],
        private array $superannuationTypes = [],
    ) {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getEarningsRates(): array { return $this->earningsRates; }
    /**
     * @param list<array<string, mixed>> $earningsRates
     */
    public function setEarningsRates(array $earningsRates): self { $this->earningsRates = $earningsRates; return $this; }
    /**
     * @return list<array<string, mixed>>
     */
    public function getDeductionTypes(): array { return $this->deductionTypes; }
    /**
     * @param list<array<string, mixed>> $deductionTypes
     */
    public function setDeductionTypes(array $deductionTypes): self { $this->deductionTypes = $deductionTypes; return $this; }
    /**
     * @return list<array<string, mixed>>
     */
    public function getLeaveTypes(): array { return $this->leaveTypes; }
    /**
     * @param list<array<string, mixed>> $leaveTypes
     */
    public function setLeaveTypes(array $leaveTypes): self { $this->leaveTypes = $leaveTypes; return $this; }
    /**
     * @return list<array<string, mixed>>
     */
    public function getReimbursementTypes(): array { return $this->reimbursementTypes; }
    /**
     * @param list<array<string, mixed>> $reimbursementTypes
     */
    public function setReimbursementTypes(array $reimbursementTypes): self { $this->reimbursementTypes = $reimbursementTypes; return $this; }
    /**
     * @return list<array<string, mixed>>
     */
    public function getSuperannuationTypes(): array { return $this->superannuationTypes; }
    /**
     * @param list<array<string, mixed>> $superannuationTypes
     */
    public function setSuperannuationTypes(array $superannuationTypes): self { $this->superannuationTypes = $superannuationTypes; return $this; }
    /**
     * @return array<string, mixed>
     */
    /**
     * @param array<string, mixed> $raw
     */
}
