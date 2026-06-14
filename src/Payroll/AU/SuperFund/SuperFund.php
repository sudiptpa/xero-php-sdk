<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class SuperFund extends Model
{
    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function __construct(
        private ?string $superFundID = null,
        private ?string $type = null,
        private ?string $name = null,
        private ?string $abn = null,
        private ?string $bsb = null,
        private ?string $accountNumber = null,
        private ?string $accountName = null,
        private ?string $electronicServiceAddress = null,
        private ?string $employerNumber = null,
        private ?string $spin = null,
        private ?string $usi = null,
        private ?string $updatedDateUtc = null,
    ) {
    }

    public function getSuperFundID(): ?string
    {
        return $this->superFundID;
    }

    public function setSuperFundID(?string $superFundID): self
    {
        $this->superFundID = $superFundID;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAbn(): ?string
    {
        return $this->abn;
    }

    public function setAbn(?string $abn): self
    {
        $this->abn = $abn;

        return $this;
    }

    public function getBsb(): ?string
    {
        return $this->bsb;
    }

    public function setBsb(?string $bsb): self
    {
        $this->bsb = $bsb;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(?string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(?string $accountName): self
    {
        $this->accountName = $accountName;

        return $this;
    }

    public function getElectronicServiceAddress(): ?string
    {
        return $this->electronicServiceAddress;
    }

    public function setElectronicServiceAddress(?string $electronicServiceAddress): self
    {
        $this->electronicServiceAddress = $electronicServiceAddress;

        return $this;
    }

    public function getEmployerNumber(): ?string
    {
        return $this->employerNumber;
    }

    public function setEmployerNumber(?string $employerNumber): self
    {
        $this->employerNumber = $employerNumber;

        return $this;
    }

    public function getSpin(): ?string
    {
        return $this->spin;
    }

    public function setSpin(?string $spin): self
    {
        $this->spin = $spin;

        return $this;
    }

    public function getUsi(): ?string
    {
        return $this->usi;
    }

    public function setUsi(?string $usi): self
    {
        $this->usi = $usi;

        return $this;
    }

    public function getUpdatedDateUtc(): ?string
    {
        return $this->updatedDateUtc;
    }

    public function setUpdatedDateUtc(?string $updatedDateUtc): self
    {
        $this->updatedDateUtc = $updatedDateUtc;

        return $this;
    }

    /**
     * @return list<ValidationError>
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function addValidationError(ValidationError $validationError): self
    {
        $this->validationErrors[] = $validationError;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'SuperFundID' => Field::string()->using('setSuperFundID'),
            'Type' => Field::string()->using('setType'),
            'Name' => Field::string()->using('setName'),
            'ABN' => Field::string()->using('setAbn'),
            'BSB' => Field::string()->using('setBsb'),
            'AccountNumber' => Field::string()->using('setAccountNumber'),
            'AccountName' => Field::string()->using('setAccountName'),
            'ElectronicServiceAddress' => Field::string()->using('setElectronicServiceAddress'),
            'EmployerNumber' => Field::string()->using('setEmployerNumber'),
            'SPIN' => Field::string()->using('setSpin'),
            'USI' => Field::string()->using('setUsi'),
            'UpdatedDateUTC' => Field::string()->using('setUpdatedDateUtc'),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }
}
