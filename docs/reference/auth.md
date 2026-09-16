# Auth reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Auth\ConnectedAccount](#authconnectedaccount)
- [Auth\ConnectionManager](#authconnectionmanager)
- [Auth\InMemoryTokenRepository](#authinmemorytokenrepository)
- [Auth\OAuth2](#authoauth2)
- [Auth\OAuth2Client](#authoauth2client)
- [Auth\Pkce](#authpkce)
- [Auth\Token](#authtoken)
- [Auth\TokenRepository](#authtokenrepository)

## Auth\ConnectedAccount

[Source](../../src/Auth/ConnectedAccount.php)

### Public methods

- [`__construct(\Sujip\Xero\Auth\Token $token, \Sujip\Xero\Identity\Connection $connection, \Sujip\Xero\Client $client)`](../../src/Auth/ConnectedAccount.php#L12)
- [`getToken(): Sujip\Xero\Auth\Token`](../../src/Auth/ConnectedAccount.php#L19)
- [`getConnection(): Sujip\Xero\Identity\Connection`](../../src/Auth/ConnectedAccount.php#L24)
- [`tenant(): Sujip\Xero\Client`](../../src/Auth/ConnectedAccount.php#L29)
- [`getClient(): Sujip\Xero\Client`](../../src/Auth/ConnectedAccount.php#L34)

## Auth\ConnectionManager

[Source](../../src/Auth/ConnectionManager.php)

### Public methods

- [`__construct(\Sujip\Xero\Auth\OAuth2Client $oauth2, \Sujip\Xero\Auth\TokenRepository $tokens, string $tokenKey = 'default')`](../../src/Auth/ConnectionManager.php#L13)
- [`authorizationUrl(array $scopes, string $state, ?string $codeChallenge = NULL): string`](../../src/Auth/ConnectionManager.php#L23)
- [`exchange(string $code, ?string $codeVerifier = NULL): Sujip\Xero\Auth\Token`](../../src/Auth/ConnectionManager.php#L28)
- [`refresh(): Sujip\Xero\Auth\Token`](../../src/Auth/ConnectionManager.php#L36)
- [`storedToken(): Sujip\Xero\Auth\Token`](../../src/Auth/ConnectionManager.php#L50)
- [`client(?\Sujip\Xero\Auth\Token $token = NULL): Sujip\Xero\Client`](../../src/Auth/ConnectionManager.php#L56)
- [`connections(?\Sujip\Xero\Auth\Token $token = NULL): array`](../../src/Auth/ConnectionManager.php#L64)
- [`connectTenant(string $tenantId, ?\Sujip\Xero\Auth\Token $token = NULL): Sujip\Xero\Auth\ConnectedAccount`](../../src/Auth/ConnectionManager.php#L73)
- [`exchangeAndConnect(string $code, string $tenantId, ?string $codeVerifier = NULL): Sujip\Xero\Auth\ConnectedAccount`](../../src/Auth/ConnectionManager.php#L86)
- [`disconnectConnection(string $connectionId, ?\Sujip\Xero\Auth\Token $token = NULL): bool`](../../src/Auth/ConnectionManager.php#L91)
- [`disconnectTenant(string $tenantId, ?\Sujip\Xero\Auth\Token $token = NULL): bool`](../../src/Auth/ConnectionManager.php#L99)
- [`customConnection(array $scopes = array (
)): Sujip\Xero\Client`](../../src/Auth/ConnectionManager.php#L113)

## Auth\InMemoryTokenRepository

[Source](../../src/Auth/InMemoryTokenRepository.php)

### Public methods

- [`get(string $key): ?\Sujip\Xero\Auth\Token`](../../src/Auth/InMemoryTokenRepository.php#L14)
- [`put(string $key, \Sujip\Xero\Auth\Token $token): void`](../../src/Auth/InMemoryTokenRepository.php#L19)

## Auth\OAuth2

[Source](../../src/Auth/OAuth2.php)

### Public methods

- [`authorizationUrl(string $clientId, string $redirectUri, array $scopes, string $state, ?string $codeChallenge = NULL, string $codeChallengeMethod = 'S256'): string`](../../src/Auth/OAuth2.php#L18)
- [`tokenUrl(): string`](../../src/Auth/OAuth2.php#L42)
- [`tokenFromArray(array $payload): Sujip\Xero\Auth\Token`](../../src/Auth/OAuth2.php#L50)

## Auth\OAuth2Client

[Source](../../src/Auth/OAuth2Client.php)

### Public methods

- [`__construct(string $clientId, ?string $clientSecret = NULL, ?string $redirectUri = NULL, ?\Sujip\Xero\Http\Transport $transport = NULL)`](../../src/Auth/OAuth2Client.php#L15)
- [`authorizationUrl(array $scopes, string $state, ?string $codeChallenge = NULL, string $codeChallengeMethod = 'S256'): string`](../../src/Auth/OAuth2Client.php#L27)
- [`exchangeAuthorizationCode(string $code, ?string $codeVerifier = NULL): Sujip\Xero\Auth\Token`](../../src/Auth/OAuth2Client.php#L43)
- [`refreshAccessToken(string $refreshToken): Sujip\Xero\Auth\Token`](../../src/Auth/OAuth2Client.php#L58)
- [`clientCredentials(array $scopes = array (
)): Sujip\Xero\Auth\Token`](../../src/Auth/OAuth2Client.php#L69)
- [`customConnection(array $scopes = array (
)): Sujip\Xero\Auth\Token`](../../src/Auth/OAuth2Client.php#L87)
- [`manager(\Sujip\Xero\Auth\TokenRepository $tokens, string $tokenKey = 'default'): Sujip\Xero\Auth\ConnectionManager`](../../src/Auth/OAuth2Client.php#L92)
- [`transport(): Sujip\Xero\Http\Transport`](../../src/Auth/OAuth2Client.php#L97)

## Auth\Pkce

[Source](../../src/Auth/Pkce.php)

### Public methods

- [`verifier(int $length = 64): string`](../../src/Auth/Pkce.php#L9)
- [`challenge(string $verifier): string`](../../src/Auth/Pkce.php#L23)

## Auth\Token

[Source](../../src/Auth/Token.php)

### Public methods

- [`__construct(string $accessToken, ?string $refreshToken = NULL, ?\DateTimeImmutable $expiresAt = NULL, ?\DateTimeImmutable $refreshTokenExpiresAt = NULL, array $scopes = array (
), ?string $idToken = NULL, ?string $tokenType = 'Bearer')`](../../src/Auth/Token.php#L14)
- [`getAccessToken(): string`](../../src/Auth/Token.php#L25)
- [`getRefreshToken(): ?string`](../../src/Auth/Token.php#L30)
- [`getExpiresAt(): ?\DateTimeImmutable`](../../src/Auth/Token.php#L35)
- [`getRefreshTokenExpiresAt(): ?\DateTimeImmutable`](../../src/Auth/Token.php#L40)
- [`getScopes(): array`](../../src/Auth/Token.php#L48)
- [`getIdToken(): ?string`](../../src/Auth/Token.php#L53)
- [`getTokenType(): ?string`](../../src/Auth/Token.php#L58)
- [`hasRefreshToken(): bool`](../../src/Auth/Token.php#L63)
- [`isExpired(?\DateTimeImmutable $now = NULL): bool`](../../src/Auth/Token.php#L68)
- [`isRefreshTokenExpired(?\DateTimeImmutable $now = NULL): bool`](../../src/Auth/Token.php#L77)

## Auth\TokenRepository

[Source](../../src/Auth/TokenRepository.php)

### Public methods

- [`get(string $key): ?\Sujip\Xero\Auth\Token`](../../src/Auth/TokenRepository.php#L9)
- [`put(string $key, \Sujip\Xero\Auth\Token $token): void`](../../src/Auth/TokenRepository.php#L11)
