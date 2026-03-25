<?php

declare(strict_types=1);

namespace Sujip\Xero\Webhooks;

use Sujip\Xero\Support\ResourceCollection;

final readonly class WebhookPayload
{
    /**
     * @param ResourceCollection<WebhookEvent> $events
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public string $firstEventSequence,
        public string $lastEventSequence,
        public ResourceCollection $events,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        $events = array_values(array_map(
            static fn (array $event): WebhookEvent => WebhookEvent::fromArray($event),
            $payload['events'] ?? []
        ));

        return new self(
            (string) ($payload['firstEventSequence'] ?? ''),
            (string) ($payload['lastEventSequence'] ?? ''),
            new ResourceCollection($events),
            $payload
        );
    }
}
