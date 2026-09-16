# Contributing

This file defines the package coding standard for source, tests, docs, examples, and reviews.

## Source of truth

- The official Xero OpenAPI specs at [github.com/XeroAPI/Xero-OpenAPI](https://github.com/XeroAPI/Xero-OpenAPI) are the primary source of truth for every field name, type, path, and HTTP verb.
- Use official Xero field names and resource names exactly as they appear in the spec.
- Corroborate against `developer.xero.com` and the live API when the spec is ambiguous.
- Do not invent public API shapes that are not in the official spec.

## PHP

- Target `php:>=8.2 <8.6`.
- Use `declare(strict_types=1);`.
- Use typed properties, parameters, and return values.
- Use modern PHP features when they improve clarity.
- Do not add features only for style.

Rules:

- Use `readonly` for stable value objects only.
- Do not use `readonly` for rich models with setters.
- Keep nullability explicit.
- Use constructor promotion when it improves readability.

## Framework

- The package must stay framework-agnostic.
- Follow a fluent API design similar to Laravel without using framework contracts.
- Do not introduce hard dependencies on Laravel components.
- Do not assume service containers, facades, helpers, or service providers.
- Do not require wrappers for Laravel, Symfony, or other frameworks.
- Package code must work well in plain PHP first.
- Framework users should be able to adopt the package directly.
- Prefer package-native abstractions over framework-coupled abstractions.

## Public API

- Public API must be fluent, readable, and predictable.
- Public API must stay close to Xero docs naming.
- Public API must prefer rich models over arrays.
- Public API can follow a fluent Laravel-like shape without using framework contracts.

### Naming

- Keep Xero field identity: use spec field names exactly, converting to PHP getter/setter style.
- Prefer `getContactID()` / `setContactID(...)` for PascalCase spec fields.
- Prefer `getContactId()` / `setContactId(...)` for camelCase spec fields.
- Prefer `getLineItems()` / `setLineItems(...)` / `addLineItem(...)`.

The Xero API uses both PascalCase fields, such as Accounting, and camelCase fields, such as Projects, AppStore, and Finance. Match the spec exactly.

### Rich models

Rich models are the public data shape.

Use rich models for:

- Returned resources.
- Create and update inputs.
- Nested Xero structures like contacts, line items, phones, addresses, tracking options, and similar documented objects.

Rich models must:

- Keep private state.
- Expose getters and setters.
- Stay close to Xero docs naming.

Rich models must not:

- Expose public raw properties.
- Expose array access as normal usage.
- Expose public `fromArray()` or `fromPayload()` methods.

### Arrays

Arrays are allowed only inside SDK internals.

Allowed:

- HTTP response decoding.
- Internal request payload building.
- Documented edge endpoints where no good rich-model write shape exists yet.

Not allowed as the normal public shape:

- Array-driven public APIs.
- Docs that promote raw payload arrays first.
- Model classes that behave like array wrappers.

### Resources

Resources are responsible for:

- Endpoint paths.
- Query options.
- Pagination.
- Request orchestration.
- Internal mapping between transport data and rich models.

Resources should stay:

- Small.
- Fluent.
- Easy to read.

Avoid:

- Giant service objects.
- DSL-heavy APIs.
- Abstractions that hide normal Xero behavior.
- Framework-specific contracts or helpers in the public API.

## Internal architecture

- Keep internal code simple.
- Keep mapping code inside the SDK.
- Keep mapping code close to the relevant resource or payload class.
- Keep nested object construction inside the SDK.
- Keep domain-specific behavior inside its domain.
- Keep common package primitives in top-level generic namespaces when they are part of the public surface.

Do not make these part of the package standard:

- Public `Factory` classes.
- Public `Serializer` classes.
- Public mapping helpers that introduce framework-style contracts.

## Coverage

When adding support:

1. Check the official Xero OpenAPI spec.
2. Implement the feature in package style.
3. Add or update tests.
4. Update the docs.

Do not leave docs claiming support that the code does not have.

## Tests and verification

Run these before opening a pull request:

```bash
composer validate --strict --no-check-publish
composer lint:check
composer stan
composer test
composer coverage
composer dump-autoload --optimize --strict-psr --dry-run
```

Coverage must stay at 100% for classes, methods, and lines. PHPStan and Pint must stay clean.

Rules:

- Code changes need tests unless already covered.
- Docs-only changes do not require rerunning tests, but say so clearly.
- Do not say a batch is clean without running relevant checks.
- Start with focused checks when the change is local.
- Run broader checks when the batch stabilizes.
- For API coverage work, verify endpoint paths, HTTP methods, request bodies, response shapes, field names, and field casing against the spec.

## Docs

Docs must be:

- Direct.
- Practical.
- Short where possible.
- Clear about what exists today.

Docs rules:

- Show real API examples only.
- Prefer short examples.
- Keep wording simple.
- Explain scope requirements when useful.
- Keep wording product-facing.
- Keep private process notes, unrelated packages, temporary tooling, and generated audit files out of public docs.

Avoid overusing words like:

- `builder`.
- `factory`.
- `serializer`.
- `slice`.
- `parity`.

Use simpler words when possible.

## Style

- Prefer ASCII unless the file already uses Unicode meaningfully.
- Keep comments short and useful.
- Prefer clear code over clever code.
- Keep methods and files easy to read.
- Preserve the domain-first structure.

## Package shape

Primary package areas:

- `src/Accounting`.
- `src/Files`.
- `src/Assets`.
- `src/Projects`.
- `src/Payroll`.
- `src/Finance`.
- `src/AppStore`.
- `src/Auth`.
- `src/Webhooks`.
- `src/Concerns`.
- `src/Contracts`.
- `src/Support`.

Prefer nested resource folders when they make the public API clearer.

## Repository hygiene

Commit source, tests, docs, and normal CI files only. Keep local credentials, OpenAPI snapshots, audit scripts, temporary files, and one-off tooling out of Git.

## Checklist

Before marking work done, check:

- Official Xero OpenAPI spec was used.
- Public API follows package naming rules.
- Rich models are used where appropriate.
- Arrays are not the public default.
- Tests were updated or checked.
- Docs were updated if the API changed.
- Public files are clean and production-facing.
