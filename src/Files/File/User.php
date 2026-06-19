<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class User extends Model
{
    public function __construct(
        private ?string $id = null,
        private ?string $name = null,
        private ?string $firstName = null,
        private ?string $lastName = null,
        private ?string $fullName = null,
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

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

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Id' => Field::string()->using('setId'),
            'Name' => Field::string()->using('setName'),
            'FirstName' => Field::string()->using('setFirstName'),
            'LastName' => Field::string()->using('setLastName'),
            'FullName' => Field::string()->using('setFullName'),
        ];
    }
}
