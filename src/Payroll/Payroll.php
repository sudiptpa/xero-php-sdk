<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll;

use Sujip\Xero\Client;
use Sujip\Xero\Payroll\AU\PayrollAU;
use Sujip\Xero\Payroll\NZ\PayrollNZ;
use Sujip\Xero\Payroll\UK\PayrollUK;

final readonly class Payroll
{
    public function __construct(
        private Client $client
    ) {
    }

    public function au(): PayrollAU
    {
        return new PayrollAU($this->client);
    }

    public function nz(): PayrollNZ
    {
        return new PayrollNZ($this->client);
    }

    public function uk(): PayrollUK
    {
        return new PayrollUK($this->client);
    }
}
