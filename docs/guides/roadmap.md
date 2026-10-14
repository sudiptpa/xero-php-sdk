# Roadmap

## Current state

The package supports Accounting, Payroll AU/NZ/UK, Files, Assets, Projects,
Finance, App Store, Identity, and Webhooks.

## Staying correct

Before each release, compare the package with the official Xero OpenAPI specs.
Review:

- supported endpoints and SDK operations
- model field names and types
- request methods, paths, bodies, and response shapes

Repository CI runs formatting, static analysis, tests, and coverage. Keep
OpenAPI snapshots and review tools local.

## When Xero changes the spec

When Xero publishes a new spec version:

1. Compare it with the currently supported version.
2. Review every added, removed, or changed endpoint and field.
3. Update the SDK, tests, and public docs.
4. Document breaking changes in `UPGRADE.md` and `CHANGELOG.md`.
5. Use a major release when a required correction breaks existing callers.

## Out of scope

These are intentional, not gaps:

- async support (this is a synchronous SDK by design)
- a Laravel or Symfony integration package (use the SDK directly)
- bundling Guzzle or another HTTP client (bring your own via the `Transport`
  interface)
