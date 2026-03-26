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
| Webhooks | Strong base, light ergonomics | Signature verification and payload parsing are in place, but richer event ergonomics and framework-facing integration helpers are still light |
| Accounting | Broad coverage | Strongest family in the package today and the closest to docs-driven parity |
| Files | Strong working slice | Reads, uploads, deletes, folders, inbox, associations, and object-side lookup are covered |
| Assets | Strong working slice | Assets, asset types, settings, and documented collection query parameters are covered |
| Projects | Strong working slice | Core project, task, user, and time-entry surface is covered, including the documented project patch flow |
| Payroll AU | Strong working slice | Employees, leave applications, pay items, pay runs, timesheets, and settings are covered with meaningful helper support |
| Payroll NZ | Strong working slice | Employees, leave helpers, leave types, pay run calendars, pay runs, timesheets, and settings are covered |
| Payroll UK | Strong working slice | Employees, leave balances, statutory leave balance, pay run calendars, pay runs, and timesheets are covered |
| Finance | Strong working slice | Read-only finance statements, accounting activity views, and cash validation are covered |
| App Store | Strong working slice | Subscription lookup and usage-record flows are covered, including the documented subscription-item usage path |

## Family Matrix

| Family | Package status | Tested | Docs | Main remaining gaps |
| --- | --- | --- | --- | --- |
| Accounting | Broad coverage | Yes | Yes | helper parity, sharper scope notes, and a live docs sidebar re-audit for any remaining long-tail gaps |
| Files | Strong working slice | Yes | Yes | any remaining association/file convenience helpers and folder/file long-tail endpoints |
| Assets | Strong working slice | Yes | Yes | deeper asset lifecycle helpers beyond list, lookup, create, types, settings, and query filtering |
| Projects | Strong working slice | Yes | Yes | deeper parity against the live Projects docs outside the core resources and any higher-value helper flows |
| Payroll AU | Strong working slice | Yes | Yes | remaining documented AU helper surfaces and payroll-specific long-tail resources |
| Payroll NZ | Strong working slice | Yes | Yes | remaining documented NZ helper surfaces, especially employee-side leave setup and related helpers |
| Payroll UK | Strong working slice | Yes | Yes | remaining documented UK helper surfaces and payroll-specific long-tail resources |
| Finance | Strong working slice | Yes | Yes | additional finance views such as user activities, lock history, and bank statement accounting if they justify the API surface |
| App Store | Strong working slice | Yes | Yes | broader subscription and partner workflow parity only if the live docs surface expands beyond the current billing endpoints |
| Auth / Identity | Strong working slice | Yes | Yes | stronger scope guidance, clearer first-run integration docs, and more tenant-connect polish |
| Webhooks | Strong base, light ergonomics | Yes | Partial | more event ergonomics, framework-facing integration helpers, and better webhook documentation flow |

## What Looks Strong Today

- Accounting is the clearest reason to adopt the package today.
- Multi-country payroll is now real, not aspirational.
- Files and Assets are now past the “placeholder family” stage.
- Finance and App Store are no longer stubs and now reflect their documented core surfaces more faithfully.
- The package has a consistent shape across domains instead of one-off endpoint styles.

## What Is Still Missing

The biggest remaining work is no longer one giant missing family. It is the accumulation of already-strong families that still need polish and long-tail parity:

- webhook and framework integration polish
- sharper scope documentation across the whole package
- a tighter “first successful integration” path in the docs
- deeper Projects parity
- deeper payroll parity inside `AU`, `NZ`, and `UK`
- selective remaining Files and Assets lifecycle helpers
- any remaining small Accounting helper gaps found by a fresh live docs sweep

## Recommended Next Order

1. Whole-package scope and quick-start polish
The code surface is broad enough now that docs clarity is the next force multiplier: tighter quick-starts, clearer tenant selection flows, and stronger broad-versus-granular scope notes.

2. Webhook and integration ergonomics
The webhook core is solid, but the package still needs a smoother framework-facing integration story and richer event ergonomics.

3. Payroll helper parity pass
Review the live `AU`, `NZ`, and `UK` docs again and close the next most useful remaining country-specific gaps, especially where employee-side helpers are still thin.

4. Projects and Files/Assets long-tail depth
After the docs and webhook polish, use the live docs to close the most useful remaining helper gaps in Projects, Files, and Assets.

5. Focused Accounting re-audit
Do one more deliberate Accounting sweep against the live sidebar and only add what still clearly improves practical integrations.

## Current Conclusion

The package is no longer in scaffold territory.

It now has real breadth across the main Xero product surface, and many families have moved beyond “first slice” status. It is still more accurate to call it a strong, production-shaped multi-family SDK than a full docs-parity SDK.

The next phase should be deliberate gap-closing, not random breadth.

## How To Use This Audit

When choosing the next batch, prefer this order:

1. close gaps inside already-strong families
2. tighten scope clarity and first-run docs
3. only then add new long-tail helpers

That keeps the package feeling more complete with each release instead of just broader.
