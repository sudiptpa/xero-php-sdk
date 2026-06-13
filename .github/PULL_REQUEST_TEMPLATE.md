## What this changes

A short description of the change and why.

## Xero reference

For new or changed endpoints, name the spec source (OpenAPI path, method, schema)
the change is based on. The SDK does not guess contracts, so changes should be
backed by the spec, or by a documented corroboration (calcinai/xero-php or a
live demo-org call) where the spec is silent.

## Checklist

- [ ] Tests added or updated, suite passes (`composer test`)
- [ ] PHPStan max clean (`composer stan`)
- [ ] Formatting clean (`composer lint:check`)
- [ ] CHANGELOG updated for any user-facing change
- [ ] Breaking changes documented in UPGRADE.md
