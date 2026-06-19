<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class IncomeByContact extends Model
{
    private ?string $startDate = null;

    private ?string $endDate = null;

    private int|float|null $total = null;

    private ?TotalDetail $totalDetail = null;

    private ?TotalOther $totalOther = null;

    /**
     * @var list<ContactDetail>
     */
    private array $contacts = [];

    private ?ManualJournalTotal $manualJournals = null;

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

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotalDetail(): ?TotalDetail
    {
        return $this->totalDetail;
    }

    public function setTotalDetail(?TotalDetail $totalDetail): self
    {
        $this->totalDetail = $totalDetail;

        return $this;
    }

    public function getTotalOther(): ?TotalOther
    {
        return $this->totalOther;
    }

    public function setTotalOther(?TotalOther $totalOther): self
    {
        $this->totalOther = $totalOther;

        return $this;
    }

    /**
     * @return list<ContactDetail>
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * @param list<ContactDetail> $contacts
     */
    public function setContacts(array $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function addContact(ContactDetail $contact): self
    {
        $this->contacts[] = $contact;

        return $this;
    }

    public function getManualJournals(): ?ManualJournalTotal
    {
        return $this->manualJournals;
    }

    public function setManualJournals(?ManualJournalTotal $manualJournals): self
    {
        $this->manualJournals = $manualJournals;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'startDate' => Field::string(),
            'endDate' => Field::string(),
            'total' => Field::number(),
            'totalDetail' => Field::object(TotalDetail::class),
            'totalOther' => Field::object(TotalOther::class),
            'contacts' => Field::many(ContactDetail::class),
            'manualJournals' => Field::object(ManualJournalTotal::class),
        ];
    }
}
