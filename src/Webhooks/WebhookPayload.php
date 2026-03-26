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

    public function hasEvents(): bool
    {
        return $this->events->count() > 0;
    }

    public function isEmpty(): bool
    {
        return ! $this->hasEvents();
    }

    public function first(): ?WebhookEvent
    {
        return $this->events->first();
    }

    public function last(): ?WebhookEvent
    {
        $all = $this->events->all();

        if ($all === []) {
            return null;
        }

        /** @var WebhookEvent $last */
        $last = end($all);

        return $last;
    }

    /**
     * @return list<string>
     */
    public function categories(): array
    {
        $categories = [];

        foreach ($this->events as $event) {
            if ($event->eventCategory !== null) {
                $categories[] = $event->eventCategory;
            }
        }

        return array_values(array_unique($categories));
    }

    /**
     * @return list<string>
     */
    public function eventTypes(): array
    {
        $types = [];

        foreach ($this->events as $event) {
            if ($event->eventType !== null) {
                $types[] = $event->eventType;
            }
        }

        return array_values(array_unique($types));
    }

    public function contains(string $category, ?string $type = null): bool
    {
        foreach ($this->events as $event) {
            if ($event->is($category, $type)) {
                return true;
            }
        }

        return false;
    }
}
