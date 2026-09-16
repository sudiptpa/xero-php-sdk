# Exceptions reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Exceptions\AuthenticationException](#exceptionsauthenticationexception)
- [Exceptions\InsufficientScopeException](#exceptionsinsufficientscopeexception)
- [Exceptions\InvalidWebhookSignatureException](#exceptionsinvalidwebhooksignatureexception)
- [Exceptions\RateLimitException](#exceptionsratelimitexception)
- [Exceptions\RequestException](#exceptionsrequestexception)
- [Exceptions\TransportException](#exceptionstransportexception)
- [Exceptions\ValidationException](#exceptionsvalidationexception)
- [Exceptions\XeroException](#exceptionsxeroexception)

## Exceptions\AuthenticationException

[Source](../../src/Exceptions/AuthenticationException.php)

Extends [Exceptions\RequestException](exceptions.md#exceptionsrequestexception). Inherited methods are documented on the parent type.

## Exceptions\InsufficientScopeException

[Source](../../src/Exceptions/InsufficientScopeException.php)

Extends [Exceptions\AuthenticationException](exceptions.md#exceptionsauthenticationexception). Inherited methods are documented on the parent type.

## Exceptions\InvalidWebhookSignatureException

[Source](../../src/Exceptions/InvalidWebhookSignatureException.php)

Extends [Exceptions\XeroException](exceptions.md#exceptionsxeroexception). Inherited methods are documented on the parent type.

## Exceptions\RateLimitException

[Source](../../src/Exceptions/RateLimitException.php)

Extends [Exceptions\RequestException](exceptions.md#exceptionsrequestexception). Inherited methods are documented on the parent type.

## Exceptions\RequestException

[Source](../../src/Exceptions/RequestException.php)

Extends [Exceptions\XeroException](exceptions.md#exceptionsxeroexception). Inherited methods are documented on the parent type.

### Public methods

- [`__construct(\Sujip\Xero\Http\Response $response, string $message = 'Xero request failed.')`](../../src/Exceptions/RequestException.php#L11)

## Exceptions\TransportException

[Source](../../src/Exceptions/TransportException.php)

Extends [Exceptions\XeroException](exceptions.md#exceptionsxeroexception). Inherited methods are documented on the parent type.

## Exceptions\ValidationException

[Source](../../src/Exceptions/ValidationException.php)

Extends [Exceptions\RequestException](exceptions.md#exceptionsrequestexception). Inherited methods are documented on the parent type.

## Exceptions\XeroException

[Source](../../src/Exceptions/XeroException.php)
