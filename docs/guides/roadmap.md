# Roadmap

## Current state

The package covers every endpoint and model field in the official Xero OpenAPI
specs (Accounting, Payroll AU/NZ/UK, Files, Assets, Projects, Finance, App Store,
Identity, Webhooks). There are no known gaps.

## Staying correct

The audit CI workflow (`.github/workflows/audit.yml`) downloads the latest Xero
OpenAPI specs on every push and pull request, then runs two checks:

- every spec endpoint must be implemented (`.github/scripts/audit.py`)
- every model field name and type must match the spec exactly
  (`.github/scripts/schema_audit.py`)

Either check failing blocks the merge. Spec drift from Xero (a renamed field, a new
endpoint, a changed type) gets caught automatically instead of going unnoticed.

## When Xero changes the spec

If the audit starts failing after an upstream spec update:

1. read the failing endpoint or field finding
2. fix the SDK to match the new spec exactly
3. document the change in `UPGRADE.md` and `CHANGELOG.md` if it breaks a public
   method signature or removes a field
4. cut a new major version if the fix is a breaking change

## Out of scope

These are intentional, not gaps:

- async support (this is a synchronous SDK by design)
- a Laravel or Symfony integration package (use the SDK directly)
- bundling Guzzle or another HTTP client (bring your own via the `Transport`
  interface)
