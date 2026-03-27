<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\BuildsFromPayload;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Contact implements BuildsFromPayload, SerializesForRequest
{
    private ?string $contactID = null;

    private ?string $name = null;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $emailAddress = null;

    /**
     * @var list<Address>
     */
    private array $addresses = [];

    /**
     * @var list<Phone>
     */
    private array $phones = [];

    public function __construct(
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?Client $client = null): static
    {
        $contact = (new self($client))
            ->setContactID($payload['ContactID'] ?? null)
            ->setName($payload['Name'] ?? null)
            ->setFirstName($payload['FirstName'] ?? null)
            ->setLastName($payload['LastName'] ?? null)
            ->setEmailAddress($payload['EmailAddress'] ?? null);

        foreach ($payload['Addresses'] ?? [] as $address) {
            if (is_array($address)) {
                $contact->addAddress(Address::fromPayload($address));
            }
        }

        foreach ($payload['Phones'] ?? [] as $phone) {
            if (is_array($phone)) {
                $contact->addPhone(Phone::fromPayload($phone));
            }
        }

        return $contact;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return self::fromPayload($payload, $client);
    }

    public function getContactID(): ?string
    {
        return $this->contactID;
    }

    public function setContactID(?string $contactID): self
    {
        $this->contactID = $contactID;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return list<Address>
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @param list<Address> $addresses
     */
    public function setAddresses(array $addresses): self
    {
        $this->addresses = $addresses;

        return $this;
    }

    public function addAddress(Address $address): self
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * @return list<Phone>
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * @param list<Phone> $phones
     */
    public function setPhones(array $phones): self
    {
        $this->phones = $phones;

        return $this;
    }

    public function addPhone(Phone $phone): self
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'ContactID' => $this->getContactID(),
            'Name' => $this->getName(),
            'FirstName' => $this->getFirstName(),
            'LastName' => $this->getLastName(),
            'EmailAddress' => $this->getEmailAddress(),
            'Addresses' => array_map(
                static fn (Address $address): array => $address->toRequest(),
                $this->getAddresses()
            ),
            'Phones' => array_map(
                static fn (Phone $phone): array => $phone->toRequest(),
                $this->getPhones()
            ),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a contact without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }
}
