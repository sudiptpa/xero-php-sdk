<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\ProjectUser;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ProjectUser extends Model
{
    private ?string $userId = null;

    private ?string $name = null;

    private ?string $email = null;

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): self
    {
        $this->userId = $userId;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'userId' => Field::string(),
            'name' => Field::string(),
            'email' => Field::string(),
        ];
    }
}
