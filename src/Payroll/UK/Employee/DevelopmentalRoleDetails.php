<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class DevelopmentalRoleDetails extends Model
{
    public function __construct(
        private ?string $startDate = null,
        private ?string $endDate = null,
        private ?string $developmentalRole = null,
        private ?string $publicKey = null,
    ) {
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDevelopmentalRole(): ?string
    {
        return $this->developmentalRole;
    }

    public function setDevelopmentalRole(?string $developmentalRole): self
    {
        $this->developmentalRole = $developmentalRole;

        return $this;
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function setPublicKey(?string $publicKey): self
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'startDate' => Field::string()->using('setStartDate'),
            'endDate' => Field::string()->using('setEndDate'),
            'developmentalRole' => Field::string()->using('setDevelopmentalRole'),
            'publicKey' => Field::string()->using('setPublicKey'),
        ];
    }
}
