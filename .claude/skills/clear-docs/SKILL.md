---
name: clear-docs
description: >
  Writes and edits README, CHANGELOG, UPGRADE, and other markdown docs in plain,
  direct language. Use whenever creating or revising project documentation,
  PR descriptions, or release notes for this package.
---

Write documentation the way a senior developer explains something to a teammate over
coffee: short sentences, concrete nouns, no jargon.

## Rules

- Prefer everyday words over technical-sounding labels. "fix incorrect API calls" not
  "wire-contract fixes"; "request body" not "payload contract"; "broke" not
  "regressed"; "fixed" not "remediated".
- One idea per sentence. Cut connector phrases ("in order to", "it should be noted
  that", "this allows us to").
- Lead with what changed and why it matters to someone using the package, before
  any internal detail.
- Use bullet lists for multiple changes, not nested prose.
- Headings are short noun phrases ("New endpoints", "Breaking changes"), not
  compound jargon ("Wire-Contract Fixes", "Contract Realignment").
- Code examples over abstract description wherever possible.
- No filler adjectives ("robust", "powerful", "seamless", "comprehensive").
- Re-read any heading or title and ask: would a developer skimming this understand
  it in one glance without context? If not, simplify it.

## Where this applies

- `README.md`, `CHANGELOG.md`, `UPGRADE.md`
- PR titles and descriptions (`gh pr create` / `gh pr edit`)
- Commit message bodies (when a body is needed)
- `PROGRESS.md` chunk summaries
