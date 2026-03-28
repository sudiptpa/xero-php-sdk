<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\ProjectUser;

final class ProjectUser
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

}
