# Roadmap

This is the current delivery order for the package.

It is intentionally opinionated. The goal is not to touch every Xero endpoint quickly. The goal is to make each added domain feel reliable, fluent, and worth switching to.

## Current Position

The package now has production-shaped foundations and three real API slices:

- Accounting
- Files
- Assets

That gives the project enough shape to stop thinking in scaffolds and start thinking in adoption.

## Next

### 1. Docs And Scope Polish

- add clear broad and granular scope notes to every implemented resource page
- tighten the quick-start path from auth to tenant selection to first API call
- keep the coverage map honest as implementation grows

### 2. Accounting Audit And Helpers

Accounting is now broad enough that the next job is not more random endpoints. It is to audit the live docs again and close the helper gaps that make mature integrations pleasant:

- remaining attachments and history surfaces
- report helper coverage review
- sharper scope notes per resource
- any small endpoint gaps still left in the Accounting sidebar

### 3. Projects

Projects should be the next serious API family.

Why this is next:

- it expands real package breadth
- it is distinct from Accounting, so it proves the architecture scales
- it is easier to shape well now than jumping straight into deep payroll coverage

### 4. Payroll Expansion

Payroll should keep the domain-first, country-second pattern:

- AU depth beyond employees
- NZ first real slice
- UK first real slice

### 5. Finance And App Store

These should come after the package has stronger adoption value in the more common surfaces.

## Quality Bar

Every new resource should ship with:

- fluent public API
- typed models and payloads
- tests
- scope metadata
- human-written docs

If one of those is missing, the feature is not done.
