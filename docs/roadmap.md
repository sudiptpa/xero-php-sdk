# Roadmap

## Current state

All API families are implemented and passing the field-level audit against the OpenAPI specs. See the status pages for details:

- [package-status.md](package-status.md)
- [implementation-status.md](implementation-status.md)

## Release rule

Do not tag a release until:

- `openapi/schema_audit.py` reports zero findings across all audited models
- `openapi/audit.py` is clean
- the pre-release checklist in PROGRESS.md is done

## Quality bar

Every completed resource must have:

- a fluent public API
- typed models that match the OpenAPI spec exactly
- tests
- scope metadata
