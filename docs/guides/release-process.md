# Release process

Use this checklist for each release.

## Before tagging

1. Pull the latest Xero OpenAPI specs for the APIs covered by the SDK.
2. Compare the new specs with the current supported version.
3. Update endpoints, request bodies, response parsing, model fields, docs, and tests for every added, removed, or changed API surface.
4. Run the local endpoint and schema audits.
5. Run the full quality gate.
6. Verify live or sandbox reads where the API and account permissions allow it.
7. Update `CHANGELOG.md` and `UPGRADE.md` when behavior or public APIs change.

## Quality gate

```bash
composer validate --strict --no-check-publish
composer lint:check
composer stan
composer test
composer coverage
composer dump-autoload --optimize --strict-psr --dry-run
```

The release is not ready unless tests, static analysis, formatting, and coverage all pass.

## Versioning

Use patch releases for safe fixes, minor releases for additive public APIs, and major releases for renamed classes, moved namespaces, removed behavior, or corrected API behavior that can break existing callers.
