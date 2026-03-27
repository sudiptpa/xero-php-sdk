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

    public function count(): int
    {
        return $this->events->count();
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

    /**
     * @return ResourceCollection<WebhookEvent>
     */
    public function only(string $category, ?string $type = null): ResourceCollection
    {
        $events = [];

        foreach ($this->events as $event) {
            if ($event->is($category, $type)) {
                $events[] = $event;
            }
        }

        return new ResourceCollection($events);
    }

    public function has(string $category, ?string $type = null): bool
    {
        return $this->contains($category, $type);
    }

    /**
     * @return list<string>
     */
    public function resourceIds(): array
    {
        $ids = [];

        foreach ($this->events as $event) {
            if ($event->resourceId !== null) {
                $ids[] = $event->resourceId;
            }
        }

        return array_values(array_unique($ids));
    }

    /**
     * @return list<string>
     */
    public function paths(): array
    {
        $paths = [];

        foreach ($this->events as $event) {
            $path = $event->path();

            if ($path !== null) {
                $paths[] = $path;
            }
        }

        return array_values(array_unique($paths));
    }
}
