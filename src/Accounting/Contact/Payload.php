<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Client;

final class Payload
{
    private Contact $contact;

    public function __construct(
        private readonly Client $client
    ) {
        $this->contact = new Contact($client);
    }

    public function setName(?string $name): self
    {
        $clone = clone $this;
        $clone->contact = clone $this->contact;
        $clone->contact->setName($name);

        return $clone;
    }

    public function setFirstName(?string $firstName): self
    {
        $clone = clone $this;
        $clone->contact = clone $this->contact;
        $clone->contact->setFirstName($firstName);

        return $clone;
    }

    public function setLastName(?string $lastName): self
    {
        $clone = clone $this;
        $clone->contact = clone $this->contact;
        $clone->contact->setLastName($lastName);

        return $clone;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $clone = clone $this;
        $clone->contact = clone $this->contact;
        $clone->contact->setEmailAddress($emailAddress);

        return $clone;
    }

    public function setContactID(?string $contactID): self
    {
        $clone = clone $this;
        $clone->contact = clone $this->contact;
        $clone->contact->setContactID($contactID);

        return $clone;
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function firstName(string $firstName): self
    {
        return $this->setFirstName($firstName);
    }

    public function lastName(string $lastName): self
    {
        return $this->setLastName($lastName);
    }

    public function email(string $email): self
    {
        return $this->setEmailAddress($email);
    }

    public function id(string $contactId): self
    {
        return $this->setContactID($contactId);
    }

    public function using(Contact $contact): self
    {
        $clone = clone $this;
        $clone->contact = clone $contact;

        return $clone;
    }

    public function save(): Contact
    {
        $path = '/api.xro/2.0/Contacts';

        if ($this->contact->getContactID() !== null) {
            $path .= '/' . $this->contact->getContactID();
        }

        $response = $this->client
            ->post($path)
            ->withJson([
                'Contacts' => [$this->contact->toRequest()],
            ])
            ->send();

        $payload = $response->json();
        $contact = $payload['Contacts'][0] ?? [];

        return (new Contacts($this->client))
            ->mapContact(is_array($contact) ? $contact : []);
    }
}
