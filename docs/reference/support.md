# Support reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Support\AttachmentDetail](#supportattachmentdetail)
- [Support\Field](#supportfield)
- [Support\Headers](#supportheaders)
- [Support\InvoiceAddress](#supportinvoiceaddress)
- [Support\Json](#supportjson)
- [Support\Model](#supportmodel)
- [Support\PaginatedCollection](#supportpaginatedcollection)
- [Support\ResourceCollection](#supportresourcecollection)
- [Support\ScopeRequirements](#supportscoperequirements)
- [Support\ValidationError](#supportvalidationerror)

## Support\AttachmentDetail

[Source](../../src/Support/AttachmentDetail.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `AttachmentID` | string or null | `()` |
| `FileName` | string or null | `()` |
| `Url` | string or null | `()` |
| `MimeType` | string or null | `()` |
| `ContentLength` | int, float, or null | `()` |
| `IncludeOnline` | bool or null | `()` |

### Public methods

- [`getAttachmentID(): ?string`](../../src/Support/AttachmentDetail.php#L21)
- [`setAttachmentID(?string $attachmentID): Sujip\Xero\Support\AttachmentDetail`](../../src/Support/AttachmentDetail.php#L26)
- [`getFileName(): ?string`](../../src/Support/AttachmentDetail.php#L33)
- [`setFileName(?string $fileName): Sujip\Xero\Support\AttachmentDetail`](../../src/Support/AttachmentDetail.php#L38)
- [`getUrl(): ?string`](../../src/Support/AttachmentDetail.php#L45)
- [`setUrl(?string $url): Sujip\Xero\Support\AttachmentDetail`](../../src/Support/AttachmentDetail.php#L50)
- [`getMimeType(): ?string`](../../src/Support/AttachmentDetail.php#L57)
- [`setMimeType(?string $mimeType): Sujip\Xero\Support\AttachmentDetail`](../../src/Support/AttachmentDetail.php#L62)
- [`getContentLength(): ?int`](../../src/Support/AttachmentDetail.php#L69)
- [`setContentLength(?int $contentLength): Sujip\Xero\Support\AttachmentDetail`](../../src/Support/AttachmentDetail.php#L74)
- [`getIncludeOnline(): ?bool`](../../src/Support/AttachmentDetail.php#L81)
- [`setIncludeOnline(?bool $includeOnline): Sujip\Xero\Support\AttachmentDetail`](../../src/Support/AttachmentDetail.php#L86)

## Support\Field

[Source](../../src/Support/Field.php)

### Public methods

- [`string(): Sujip\Xero\Support\Field`](../../src/Support/Field.php#L16)
- [`number(): Sujip\Xero\Support\Field`](../../src/Support/Field.php#L21)
- [`boolean(): Sujip\Xero\Support\Field`](../../src/Support/Field.php#L26)
- [`array(): Sujip\Xero\Support\Field`](../../src/Support/Field.php#L31)
- [`object(string $class): Sujip\Xero\Support\Field`](../../src/Support/Field.php#L36)
- [`many(string $class): Sujip\Xero\Support\Field`](../../src/Support/Field.php#L41)
- [`using(string $method): Sujip\Xero\Support\Field`](../../src/Support/Field.php#L46)

## Support\Headers

[Source](../../src/Support/Headers.php)

### Public methods

- [`idempotency(?string $key): array`](../../src/Support/Headers.php#L12)

## Support\InvoiceAddress

[Source](../../src/Support/InvoiceAddress.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `InvoiceAddressType` | string or null | `()` |
| `AddressLine1` | string or null | `()` |
| `AddressLine2` | string or null | `()` |
| `AddressLine3` | string or null | `()` |
| `AddressLine4` | string or null | `()` |
| `City` | string or null | `()` |
| `Region` | string or null | `()` |
| `PostalCode` | string or null | `()` |
| `Country` | string or null | `()` |

### Public methods

- [`getInvoiceAddressType(): ?string`](../../src/Support/InvoiceAddress.php#L29)
- [`setInvoiceAddressType(?string $invoiceAddressType): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L34)
- [`getAddressLine1(): ?string`](../../src/Support/InvoiceAddress.php#L41)
- [`setAddressLine1(?string $addressLine1): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L46)
- [`getAddressLine2(): ?string`](../../src/Support/InvoiceAddress.php#L53)
- [`setAddressLine2(?string $addressLine2): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L58)
- [`getAddressLine3(): ?string`](../../src/Support/InvoiceAddress.php#L65)
- [`setAddressLine3(?string $addressLine3): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L70)
- [`getAddressLine4(): ?string`](../../src/Support/InvoiceAddress.php#L77)
- [`setAddressLine4(?string $addressLine4): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L82)
- [`getCity(): ?string`](../../src/Support/InvoiceAddress.php#L89)
- [`setCity(?string $city): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L94)
- [`getRegion(): ?string`](../../src/Support/InvoiceAddress.php#L101)
- [`setRegion(?string $region): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L106)
- [`getPostalCode(): ?string`](../../src/Support/InvoiceAddress.php#L113)
- [`setPostalCode(?string $postalCode): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L118)
- [`getCountry(): ?string`](../../src/Support/InvoiceAddress.php#L125)
- [`setCountry(?string $country): Sujip\Xero\Support\InvoiceAddress`](../../src/Support/InvoiceAddress.php#L130)
- [`toRequest(): array`](../../src/Support/InvoiceAddress.php#L158)

## Support\Json

[Source](../../src/Support/Json.php)

### Public methods

- [`encode(array $value): string`](../../src/Support/Json.php#L14)
- [`encodeList(array $value): string`](../../src/Support/Json.php#L24)
- [`decodeObject(string $value): array`](../../src/Support/Json.php#L34)
- [`decode(string $value): mixed`](../../src/Support/Json.php#L55)
- [`extractList(array $payload, string $key): array`](../../src/Support/Json.php#L66)
- [`extractRows(array $payload): array`](../../src/Support/Json.php#L95)
- [`extractFirst(array $payload, string $key): ?array`](../../src/Support/Json.php#L116)
- [`extractObject(array $payload, string $key): array`](../../src/Support/Json.php#L125)
- [`extractFirstOrObject(array $payload, string $listKey, string $objectKey): ?array`](../../src/Support/Json.php#L145)
- [`ensureAvailable(): void`](../../src/Support/Json.php#L150)

## Support\Model

[Source](../../src/Support/Model.php)

### Public methods

- [`fill(array $payload): static`](../../src/Support/Model.php#L14)

## Support\PaginatedCollection

[Source](../../src/Support/PaginatedCollection.php)

### Public methods

- [`__construct(\Sujip\Xero\Support\ResourceCollection $items, ?int $page = NULL, ?int $perPage = NULL, array $meta = array (
))`](../../src/Support/PaginatedCollection.php#L16)

## Support\ResourceCollection

[Source](../../src/Support/ResourceCollection.php)

### Public methods

- [`__construct(array $items)`](../../src/Support/ResourceCollection.php#L21)
- [`all(): array`](../../src/Support/ResourceCollection.php#L29)
- [`first(): mixed`](../../src/Support/ResourceCollection.php#L37)
- [`count(): int`](../../src/Support/ResourceCollection.php#L42)
- [`getIterator(): Traversable`](../../src/Support/ResourceCollection.php#L47)

## Support\ScopeRequirements

[Source](../../src/Support/ScopeRequirements.php)

### Public methods

- [`__construct(array $broad = array (
), array $granular = array (
))`](../../src/Support/ScopeRequirements.php#L13)

## Support\ValidationError

[Source](../../src/Support/ValidationError.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Message` | string or null | `setMessage()` |

### Public methods

- [`__construct(?string $message = NULL)`](../../src/Support/ValidationError.php#L9)
- [`getMessage(): ?string`](../../src/Support/ValidationError.php#L14)
- [`setMessage(?string $message): Sujip\Xero\Support\ValidationError`](../../src/Support/ValidationError.php#L19)
