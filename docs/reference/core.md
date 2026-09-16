# Core reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Client](#client)
- [Context](#context)
- [Xero](#xero)

## Client

[Source](../../src/Client.php)

### Public methods

- [`__construct(\Sujip\Xero\Context $context, ?\Sujip\Xero\Http\Transport $transport = NULL)`](../../src/Client.php#L27)
- [`tenant(string $tenantId): Sujip\Xero\Client`](../../src/Client.php#L34)
- [`withTransport(\Sujip\Xero\Http\Transport $transport): Sujip\Xero\Client`](../../src/Client.php#L39)
- [`usingNativeTransport(int $timeout = 30, int $connectTimeout = 10): Sujip\Xero\Client`](../../src/Client.php#L44)
- [`withToken(\Sujip\Xero\Auth\Token $token): Sujip\Xero\Client`](../../src/Client.php#L49)
- [`accounting(): Sujip\Xero\Accounting\Accounting`](../../src/Client.php#L61)
- [`assets(): Sujip\Xero\Assets\Assets`](../../src/Client.php#L66)
- [`files(): Sujip\Xero\Files\Files`](../../src/Client.php#L71)
- [`projects(): Sujip\Xero\Projects\Projects`](../../src/Client.php#L76)
- [`payroll(): Sujip\Xero\Payroll\Payroll`](../../src/Client.php#L81)
- [`identity(): Sujip\Xero\Identity\Identity`](../../src/Client.php#L86)
- [`webhooks(): Sujip\Xero\Webhooks\Webhooks`](../../src/Client.php#L91)
- [`finance(): Sujip\Xero\Finance\Finance`](../../src/Client.php#L96)
- [`appStore(): Sujip\Xero\AppStore\AppStore`](../../src/Client.php#L101)
- [`context(): Sujip\Xero\Context`](../../src/Client.php#L106)
- [`get(string $path): Sujip\Xero\Http\PendingRequest`](../../src/Client.php#L111)
- [`post(string $path): Sujip\Xero\Http\PendingRequest`](../../src/Client.php#L116)
- [`put(string $path): Sujip\Xero\Http\PendingRequest`](../../src/Client.php#L121)
- [`patch(string $path): Sujip\Xero\Http\PendingRequest`](../../src/Client.php#L126)
- [`delete(string $path): Sujip\Xero\Http\PendingRequest`](../../src/Client.php#L131)
- [`send(\Sujip\Xero\Http\Request $request): Sujip\Xero\Http\Response`](../../src/Client.php#L136)

## Context

[Source](../../src/Context.php)

### Public methods

- [`__construct(string $accessToken, ?string $tenantId = NULL, string $baseUri = 'https://api.xero.com')`](../../src/Context.php#L9)
- [`make(string $accessToken, ?string $tenantId = NULL, string $baseUri = 'https://api.xero.com'): Sujip\Xero\Context`](../../src/Context.php#L16)
- [`tenant(string $tenantId): Sujip\Xero\Context`](../../src/Context.php#L24)
- [`authHeaders(): array`](../../src/Context.php#L32)
- [`tenantHeaders(): array`](../../src/Context.php#L43)

## Xero

[Source](../../src/Xero.php)

### Public methods

- [`withAccessToken(string $accessToken, ?\Sujip\Xero\Http\Transport $transport = NULL): Sujip\Xero\Client`](../../src/Xero.php#L16)
- [`withToken(\Sujip\Xero\Auth\Token $token, ?\Sujip\Xero\Http\Transport $transport = NULL): Sujip\Xero\Client`](../../src/Xero.php#L24)
- [`authorizationUrl(string $clientId, string $redirectUri, array $scopes, string $state, ?string $codeChallenge = NULL, string $codeChallengeMethod = 'S256'): string`](../../src/Xero.php#L32)
- [`oauth2(string $clientId, ?string $clientSecret = NULL, ?string $redirectUri = NULL): Sujip\Xero\Auth\OAuth2Client`](../../src/Xero.php#L43)
- [`webhookVerifier(string $signingKey): Sujip\Xero\Webhooks\WebhookVerifier`](../../src/Xero.php#L51)
- [`pkce(): Sujip\Xero\Auth\Pkce`](../../src/Xero.php#L56)
