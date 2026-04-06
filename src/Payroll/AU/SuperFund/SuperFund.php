<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class SuperFund extends Model
{
    /**
     */
    public function __construct(
        private ?string $superFundID = null,
        private ?string $name = null,
        private ?string $type = null,
    ) {
    }

    public function getSuperFundID(): ?string { return $this->superFundID; }
    public function setSuperFundID(?string $superFundID): self { $this->superFundID = $superFundID; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): self { $this->name = $name; return $this; }
    public function getType(): ?string { return $this->type; }
    public function setType(?string $type): self { $this->type = $type; return $this; }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'SuperFundID' => Field::string()->using('setSuperFundID'),
            'Name' => Field::string()->using('setName'),
            'Type' => Field::string()->using('setType'),
        ];
    }
}
