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

## Event categories and fields

Xero OpenAPI 19.0.0 defines `CONTACT`, `INVOICE`, `SUBSCRIPTION`, `CREDITNOTE`,
`PREPAYMENT`, and `OVERPAYMENT` categories. Subscribe to each required category
in your Xero app settings. The parser keeps category strings as received.

The payload exposes `events`, `firstEventSequence`, `lastEventSequence`, and
`entropy`. Each event exposes `resourceUrl`, `resourceId`, `eventCategory`,
`eventType`, `eventDateUtc`, `tenantId`, and `tenantType` through its matching
`get...()` method. Use `getPayload()` to read the complete original event.

Credit note events include `data.Type` and `data.Status`. Prepayment and
overpayment events also include `data.UpdatedDateUTCString`. Read these fields
with `getData()`:

```php
foreach ($payload->only('overpayment', 'update') as $event) {
    $details = $event->getData();
    $type = $details['Type'] ?? null;
    $status = $details['Status'] ?? null;
    $updatedAt = $details['UpdatedDateUTCString'] ?? null;
}
```

The spec defines `CREATE` and `UPDATE` event types. An archived resource is
reported as an update. The `isDelete()` helper remains available for parsing
such a value, but the current spec does not promise `DELETE` notifications.

Source: [Xero webhook schema](https://github.com/XeroAPI/Xero-OpenAPI/blob/448060d7829cae23166a2e443be48c2f2422280f/xero-webhooks.yaml).

## Delivery

- verify before you parse
- keep the raw payload if you need to retry processing
- return quickly to Xero and do heavier work asynchronously
- treat webhook delivery as a signal, not your only source of truth
- route from event category and id, then re-fetch current data from Xero when accuracy matters

## Scopes

Webhook delivery is configured in Xero, not through API scopes. There are no scope requirements here.
