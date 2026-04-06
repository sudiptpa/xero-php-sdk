<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\ProjectUser;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ProjectUser extends Model
{
    private ?string $userID = null;

    private ?string $name = null;

    private ?string $emailAddress = null;

    public function getUserID(): ?string
    {
        return $this->userID;
    }

    public function setUserID(?string $userID): self
    {
        $this->userID = $userID;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'UserID' => Field::string()->using('setUserID'),
            'UserId' => Field::string()->using('setUserID'),
            'Name' => Field::string(),
            'EmailAddress' => Field::string()->using('setEmailAddress'),
            'Email' => Field::string()->using('setEmailAddress'),
        ];
    }

}
