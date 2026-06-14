<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Report;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TenNinetyNineContact extends Model
{
    private int|float|null $box1 = null;

    private int|float|null $box2 = null;

    private int|float|null $box3 = null;

    private int|float|null $box4 = null;

    private int|float|null $box5 = null;

    private int|float|null $box6 = null;

    private int|float|null $box7 = null;

    private int|float|null $box8 = null;

    private int|float|null $box9 = null;

    private int|float|null $box10 = null;

    private int|float|null $box11 = null;

    private int|float|null $box13 = null;

    private int|float|null $box14 = null;

    private ?string $name = null;

    private ?string $federalTaxIDType = null;

    private ?string $city = null;

    private ?string $zip = null;

    private ?string $state = null;

    private ?string $email = null;

    private ?string $streetAddress = null;

    private ?string $taxID = null;

    private ?string $contactId = null;

    private ?string $legalName = null;

    private ?string $businessName = null;

    private ?string $federalTaxClassification = null;

    public function getBox1(): int|float|null
    {
        return $this->box1;
    }

    public function setBox1(int|float|null $box1): self
    {
        $this->box1 = $box1;

        return $this;
    }

    public function getBox2(): int|float|null
    {
        return $this->box2;
    }

    public function setBox2(int|float|null $box2): self
    {
        $this->box2 = $box2;

        return $this;
    }

    public function getBox3(): int|float|null
    {
        return $this->box3;
    }

    public function setBox3(int|float|null $box3): self
    {
        $this->box3 = $box3;

        return $this;
    }

    public function getBox4(): int|float|null
    {
        return $this->box4;
    }

    public function setBox4(int|float|null $box4): self
    {
        $this->box4 = $box4;

        return $this;
    }

    public function getBox5(): int|float|null
    {
        return $this->box5;
    }

    public function setBox5(int|float|null $box5): self
    {
        $this->box5 = $box5;

        return $this;
    }

    public function getBox6(): int|float|null
    {
        return $this->box6;
    }

    public function setBox6(int|float|null $box6): self
    {
        $this->box6 = $box6;

        return $this;
    }

    public function getBox7(): int|float|null
    {
        return $this->box7;
    }

    public function setBox7(int|float|null $box7): self
    {
        $this->box7 = $box7;

        return $this;
    }

    public function getBox8(): int|float|null
    {
        return $this->box8;
    }

    public function setBox8(int|float|null $box8): self
    {
        $this->box8 = $box8;

        return $this;
    }

    public function getBox9(): int|float|null
    {
        return $this->box9;
    }

    public function setBox9(int|float|null $box9): self
    {
        $this->box9 = $box9;

        return $this;
    }

    public function getBox10(): int|float|null
    {
        return $this->box10;
    }

    public function setBox10(int|float|null $box10): self
    {
        $this->box10 = $box10;

        return $this;
    }

    public function getBox11(): int|float|null
    {
        return $this->box11;
    }

    public function setBox11(int|float|null $box11): self
    {
        $this->box11 = $box11;

        return $this;
    }

    public function getBox13(): int|float|null
    {
        return $this->box13;
    }

    public function setBox13(int|float|null $box13): self
    {
        $this->box13 = $box13;

        return $this;
    }

    public function getBox14(): int|float|null
    {
        return $this->box14;
    }

    public function setBox14(int|float|null $box14): self
    {
        $this->box14 = $box14;

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

    public function getFederalTaxIDType(): ?string
    {
        return $this->federalTaxIDType;
    }

    public function setFederalTaxIDType(?string $federalTaxIDType): self
    {
        $this->federalTaxIDType = $federalTaxIDType;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(?string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    public function getTaxID(): ?string
    {
        return $this->taxID;
    }

    public function setTaxID(?string $taxID): self
    {
        $this->taxID = $taxID;

        return $this;
    }

    public function getContactId(): ?string
    {
        return $this->contactId;
    }

    public function setContactId(?string $contactId): self
    {
        $this->contactId = $contactId;

        return $this;
    }

    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    public function setLegalName(?string $legalName): self
    {
        $this->legalName = $legalName;

        return $this;
    }

    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    public function setBusinessName(?string $businessName): self
    {
        $this->businessName = $businessName;

        return $this;
    }

    public function getFederalTaxClassification(): ?string
    {
        return $this->federalTaxClassification;
    }

    public function setFederalTaxClassification(?string $federalTaxClassification): self
    {
        $this->federalTaxClassification = $federalTaxClassification;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Box1' => Field::number(),
            'Box2' => Field::number(),
            'Box3' => Field::number(),
            'Box4' => Field::number(),
            'Box5' => Field::number(),
            'Box6' => Field::number(),
            'Box7' => Field::number(),
            'Box8' => Field::number(),
            'Box9' => Field::number(),
            'Box10' => Field::number(),
            'Box11' => Field::number(),
            'Box13' => Field::number(),
            'Box14' => Field::number(),
            'Name' => Field::string(),
            'FederalTaxIDType' => Field::string(),
            'City' => Field::string(),
            'Zip' => Field::string(),
            'State' => Field::string(),
            'Email' => Field::string(),
            'StreetAddress' => Field::string(),
            'TaxID' => Field::string(),
            'ContactId' => Field::string(),
            'LegalName' => Field::string(),
            'BusinessName' => Field::string(),
            'FederalTaxClassification' => Field::string(),
        ];
    }
}
