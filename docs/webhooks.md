# Webhooks

Webhook handling should be boring.

The package does two things:

- verify the `x-xero-signature` header
- parse the payload into typed event objects

That is enough for most apps. The SDK does not try to become a queue system or a framework adapter.

## Verify A Request

```php
use Sujip\Xero\Xero;

$verifier = Xero::webhookVerifier($signingKey);

$verifier->assertValid($rawPayload, $signatureHeader);
```

If the signature does not match, the package throws `InvalidWebhookSignatureException`.

## Parse The Payload

```php
$payload = $verifier->parse($rawPayload);

foreach ($payload->events as $event) {
    // handle the event
}
```

Or in one step:

```php
$payload = $verifier->verifyAndParse($rawPayload, $signatureHeader);
```

## Event Helpers

```php
$first = $payload->first();

if ($payload->contains('invoice', 'create')) {
    // dispatch invoice create work
}

if ($first?->isCreate()) {
    $resourceId = $first->resourceId;
    $path = $first->path();
}
```

## Practical Notes

- verify before you parse
- keep the raw payload if you need to retry processing
- return quickly to Xero and do heavier work asynchronously in your app
- treat webhook delivery as a signal, not as your only source of truth

## Scope Notes

Webhook delivery is configured in Xero rather than through normal API scopes, so there is no endpoint scope section here.
