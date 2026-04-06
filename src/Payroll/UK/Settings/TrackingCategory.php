<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TrackingCategory extends Model
{
    /**
     */
    public function __construct(
        private ?string $trackingCategoryID = null,
        private ?string $name = null,
    ) {
    }

    public function getTrackingCategoryID(): ?string { return $this->trackingCategoryID; }
    public function setTrackingCategoryID(?string $trackingCategoryID): self { $this->trackingCategoryID = $trackingCategoryID; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): self { $this->name = $name; return $this; }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'TrackingCategoryID' => Field::string()->using('setTrackingCategoryID'),
            'Name' => Field::string()->using('setName'),
        ];
    }
}
