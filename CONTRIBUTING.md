# Contributing

This file defines the package coding standard.

Use it for code, tests, docs, examples, and reviews.

## Source of truth

- The OpenAPI specs in `openapi/` are the primary source of truth for every field name, type, path, and HTTP verb
- Use official Xero field names and resource names exactly as they appear in the spec
- Corroborate against `developer.xero.com` and the live API when the spec is ambiguous
- Do not invent public API shapes that are not in the official spec

## PHP

- target `php:>=8.2 <8.6`
- use `declare(strict_types=1);`
- use typed properties, parameters, and return values
- use modern PHP features when they improve clarity
- do not add features only for style

Rules:

- use `readonly` for stable value objects only
- do not use `readonly` for rich models with setters
- keep nullability explicit
- use constructor promotion when it improves readability

## Framework

- the package must stay framework-agnostic
- follow a fluent API design similar to Laravel without using framework contracts
- do not introduce hard dependencies on Laravel components
- do not assume service containers, facades, helpers, or service providers
- do not require wrappers for Laravel, Symfony, or other frameworks
- package code must work well in plain PHP first
- framework users should be able to adopt the package directly
- prefer package-native abstractions over framework-coupled abstractions

## Public API

- public API must be fluent, readable, and predictable
- public API must stay close to Xero docs naming
- public API must prefer rich models over arrays
- public API can follow a fluent Laravel-like shape without using framework contracts

### Naming

- keep Xero field identity: use spec field names exactly, converting to PHP getter/setter style
- prefer `getContactID()` / `setContactID(...)` for PascalCase spec fields
- prefer `getContactId()` / `setContactId(...)` for camelCase spec fields
- prefer `getLineItems()` / `setLineItems(...)` / `addLineItem(...)`

The Xero API uses both PascalCase (Accounting) and camelCase (Projects, AppStore, Finance) field names. Match the spec exactly.

### Rich models

Rich models are the public data shape.

Use rich models for:

- returned resources
- create and update inputs
- nested Xero structures like contacts, line items, phones, addresses, tracking options, and similar documented objects

Rich models must:

- keep private state
- expose getters and setters
- stay close to Xero docs naming

Rich models must not:

- expose public raw properties
- expose array access as normal usage
- expose public `fromArray()` or `fromPayload()` methods

### Arrays

Arrays are allowed only inside SDK internals.

Allowed:

- HTTP response decoding
- internal request payload building
- documented edge endpoints where no good rich-model write shape exists yet

Not allowed as the normal public shape:

- array-driven public APIs
- docs that promote raw payload arrays first
- model classes that behave like array wrappers

### Resources

Resources are responsible for:

- endpoint paths
- query options
- pagination
- request orchestration
- internal mapping between transport data and rich models

Resources should stay:

- small
- fluent
- easy to read

Avoid:

- giant service objects
- DSL-heavy APIs
- abstractions that hide normal Xero behavior
- framework-specific contracts or helpers in the public API

## Internal architecture

- keep internal code simple
- keep mapping code inside the SDK
- keep mapping code close to the relevant resource or payload class
- keep nested object construction inside the SDK

Do not make these part of the package standard:

- public `Factory` classes
- public `Serializer` classes
- public mapping helpers that introduce framework-style contracts

## Coverage

When adding support:

1. check the official Xero OpenAPI spec
2. implement the feature in package style
3. add or update tests
4. update the docs

Do not leave docs claiming support that the code does not have.

## Tests and verification

Default checks:

```bash
composer test
composer stan
```

Rules:

- code changes need tests unless already covered
- docs-only changes do not require rerunning tests, but say so clearly
- do not say a batch is clean without running relevant checks
- start with focused checks when the change is local
- run broader checks when the batch stabilizes

## Docs

Docs must be:

- direct
- practical
- short where possible
- clear about what exists today

Docs rules:

- show real API examples only
- prefer short examples
- keep wording simple
- explain scope requirements when useful
- keep wording product-facing, not process-facing

Avoid overusing words like:

- `builder`
- `factory`
- `serializer`
- `slice`
- `parity`

Use simpler words when possible.

## Style

- prefer ASCII unless the file already uses Unicode meaningfully
- keep comments short and useful
- prefer clear code over clever code
- keep methods and files easy to read
- preserve the domain-first structure

## Package shape

Primary package areas:

- `src/Accounting`
- `src/Files`
- `src/Assets`
- `src/Projects`
- `src/Payroll`
- `src/Finance`
- `src/AppStore`
- `src/Auth`
- `src/Webhooks`

Prefer nested resource folders when they make the public API clearer.

## Checklist

Before marking work done, check:

- official Xero OpenAPI spec was used
- public API follows package naming rules
- rich models are used where appropriate
- arrays are not the public default
- tests were updated or checked
- docs were updated if the API changed
