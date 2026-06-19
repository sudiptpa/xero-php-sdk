<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Reimbursement extends Model
{
    public function __construct(
        private ?string $reimbursementID = null,
        private ?string $name = null,
        private ?string $accountID = null,
        private ?bool $currentRecord = null,
    ) {
    }

    public function getReimbursementID(): ?string
    {
        return $this->reimbursementID;
    }

    public function setReimbursementID(?string $reimbursementID): self
    {
        $this->reimbursementID = $reimbursementID;

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

    public function getAccountID(): ?string
    {
        return $this->accountID;
    }

    public function setAccountID(?string $accountID): self
    {
        $this->accountID = $accountID;

        return $this;
    }

    public function getCurrentRecord(): ?bool
    {
        return $this->currentRecord;
    }

    public function setCurrentRecord(?bool $currentRecord): self
    {
        $this->currentRecord = $currentRecord;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'reimbursementID' => Field::string()->using('setReimbursementID'),
            'name' => Field::string()->using('setName'),
            'accountID' => Field::string()->using('setAccountID'),
            'currentRecord' => Field::boolean()->using('setCurrentRecord'),
        ];
    }
}
