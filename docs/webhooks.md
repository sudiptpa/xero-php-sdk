# Webhooks

Verify signatures and parse events.

The package does two things:

- verify the `x-xero-signature` header
- parse the payload into typed event objects

## Verify a request

```php
use Sujip\Xero\Xero;

$verifier = Xero::webhookVerifier($signingKey);

$verifier->assertValid($rawPayload, $signatureHeader);
```

If the signature does not match, the package throws `InvalidWebhookSignatureException`.

If your HTTP layer gives you a header array instead of a single string:

```php
$verifier->assertValidHeaders($rawPayload, $headers);
```

## Parse the payload

```php
$payload = $verifier->parse($rawPayload);

foreach ($payload->getEvents() as $event) {
    // handle the event
}
```

Or in one step:

```php
$payload = $verifier->verifyAndParse($rawPayload, $signatureHeader);
```

Or from a header array:

```php
$payload = $verifier->verifyAndParseHeaders($rawPayload, $headers);
```

## Event helpers

```php
$first = $payload->first();

if ($payload->contains('invoice', 'create')) {
    // dispatch invoice create work
}

if ($first?->isCreate()) {
    $resourceId = $first->getResourceId();
    $path = $first->path();
    $resource = $first->resourceName();
}
```

```php
$invoiceEvents = $payload->only('invoice');
$ids = $payload->resourceIds();
```

## Practical notes

- verify before you parse
- keep the raw payload if you need to retry processing
- return quickly to Xero and do heavier work asynchronously
- treat webhook delivery as a signal, not your only source of truth
- route from event category and id, then re-fetch current data from Xero when accuracy matters

## Scopes

Webhook delivery is configured in Xero, not through API scopes. There are no scope requirements here.
