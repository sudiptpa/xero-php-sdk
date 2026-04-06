<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ContactGroup;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ContactGroup extends Model
{
    private ?string $contactGroupID = null;

    private ?string $name = null;

    private ?string $status = null;

    /**
     * @var list<string>
     */
    private array $contactIDs = [];

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getContactGroupID(): ?string
    {
        return $this->contactGroupID;
    }

    public function setContactGroupID(?string $contactGroupID): self
    {
        $this->contactGroupID = $contactGroupID;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return list<string>
     */
    public function getContactIDs(): array
    {
        return $this->contactIDs;
    }

    /**
     * @param list<string> $contactIDs
     */
    public function setContactIDs(array $contactIDs): self
    {
        $this->contactIDs = $contactIDs;

        return $this;
    }

    public function addContactID(string $contactID): self
    {
        $this->contactIDs[] = $contactID;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ContactGroupID' => Field::string(),
            'Name' => Field::string(),
            'Status' => Field::string(),
        ];
    }

    public function fill(array $payload): static
    {
        parent::fill($payload);

        $contactIds = [];

        foreach ($payload['Contacts'] ?? [] as $contact) {
            if (is_array($contact) && isset($contact['ContactID']) && is_string($contact['ContactID'])) {
                $contactIds[] = $contact['ContactID'];
            }
        }

        return $this->setContactIDs($contactIds);
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a contact group without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->contactGroupID !== null) {
            $payload = $payload->id($this->contactGroupID);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        foreach ($this->contactIDs as $contactID) {
            $payload = $payload->contact($contactID);
        }

        return $payload->save();
    }

    public function contacts(): ContactAssignments
    {
        if ($this->client === null || $this->contactGroupID === null) {
            throw new RuntimeException('Cannot manage contact group members without a bound client context and group ID.');
        }

        return new ContactAssignments($this->client, $this->contactGroupID);
    }

    public function attachContacts(string ...$contactIds): self
    {
        return $this->contacts()->attach(...$contactIds);
    }

    public function removeContact(string $contactId): bool
    {
        return $this->contacts()->remove($contactId);
    }
}
