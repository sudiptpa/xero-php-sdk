# HTTP reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Http\FakeTransport](#httpfaketransport)
- [Http\NativeTransport](#httpnativetransport)
- [Http\PendingRequest](#httppendingrequest)
- [Http\Request](#httprequest)
- [Http\Response](#httpresponse)
- [Http\ResponseErrorMapper](#httpresponseerrormapper)
- [Http\Transport](#httptransport)

## Http\FakeTransport

[Source](../../src/Http/FakeTransport.php)

### Public methods

- [`push(\Sujip\Xero\Http\Response $response): Sujip\Xero\Http\FakeTransport`](../../src/Http/FakeTransport.php#L21)
- [`send(\Sujip\Xero\Http\Request $request): Sujip\Xero\Http\Response`](../../src/Http/FakeTransport.php#L28)
- [`requests(): array`](../../src/Http/FakeTransport.php#L42)

## Http\NativeTransport

[Source](../../src/Http/NativeTransport.php)

### Public methods

- [`__construct(int $timeout = 30, int $connectTimeout = 10)`](../../src/Http/NativeTransport.php#L12)
- [`send(\Sujip\Xero\Http\Request $request): Sujip\Xero\Http\Response`](../../src/Http/NativeTransport.php#L18)

## Http\PendingRequest

[Source](../../src/Http/PendingRequest.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $method, string $path)`](../../src/Http/PendingRequest.php#L31)
- [`withQuery(array $query): Sujip\Xero\Http\PendingRequest`](../../src/Http/PendingRequest.php#L41)
- [`withJson(array $json): Sujip\Xero\Http\PendingRequest`](../../src/Http/PendingRequest.php#L52)
- [`withBody(string $body): Sujip\Xero\Http\PendingRequest`](../../src/Http/PendingRequest.php#L60)
- [`withHeaders(array $headers): Sujip\Xero\Http\PendingRequest`](../../src/Http/PendingRequest.php#L71)
- [`acceptJson(): Sujip\Xero\Http\PendingRequest`](../../src/Http/PendingRequest.php#L79)
- [`contentTypeJson(): Sujip\Xero\Http\PendingRequest`](../../src/Http/PendingRequest.php#L84)
- [`modifiedSince(\DateTimeInterface $date): Sujip\Xero\Http\PendingRequest`](../../src/Http/PendingRequest.php#L89)
- [`withoutTenant(): Sujip\Xero\Http\PendingRequest`](../../src/Http/PendingRequest.php#L98)
- [`send(): Sujip\Xero\Http\Response`](../../src/Http/PendingRequest.php#L106)

## Http\Request

[Source](../../src/Http/Request.php)

### Public methods

- [`__construct(string $method, string $path, array $headers = array (
), array $query = array (
), ?array $json = NULL, ?string $body = NULL, bool $includeTenantHeader = true, string $baseUri = '')`](../../src/Http/Request.php#L14)
- [`withBaseUri(string $baseUri): Sujip\Xero\Http\Request`](../../src/Http/Request.php#L26)
- [`mergeHeaders(array $headers): Sujip\Xero\Http\Request`](../../src/Http/Request.php#L43)
- [`withoutTenantHeader(): Sujip\Xero\Http\Request`](../../src/Http/Request.php#L57)
- [`url(): string`](../../src/Http/Request.php#L71)

## Http\Response

[Source](../../src/Http/Response.php)

### Public methods

- [`__construct(int $status, array $headers = array (
), string $body = '')`](../../src/Http/Response.php#L14)
- [`json(): array`](../../src/Http/Response.php#L24)
- [`header(string $name, ?string $default = NULL): ?string`](../../src/Http/Response.php#L33)

## Http\ResponseErrorMapper

[Source](../../src/Http/ResponseErrorMapper.php)

### Public methods

- [`map(\Sujip\Xero\Http\Response $response): Sujip\Xero\Exceptions\RequestException`](../../src/Http/ResponseErrorMapper.php#L15)

## Http\Transport

[Source](../../src/Http/Transport.php)

### Public methods

- [`send(\Sujip\Xero\Http\Request $request): Sujip\Xero\Http\Response`](../../src/Http/Transport.php#L9)
