# SDK reference

This reference lists the public SDK types, model fields, and method signatures
available in `src/`. Use it with the guides when you need exact class names,
field names, return types, or source links.

Scalar model fields accept null. Model setters mutate the object; request and
query builders generally return a clone. Consult each guide for builder behavior.
Generic array and collection types are shown below method signatures where the
source declares them. Parent links cover inherited methods.

| Area | Types | Model fields | Public methods |
| --- | ---: | ---: | ---: |
| [Accounting](accounting.md) | 144 | 678 | 2278 |
| [App Store](appstore.md) | 9 | 36 | 99 |
| [Assets](assets.md) | 10 | 51 | 158 |
| [Auth](auth.md) | 8 | 0 | 45 |
| [Concerns](concerns.md) | 3 | 0 | 7 |
| [Contracts](contracts.md) | 3 | 0 | 4 |
| [Core](core.md) | 3 | 0 | 32 |
| [Exceptions](exceptions.md) | 8 | 0 | 1 |
| [Files](files.md) | 14 | 27 | 155 |
| [Finance](finance.md) | 46 | 211 | 459 |
| [HTTP](http.md) | 7 | 0 | 25 |
| [Identity](identity.md) | 3 | 7 | 23 |
| [Payroll](payroll.md) | 2 | 0 | 5 |
| [Payroll AU](payroll-au.md) | 31 | 173 | 525 |
| [Payroll NZ](payroll-nz.md) | 38 | 153 | 558 |
| [Payroll UK](payroll-uk.md) | 41 | 201 | 628 |
| [Projects](projects.md) | 14 | 51 | 228 |
| [Support](support.md) | 10 | 16 | 60 |
| [Webhooks](webhooks.md) | 4 | 11 | 63 |
| Total | 398 | 1615 | 5353 |

Counts cover declarations in this release. Constructors and public methods
declared on each type are included. Inherited methods are listed on the declaring type.

## API specs

The September 2026 update uses [Xero OpenAPI 19.0.0](https://github.com/XeroAPI/Xero-OpenAPI/tree/448060d7829cae23166a2e443be48c2f2422280f).
Field spelling, required request values, enums, and endpoint-specific rules come
from those specs. Not every schema property is writable. Setting a model field
does not guarantee that a write request sends it.

## Guides

- [Accounting](../guides/accounting.md)
- [App Store](../guides/app-store.md)
- [Assets](../guides/assets.md)
- [Auth](../guides/auth.md)
- [Files](../guides/files.md)
- [Finance](../guides/finance.md)
- [Payroll AU](../guides/payroll-au.md)
- [Payroll NZ](../guides/payroll-nz.md)
- [Payroll UK](../guides/payroll-uk.md)
- [Projects](../guides/projects.md)
- [Webhooks](../guides/webhooks.md)
- [Release process](../guides/release-process.md)
