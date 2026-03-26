# Xero Parity Audit

This document is the live package-to-docs audit for the SDK.

Audit date: 26 March 2026

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
| Auth and Identity | Strong working slice | Core OAuth lifecycle, PKCE, custom connections, token exchange, refresh, tenant discovery, connection management, and tenant-aware request handling are present |
| Webhooks | Strong working slice | Signature verification, header-array helpers, payload parsing, and event-query ergonomics are in place; remaining work is mostly docs depth |
| Accounting | Broad coverage, still partial | Strongest family in the package today; the remaining work is now low-traffic helper depth rather than major resource absence |
| Files | Strong working slice | Reads, uploads, deletes, folders, inbox, associations, object-side lookup, and association counts are covered |
| Assets | Near-complete overview slice | The overview-level Assets methods are covered: assets, asset types, settings, and documented query parameters |
| Projects | Strong working slice | The core documented overview methods are covered: projects, users, tasks, time entries, and patch/update flows |
| Payroll AU | Strong working slice | Employees, payroll calendars, super funds, leave applications, pay items, pay runs, timesheets, and settings are covered with meaningful helper support |
| Payroll NZ | Strong working slice | Employees, leave helpers, payment-method helpers, leave types, pay run calendars, pay runs, timesheets, settings, and statutory deductions are covered |
| Payroll UK | Strong working slice | Employees, leave balances, statutory leave balance, leave records, payment-method helpers, pay run calendars, pay runs, timesheets, and settings helpers are covered |
| Finance | Strong working slice | Core statements, cash validation, bank statement accounting, account usage, lock history, report history, and user activities are covered |
| App Store | Complete current core slice | The currently documented subscription and usage-record flows are covered |

## Family Matrix

| Family | Package status | Tested | Docs | Main remaining gaps |
| --- | --- | --- | --- | --- |
| Accounting | Broad coverage, still partial | Yes | Yes | final long-tail helper sweep and any remaining low-traffic attachment variants from the live docs |
| Files | Strong working slice | Yes | Yes | remaining work is now convenience and long-tail helper depth rather than obvious overview-level endpoint gaps |
| Assets | Near-complete overview slice | Yes | Yes | no obvious missing overview-level methods from the current Assets docs; remaining work is deeper lifecycle polish |
| Projects | Strong working slice | Yes | Yes | no obvious missing overview-level methods from the current Projects docs; remaining work is helper depth rather than core endpoint absence |
| Payroll AU | Strong working slice | Yes | Yes | remaining documented AU helper surfaces such as employee payslip-style endpoints and any other payroll-specific long-tail resources |
| Payroll NZ | Strong working slice | Yes | Yes | remaining documented NZ helper surfaces, especially employee-side leave setup, opening balances, and related write helpers |
| Payroll UK | Strong working slice | Yes | Yes | remaining documented UK helper surfaces and payroll-specific long-tail resources |
| Finance | Strong working slice | Yes | Yes | remaining work is polish and any future finance-surface expansion rather than obvious missing overview-level reads |
| App Store | Complete current core slice | Yes | Yes | no obvious missing overview-level methods from the current App Store docs |
| Auth / Identity | Strong working slice | Yes | Yes | stronger scope guidance, clearer first-run integration docs, and more tenant-connect polish |
| Webhooks | Strong working slice | Yes | Yes | more framework-specific examples if we decide they are worth documenting |

## What Looks Strong Today

- Accounting is the clearest reason to adopt the package today.
- Multi-country payroll is now real, not aspirational.
- Files and Assets are now past the “placeholder family” stage.
- Finance and App Store are no longer stubs and now reflect their documented core surfaces more faithfully.
- The package has a consistent shape across domains instead of one-off endpoint styles.

## Exact Gaps Found In The Live Sweep

These are the clearest remaining gaps after the latest live-docs pass and exact gap-closing work:

- Payroll NZ:
  - employee leave setup
  - employee opening balances
  - deeper employee-side leave write helpers where we choose to expose them
- Payroll UK:
  - remaining employee-side leave and statutory long-tail helpers
- Payroll AU:
  - remaining payroll-specific long-tail helpers such as payslip-style endpoints if we decide to expose them
For Files, Assets, Projects, Finance, and App Store, the current overview-level method surface now looks substantially covered. The remaining work there is mainly depth, convenience, and docs polish.

## Recommended Next Order

1. Tighten scope notes and first-run docs after the endpoint gaps are closed.
2. Revisit payroll only for the remaining country-specific long-tail helpers.
3. Re-run the live docs sweep for any final low-traffic Accounting helpers.
4. Add framework-specific webhook examples only if they materially improve adoption.

## Current Conclusion

The package has real breadth across the main Xero product surface, and several families are now close to overview-level parity.

It is still not accurate to call it full docs-parity yet. The remaining work is now exact enough to track family by family.

## How To Use This Audit

When choosing the next batch, prefer this order:

1. close gaps inside already-strong families
2. tighten scope clarity and first-run docs
3. only then add new long-tail helpers

That keeps the package feeling more complete with each release instead of just broader.
