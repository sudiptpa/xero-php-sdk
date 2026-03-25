<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ContactGroup;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class ContactGroup
{
    /**
     * @param list<string> $contactIds
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $status,
        public array $contactIds = [],
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        $contacts = [];

        foreach (($payload['Contacts'] ?? []) as $contact) {
            if (is_array($contact) && isset($contact['ContactID']) && is_string($contact['ContactID'])) {
                $contacts[] = $contact['ContactID'];
            }
        }

        return new self(
            $payload['ContactGroupID'] ?? null,
            $payload['Name'] ?? null,
            $payload['Status'] ?? null,
            $contacts,
            $payload,
            $client
        );
    }

    public function name(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self($this->id, $name, $this->status, $this->contactIds, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a contact group without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        foreach ($this->contactIds as $contactId) {
            $payload = $payload->contact($contactId);
        }

        return $payload->save();
    }

    public function contacts(): ContactAssignments
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot manage contact group members without a bound client context and group ID.');
        }

        return new ContactAssignments($this->client, $this->id);
    }

    public function attachContacts(string ...$contactIds): self
    {
        return $this->contacts()->attach(...$contactIds);
    }
}
