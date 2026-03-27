# Roadmap

This is the current delivery order for the package.

It is intentionally opinionated. The goal is not to touch every Xero endpoint quickly. The goal is to make each added domain feel reliable, fluent, and worth switching to.

## Current Position

The package now has the core foundation in place and nine real API slices:

- Accounting
- Files
- Assets
- Projects
- Payroll AU
- Payroll NZ
- Payroll UK
- Finance
- App Store

That means the next work should be about finishing and polishing, not proving the structure works.

## Release View

If the goal is a first serious public release, use [release-checklist.md](release-checklist.md) as the practical source of truth.

The roadmap below is still useful for sequencing work, but the checklist is the better guide for deciding what must be finished before tagging a release.

## Next

### 1. Docs And Scope Polish

- add clear broad and granular scope notes to every implemented resource page
- tighten the quick-start path from auth to tenant selection to first API call
- keep the coverage map honest as implementation grows

### 2. Payroll And Projects Long-Tail Pass

These families are now real enough that the next work should be selective:

- review the live payroll docs for the next useful AU, NZ, and UK helper gaps
- review the live Projects docs for the next useful lifecycle or reporting helpers
- keep the public API taste calm and consistent instead of mirroring every endpoint mechanically

### 3. Files And Assets Long-Tail Pass

Files and Assets are in a good place now, but they still have room for a focused cleanup pass:

- close the next useful lifecycle helpers from the live docs
- keep the docs and scope guidance aligned with the actual supported surface

### 4. Focused Accounting Re-Audit

Accounting is already broad. The next accounting work should only come from a live docs sweep:

- find any remaining helper gaps that still matter in application code
- avoid reopening broad endpoint sprawl unless the docs audit clearly justifies it

### 5. Webhooks And Integration Examples

The webhook core is now strong enough that any remaining work should stay small:

- add framework-specific examples only if they genuinely help adoption
- avoid turning the SDK into a framework adapter layer

### 6. Whole-Product Audit Mode

The package has enough real surface now that planning should be driven by the live parity audit rather than by intuition.

Use [xero-parity-audit.md](xero-parity-audit.md) as the source of truth for the next batches.

## Quality Bar

Every new resource should ship with:

- fluent public API
- typed models and payloads
- tests
- scope metadata
- human-written docs

If one of those is missing, the feature is not done.
