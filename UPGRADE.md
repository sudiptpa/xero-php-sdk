# Upgrade Guide

## Upgrading To 2.0

Version `2.0` keeps the fluent SDK style, but includes a few intentional breaking changes.

## Type Renames

Update these imports and type references:

- `Sujip\Xero\Support\Contracts\SerializesForRequest`
  - is now `Sujip\Xero\Support\Contracts\SerializesRequest`
- `Sujip\Xero\Support\PaginatedResult`
  - is now `Sujip\Xero\Support\PaginatedCollection`

## Projects Payload Changes

Projects request payloads now follow the official Xero Projects schema more closely.

### Project Create/Update

Projects now use documented request keys such as:

- `name`
- `contactId`
- `estimateAmount`
- `deadlineUtc`

This means project write helpers now align with the official schema instead of the older package-side payload shape.

### Task Create/Update

Tasks now use documented request keys such as:

- `name`
- `chargeType`
- `estimateMinutes`
- `rate`

`rate` is now serialized as the documented amount-object shape.

### Time Entry Create/Update

Time entries now use documented request keys such as:

- `taskId`
- `userId`
- `dateUtc`
- `duration`
- `description`

## What Does Not Intend To Change

The normal fluent SDK usage is intended to remain stable.

Examples:

- `$xero->accounting()->contacts()->get()`
- `$xero->accounting()->invoices()->create()->using(...)->save()`
- `$xero->projects()->tasks('project-id')->create()->name(...)->save()`

Most applications should only need to update:

- direct imports of the renamed support types
- any code that depended on the old serialized Projects payload arrays

## Official Source

Projects payload decisions in this release follow the official Xero OpenAPI source:

- `https://github.com/XeroAPI/Xero-OpenAPI/blob/master/xero-projects.yaml`
