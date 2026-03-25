<?php

declare(strict_types=1);

namespace Sujip\Xero\Support\Contracts;

use Sujip\Xero\Support\ScopeRequirements;

interface DefinesScopes
{
    public function scopes(): ScopeRequirements;
}
