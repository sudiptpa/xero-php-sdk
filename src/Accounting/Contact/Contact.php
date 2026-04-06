<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Contact extends Model implements SerializesRequest
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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ContactID' => Field::string(),
            'Name' => Field::string(),
            'FirstName' => Field::string(),
            'LastName' => Field::string(),
            'EmailAddress' => Field::string(),
            'Addresses' => Field::many(Address::class),
            'Phones' => Field::many(Phone::class),
        ];
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
