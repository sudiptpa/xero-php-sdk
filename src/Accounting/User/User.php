<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\User;

use Sujip\Xero\Support\Contracts\BuildsFromPayload;

final class User implements BuildsFromPayload
{
    private ?string $userID = null;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $emailAddress = null;

    private ?bool $isSubscriber = null;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?\Sujip\Xero\Client $client = null): static
    {
        return (new self())
            ->setUserID($payload['UserID'] ?? null)
            ->setFirstName($payload['FirstName'] ?? null)
            ->setLastName($payload['LastName'] ?? null)
            ->setEmailAddress($payload['EmailAddress'] ?? null)
            ->setIsSubscriber($payload['IsSubscriber'] ?? null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return self::fromPayload($payload);
    }

    public function getUserID(): ?string
    {
        return $this->userID;
    }

    public function setUserID(?string $userID): self
    {
        $this->userID = $userID;

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

    public function getIsSubscriber(): ?bool
    {
        return $this->isSubscriber;
    }

    public function setIsSubscriber(?bool $isSubscriber): self
    {
        $this->isSubscriber = $isSubscriber;

        return $this;
    }
}
