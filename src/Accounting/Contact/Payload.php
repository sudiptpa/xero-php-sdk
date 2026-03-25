<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $contactId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['Name'] = $name;

        return $clone;
    }

    public function firstName(string $firstName): self
    {
        $clone = clone $this;
        $clone->payload['FirstName'] = $firstName;

        return $clone;
    }

    public function lastName(string $lastName): self
    {
        $clone = clone $this;
        $clone->payload['LastName'] = $lastName;

        return $clone;
    }

    public function email(string $email): self
    {
        $clone = clone $this;
        $clone->payload['EmailAddress'] = $email;

        return $clone;
    }

    public function id(string $contactId): self
    {
        $clone = clone $this;
        $clone->contactId = $contactId;

        return $clone;
    }

    public function save(): Contact
    {
        $path = '/api.xro/2.0/Contacts';

        if ($this->contactId !== null) {
            $path .= '/' . $this->contactId;
        }

        $response = $this->client
            ->post($path)
            ->withJson([
                'Contacts' => [$this->payload],
            ])
            ->send();

        $payload = $response->json();
        $contact = $payload['Contacts'][0] ?? [];

        return Contact::fromArray(is_array($contact) ? $contact : [], $this->client);
    }
}
