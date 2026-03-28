<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

final class PayrollSettings
{
    /**
     * @param list<array<string, mixed>> $accounts
     * @param list<array<string, mixed>> $trackingCategories
     */
    public function __construct(
        private array $accounts = [],
        private array $trackingCategories = [],
    ) {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getAccounts(): array { return $this->accounts; }
    /**
     * @param list<array<string, mixed>> $accounts
     */
    public function setAccounts(array $accounts): self { $this->accounts = $accounts; return $this; }
    /**
     * @return list<array<string, mixed>>
     */
    public function getTrackingCategories(): array { return $this->trackingCategories; }
    /**
     * @param list<array<string, mixed>> $trackingCategories
     */
    public function setTrackingCategories(array $trackingCategories): self { $this->trackingCategories = $trackingCategories; return $this; }
    /**
     * @return array<string, mixed>
     */
    /**
     */
}
