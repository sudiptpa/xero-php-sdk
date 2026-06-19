<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class NICategory extends Model
{
    public function __construct(
        private ?string $startDate = null,
        private ?string $niCategory = null,
        private ?float $niCategoryID = null,
        private ?string $dateFirstEmployedAsCivilian = null,
        private ?string $workplacePostcode = null,
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

    public function getNiCategory(): ?string
    {
        return $this->niCategory;
    }

    public function setNiCategory(?string $niCategory): self
    {
        $this->niCategory = $niCategory;

        return $this;
    }

    public function getNiCategoryID(): ?float
    {
        return $this->niCategoryID;
    }

    public function setNiCategoryID(?float $niCategoryID): self
    {
        $this->niCategoryID = $niCategoryID;

        return $this;
    }

    public function getDateFirstEmployedAsCivilian(): ?string
    {
        return $this->dateFirstEmployedAsCivilian;
    }

    public function setDateFirstEmployedAsCivilian(?string $dateFirstEmployedAsCivilian): self
    {
        $this->dateFirstEmployedAsCivilian = $dateFirstEmployedAsCivilian;

        return $this;
    }

    public function getWorkplacePostcode(): ?string
    {
        return $this->workplacePostcode;
    }

    public function setWorkplacePostcode(?string $workplacePostcode): self
    {
        $this->workplacePostcode = $workplacePostcode;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'startDate' => Field::string()->using('setStartDate'),
            'niCategory' => Field::string()->using('setNiCategory'),
            'niCategoryID' => Field::number()->using('setNiCategoryID'),
            'dateFirstEmployedAsCivilian' => Field::string()->using('setDateFirstEmployedAsCivilian'),
            'workplacePostcode' => Field::string()->using('setWorkplacePostcode'),
        ];
    }
}
