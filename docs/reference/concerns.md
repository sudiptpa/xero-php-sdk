# Concerns reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Concerns\BuildsQueries](#concernsbuildsqueries)
- [Concerns\HasPagination](#concernshaspagination)
- [Concerns\InteractsWithBindings](#concernsinteractswithbindings)

## Concerns\BuildsQueries

[Source](../../src/Concerns/BuildsQueries.php)

### Public methods

- [`modifiedSince(\DateTimeInterface $date): static`](../../src/Concerns/BuildsQueries.php#L19)
- [`orderBy(string $field, string $direction = 'ASC'): static`](../../src/Concerns/BuildsQueries.php#L27)
- [`ids(string ...$ids): static`](../../src/Concerns/BuildsQueries.php#L35)
- [`unitDp(int $unitDp): static`](../../src/Concerns/BuildsQueries.php#L43)
- [`createdByApp(bool $createdByApp = true): static`](../../src/Concerns/BuildsQueries.php#L51)

## Concerns\HasPagination

[Source](../../src/Concerns/HasPagination.php)

### Public methods

- [`page(int $page): static`](../../src/Concerns/HasPagination.php#L13)
- [`perPage(int $perPage): static`](../../src/Concerns/HasPagination.php#L21)

## Concerns\InteractsWithBindings

[Source](../../src/Concerns/InteractsWithBindings.php)
