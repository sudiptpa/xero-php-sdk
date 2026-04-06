<?php

declare(strict_types=1);

namespace Sujip\Xero\Webhooks;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ResourceCollection;

final class WebhookPayload extends Model
{
    /**
     * @var ResourceCollection<WebhookEvent>
     */
    private ResourceCollection $events;

    /**
     * @param ResourceCollection<WebhookEvent> $events
     */
    public function __construct(
        private int|float|null $firstEventSequence = null,
        private int|float|null $lastEventSequence = null,
        private ?string $entropy = null,
        ?ResourceCollection $events = null,
    ) {
        $this->events = $events ?? new ResourceCollection([]);
    }

    public function getFirstEventSequence(): int|float|null { return $this->firstEventSequence; }
    public function setFirstEventSequence(int|float|null $firstEventSequence): self { $this->firstEventSequence = $firstEventSequence; return $this; }
    public function getLastEventSequence(): int|float|null { return $this->lastEventSequence; }
    public function setLastEventSequence(int|float|null $lastEventSequence): self { $this->lastEventSequence = $lastEventSequence; return $this; }
    public function getEntropy(): ?string { return $this->entropy; }
    public function setEntropy(?string $entropy): self { $this->entropy = $entropy; return $this; }
    /**
     * @return ResourceCollection<WebhookEvent>
     */
    public function getEvents(): ResourceCollection { return $this->events; }
    /**
     * @param ResourceCollection<WebhookEvent> $events
     */
    public function setEvents(ResourceCollection $events): self { $this->events = $events; return $this; }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'firstEventSequence' => Field::number()->using('setFirstEventSequence'),
            'lastEventSequence' => Field::number()->using('setLastEventSequence'),
            'entropy' => Field::string()->using('setEntropy'),
        ];
    }

    public function fill(array $payload): static
    {
        parent::fill($payload);

        $events = array_map(
            fn (array $event): WebhookEvent => (new WebhookEvent())->fill($event),
            array_values(array_filter($payload['events'] ?? [], 'is_array'))
        );

        return $this->setEvents(new ResourceCollection($events));
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
            if ($event->getEventCategory() !== null) {
                $categories[] = $event->getEventCategory();
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
            if ($event->getEventType() !== null) {
                $types[] = $event->getEventType();
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
            if ($event->getResourceId() !== null) {
                $ids[] = $event->getResourceId();
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
