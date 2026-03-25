<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU;

use Sujip\Xero\Payroll\Shared\PayrollRegion;

final readonly class PayrollAU extends PayrollRegion
{
    public function employees(): Employees
    {
        return new Employees($this->client);
    }
}
