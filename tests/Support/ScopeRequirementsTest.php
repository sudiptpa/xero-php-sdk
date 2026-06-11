<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Support;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Support\ScopeRequirements;

final class ScopeRequirementsTest extends TestCase
{
    public function test_it_defaults_to_empty_scope_lists(): void
    {
        $requirements = new ScopeRequirements();

        self::assertSame([], $requirements->broad);
        self::assertSame([], $requirements->granular);
    }

    public function test_it_exposes_broad_and_granular_scopes(): void
    {
        $requirements = new ScopeRequirements(
            broad: ['accounting.transactions'],
            granular: ['accounting.transactions.read']
        );

        self::assertSame(['accounting.transactions'], $requirements->broad);
        self::assertSame(['accounting.transactions.read'], $requirements->granular);
    }
}
