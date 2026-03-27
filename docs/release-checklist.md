# Release Checklist

This is the short list for getting the package into a first serious public release.

It is split into two groups:

- must finish before release
- nice to have after release

## Must Finish Before Release

- do one final live-docs sweep and close any small missing helpers that still stand out in real use
- tighten scope notes across the implemented docs pages so broad versus granular scopes are clear
- make the quick-start path feel complete: auth, tenant selection, first successful call, webhook verification
- add contribution guidance
- add release notes or changelog guidance
- make coverage reporting part of the package workflow, not just local verification
- do one full package review for naming, consistency, and public API taste
- clean package metadata and release-facing README details
- tag the first stable release only after the full verification pass is green

## Nice To Have After Release

- deeper long-tail coverage in Projects
- deeper long-tail coverage in Payroll AU, NZ, and UK
- more Files and Assets convenience helpers
- another focused Accounting helper sweep if the live docs still show useful gaps
- more framework integration examples around webhook handling
- more recipe-style docs for common Xero workflows

## Current Verification Baseline

At the current checkpoint, the package has already been verified with:

- PHPUnit passing
- PHPStan passing

That means the remaining work is mostly polish, release-readiness, and selective gap-closing rather than major architecture changes.
