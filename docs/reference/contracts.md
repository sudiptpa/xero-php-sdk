# Contracts reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Contracts\DefinesScopes](#contractsdefinesscopes)
- [Contracts\PaginatesResults](#contractspaginatesresults)
- [Contracts\SerializesRequest](#contractsserializesrequest)

## Contracts\DefinesScopes

[Source](../../src/Contracts/DefinesScopes.php)

### Public methods

- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Contracts/DefinesScopes.php#L11)

## Contracts\PaginatesResults

[Source](../../src/Contracts/PaginatesResults.php)

### Public methods

- [`page(int $page): static`](../../src/Contracts/PaginatesResults.php#L9)
- [`perPage(int $perPage): static`](../../src/Contracts/PaginatesResults.php#L11)

## Contracts\SerializesRequest

[Source](../../src/Contracts/SerializesRequest.php)

### Public methods

- [`toRequest(): array`](../../src/Contracts/SerializesRequest.php#L12)
