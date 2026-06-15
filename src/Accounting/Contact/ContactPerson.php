<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class ContactPerson extends Model implements SerializesRequest
{
    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $emailAddress = null;

    private ?bool $includeInEmails = null;

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

    public function getIncludeInEmails(): ?bool
    {
        return $this->includeInEmails;
    }

    public function setIncludeInEmails(?bool $includeInEmails): self
    {
        $this->includeInEmails = $includeInEmails;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'FirstName' => Field::string(),
            'LastName' => Field::string(),
            'EmailAddress' => Field::string(),
            'IncludeInEmails' => Field::boolean(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'FirstName' => $this->getFirstName(),
            'LastName' => $this->getLastName(),
            'EmailAddress' => $this->getEmailAddress(),
            'IncludeInEmails' => $this->getIncludeInEmails(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
