# Package Status

This document is the live package-to-docs review for the SDK.

Review date: 27 March 2026

The goal here is not to claim perfect coverage too early. The goal is to be honest about where the package stands against the current official Xero docs, family by family, and to use that as the next planning input.

## Source Set

The audit is based on the current official Xero docs and overview pages:

- [Getting Started Guide](https://developer.xero.com/documentation/getting-started-guide/)
- [Accounting API Overview](https://developer.xero.com/documentation/api/accounting/overview)
- [Files API Overview](https://developer.xero.com/documentation/api/files/overview)
- [Assets API Overview](https://developer.xero.com/documentation/api/assets/overview)
- [Projects API Overview](https://developer.xero.com/documentation/api/projects/overview)
- [Payroll AU API Overview](https://developer.xero.com/documentation/api/payrollau/overview)
- [Payroll NZ API Overview](https://developer.xero.com/documentation/api/payrollnz/overview)
- [Payroll UK API Overview](https://developer.xero.com/documentation/api/payrolluk/overview)
- [Finance API Overview](https://developer.xero.com/documentation/api/finance/overview)
- [Xero App Store API Overview](https://developer.xero.com/documentation/api/xero-app-store/overview)
- [Webhooks Overview](https://developer.xero.com/documentation/guides/webhooks/overview/)

## Summary

| Area | Audit status | Notes |
| --- | --- | --- |
| Auth and Identity | Strong working coverage | Core OAuth lifecycle, PKCE, custom connections, token exchange, refresh, tenant discovery, connection management, and tenant-aware request handling are present |
| Webhooks | Strong working coverage | Signature verification, header-array helpers, payload parsing, and event-query ergonomics are in place; remaining work is mostly docs depth |
| Accounting | Broad coverage, still partial | Strongest family in the package today; the remaining work is now low-traffic helper depth rather than major resource absence |
| Files | Strong working coverage | Reads, uploads, deletes, folders, inbox, associations, object-side lookup, and association counts are covered |
| Assets | Near-complete overview coverage | The overview-level Assets methods are covered: assets, asset types, settings, and documented query parameters |
| Projects | Strong working coverage | The core documented overview methods are covered: projects, users, tasks, time entries, and patch/update flows |
| Payroll AU | Strong working coverage | Employees, payroll calendars, super funds, leave applications, pay items, pay runs, payslips, timesheets, and settings are covered with meaningful helper support |
| Payroll NZ | Strong working coverage | Employees, leave helpers, payment-method helpers, tax and working-pattern helpers, leave setup, opening balances, leave types, pay run calendars, pay runs, timesheets, settings, and statutory deductions are covered |
| Payroll UK | Strong working coverage | Employees, leave balances, statutory leave balance, leave records, payment-method helpers, pay run calendars, pay runs, payslips, timesheets, and settings helpers are covered |
| Finance | Strong working coverage | Core statements, cash validation, bank statement accounting, account usage, lock history, report history, and user activities are covered; note that Xero says Accounting Activities is being decommissioned effective April 6, 2026 |
| App Store | Complete current core coverage | The currently documented subscription and usage-record flows are covered |

## Family Matrix

| Family | Package status | Tested | Docs | Main remaining gaps |
| --- | --- | --- | --- | --- |
| Accounting | Broad coverage, still partial | Yes | Yes | final long-tail helper sweep and any remaining low-traffic attachment variants from the live docs |
| Files | Strong working coverage | Yes | Yes | remaining work is now convenience and long-tail helper depth rather than obvious overview-level endpoint gaps |
| Assets | Near-complete overview coverage | Yes | Yes | no obvious missing overview-level methods from the current Assets docs; remaining work is deeper lifecycle polish |
| Projects | Strong working coverage | Yes | Yes | no obvious missing overview-level methods from the current Projects docs; remaining work is helper depth rather than core endpoint absence |
| Payroll AU | Strong working coverage | Yes | Yes | remaining documented AU helper surfaces are now narrower long-tail payroll helpers rather than obvious payrun gaps |
| Payroll NZ | Strong working coverage | Yes | Yes | remaining documented NZ helper surfaces beyond the current employee-side leave, tax, working-pattern, setup, and opening-balance helpers |
| Payroll UK | Strong working coverage | Yes | Yes | remaining documented UK helper surfaces beyond the current leave, payrun, payslip, and settings coverage |
| Finance | Strong working coverage | Yes | Yes | remaining work is polish and any future finance-surface expansion rather than obvious missing overview-level reads |
| App Store | Complete current core coverage | Yes | Yes | no obvious missing overview-level methods from the current App Store docs |
| Auth / Identity | Strong working coverage | Yes | Yes | stronger scope guidance, clearer first-run integration docs, and more tenant-connect polish |
| Webhooks | Strong working coverage | Yes | Yes | more framework-specific examples if we decide they are worth documenting |

## What Looks Strong Today

- Accounting is the clearest reason to adopt the package today.
- Multi-country payroll is now real, not aspirational.
- Files and Assets are now past the “placeholder family” stage.
- Finance and App Store are no longer stubs and now reflect their documented core surfaces more faithfully.
- The package has a consistent shape across domains instead of one-off endpoint styles.

## Exact Gaps Found In The Live Sweep

These are the clearest remaining gaps after the latest live-docs pass and exact gap-closing work:

- Payroll NZ:
  - deeper employee-side leave write helpers where we choose to expose them
- Payroll UK:
  - remaining employee-side leave and statutory long-tail helpers
- Payroll AU:
  - remaining payroll-specific long-tail helpers beyond the current payrun and payslip coverage
For Files, Assets, Projects, Finance, and App Store, the current overview-level method surface now looks substantially covered. The remaining work there is mainly depth, convenience, and docs polish.

## Recommended Next Order

1. Tighten scope notes and first-run docs.
2. Revisit payroll only for the remaining country-specific long-tail helpers.
3. Re-run the live docs sweep for any final low-traffic Accounting helpers.
4. Add framework-specific webhook examples only if they materially improve adoption.

## Current Conclusion

The package has real breadth across the main Xero product surface, and several families are now close to overview-level parity.

It is still not accurate to call it full docs coverage yet. The remaining work is now exact enough to track family by family.

## How To Use This Audit

When choosing the next batch, prefer this order:

1. close gaps inside already-strong families
2. tighten scope clarity and first-run docs
3. only then add new long-tail helpers

That keeps the package feeling more complete with each release instead of just broader.
