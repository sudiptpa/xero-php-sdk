<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\Shared;

use Sujip\Xero\Client;

abstract readonly class PayrollRegion
{
    public function __construct(
        protected Client $client
    ) {
    }
}
