# Contributing

Thanks for taking the time to contribute.

This package is aiming for a few things at once:

- modern PHP
- a fluent public API
- broad Xero coverage
- docs that read like they were written by a maintainer
- predictable release quality

If you want to help, please keep those goals in mind.

## Ground Rules

- target `php:^8.2`
- keep runtime dependencies at zero
- prefer small, clear additions over clever abstractions
- match the existing domain-first structure
- keep public API naming calm and readable
- add tests with every code change
- update docs when the public API changes

## Project Shape

The package is organized by API family first:

- `src/Accounting`
- `src/Files`
- `src/Assets`
- `src/Projects`
- `src/Payroll`
- `src/Finance`
- `src/AppStore`
- `src/Auth`
- `src/Webhooks`

Inside a family, prefer nested resource folders where that makes the public API and internal structure clearer.

## Local Setup

```bash
composer install
```

## Checks

Run the main checks before opening a pull request:

```bash
composer test
composer stan
composer coverage
```

If you only changed docs, say that clearly in the pull request.

## Coding Notes

- use strict types
- use typed rich models and explicit request objects
- keep model naming close to the Xero docs field names
- prefer `getContactID()` / `setContactID(...)` style over invented synonyms
- use `Factory` classes for response mapping
- use `Serializer` classes for request mapping
- avoid raw array access in public model APIs
- avoid turning models into heavy active-record objects
- keep transport and persistence concerns in the resource layer
- only add comments where they save real reading time

## Docs Style

Please keep docs direct and plain.

Avoid:

- filler marketing language
- generic AI-sounding introductions
- padded explanations that do not help package users

Prefer:

- short examples
- practical caveats
- exact scope notes where relevant
- clear wording about what is supported and what is not

## Pull Requests

Good pull requests usually include:

- a short problem statement
- the change itself
- tests
- docs updates if the API changed
- any relevant Xero docs links

If the change is based on a specific Xero endpoint or guide, link it in the pull request so the reasoning is easy to review.
