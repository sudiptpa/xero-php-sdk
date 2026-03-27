# Release Checklist

This is the short list for getting the package into a first serious public release.

The release rule is simple:

- do not release until the documented Xero surface is covered to the standard we want
- do not call the package finished while the live docs still show clear missing helpers we plan to support

## Must Finish Before Release

- do the final live-docs sweep and close the remaining documented gaps we still care about
- tighten scope notes across the implemented docs pages so broad versus granular scopes are clear
- make the quick-start path feel complete: auth, tenant selection, first successful call, webhook verification
- add contribution guidance
- add release notes or changelog guidance
- make coverage reporting part of the package workflow, not just local verification
- do one full package review for naming, consistency, and public API taste
- clean package metadata and release-facing README details
- tag the first stable release only after the full verification pass is green and the docs coverage review is complete

## Nice To Have After Release

- more recipe-style docs for common Xero workflows
- more framework integration examples around webhook handling
- more convenience helpers only if real usage shows they are worth the extra surface

## Current Verification Baseline

At the current checkpoint, the package has already been verified with:

- PHPUnit passing
- PHPStan passing

That means the remaining work is mostly exact gap-closing, docs cleanup, and release preparation rather than major architecture changes.
