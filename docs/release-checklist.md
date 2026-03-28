# Release Checklist

Use this before tagging the first stable release.

## Before Release

- verify the package against the current Xero docs you intend to support
- review the README, quick start, and family docs from a user perspective
- confirm scope notes are accurate where they matter
- confirm package metadata is correct
- confirm changelog or release notes are ready
- run the full PHPUnit suite
- run PHPStan
- test install in a clean consumer app
- tag the release only after the verification pass is green

## After Release

- add more workflow recipes where they clearly help
- add more transport or framework integration examples where they earn their place
