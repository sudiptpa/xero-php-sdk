# Payroll reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Payroll\Payroll](#payrollpayroll)
- [Payroll\Shared\PayrollRegion](#payrollsharedpayrollregion)

## Payroll\Payroll

[Source](../../src/Payroll/Payroll.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/Payroll.php#L14)
- [`au(): Sujip\Xero\Payroll\AU\PayrollAU`](../../src/Payroll/Payroll.php#L19)
- [`nz(): Sujip\Xero\Payroll\NZ\PayrollNZ`](../../src/Payroll/Payroll.php#L24)
- [`uk(): Sujip\Xero\Payroll\UK\PayrollUK`](../../src/Payroll/Payroll.php#L29)

## Payroll\Shared\PayrollRegion

[Source](../../src/Payroll/Shared/PayrollRegion.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Payroll/Shared/PayrollRegion.php#L11)
