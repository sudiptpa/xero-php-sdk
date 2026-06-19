<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ContactDetail extends Model
{
    private ?string $contactId = null;

    private ?string $name = null;

    private int|float|null $total = null;

    private ?ContactTotalDetail $totalDetail = null;

    private ?ContactTotalOther $totalOther = null;

    /**
     * @var list<string>
     */
    private array $accountCodes = [];

    public function getContactId(): ?string
    {
        return $this->contactId;
    }

    public function setContactId(?string $contactId): self
    {
        $this->contactId = $contactId;

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

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotalDetail(): ?ContactTotalDetail
    {
        return $this->totalDetail;
    }

    public function setTotalDetail(?ContactTotalDetail $totalDetail): self
    {
        $this->totalDetail = $totalDetail;

        return $this;
    }

    public function getTotalOther(): ?ContactTotalOther
    {
        return $this->totalOther;
    }

    public function setTotalOther(?ContactTotalOther $totalOther): self
    {
        $this->totalOther = $totalOther;

        return $this;
    }

    /**
     * @return list<string>
     */
    public function getAccountCodes(): array
    {
        return $this->accountCodes;
    }

    /**
     * @param list<string> $accountCodes
     */
    public function setAccountCodes(array $accountCodes): self
    {
        $this->accountCodes = $accountCodes;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'contactId' => Field::string(),
            'name' => Field::string(),
            'total' => Field::number(),
            'totalDetail' => Field::object(ContactTotalDetail::class),
            'totalOther' => Field::object(ContactTotalOther::class),
            'accountCodes' => Field::array(),
        ];
    }
}
