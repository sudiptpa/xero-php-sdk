<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Product extends Model
{
    public function __construct(
        private ?string $id = null,
        private ?string $name = null,
        private ?string $type = null,
        private ?string $seatUnit = null,
        private ?string $usageUnit = null,
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSeatUnit(): ?string
    {
        return $this->seatUnit;
    }

    public function setSeatUnit(?string $seatUnit): self
    {
        $this->seatUnit = $seatUnit;

        return $this;
    }

    public function getUsageUnit(): ?string
    {
        return $this->usageUnit;
    }

    public function setUsageUnit(?string $usageUnit): self
    {
        $this->usageUnit = $usageUnit;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'id' => Field::string()->using('setId'),
            'name' => Field::string()->using('setName'),
            'type' => Field::string()->using('setType'),
            'seatUnit' => Field::string()->using('setSeatUnit'),
            'usageUnit' => Field::string()->using('setUsageUnit'),
        ];
    }
}
