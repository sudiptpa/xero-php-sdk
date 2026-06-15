<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

use Sujip\Xero\Accounting\Contact\Address;
use Sujip\Xero\Accounting\Contact\Phone;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Organisation extends Model
{
    private ?string $organisationID = null;

    private ?string $apiKey = null;

    private ?string $name = null;

    private ?string $legalName = null;

    private ?bool $paysTax = null;

    private ?string $version = null;

    private ?string $organisationType = null;

    private ?string $baseCurrency = null;

    private ?string $countryCode = null;

    private ?bool $isDemoCompany = null;

    private ?string $organisationStatus = null;

    private ?string $registrationNumber = null;

    private ?string $employerIdentificationNumber = null;

    private ?string $taxNumber = null;

    private ?int $financialYearEndDay = null;

    private ?int $financialYearEndMonth = null;

    private ?string $salesTaxBasis = null;

    private ?string $salesTaxPeriod = null;

    private ?string $defaultSalesTax = null;

    private ?string $defaultPurchasesTax = null;

    private ?string $periodLockDate = null;

    private ?string $endOfYearLockDate = null;

    private ?string $createdDateUTC = null;

    private ?string $timezone = null;

    private ?string $organisationEntityType = null;

    private ?string $class = null;

    private ?string $edition = null;

    private ?string $lineOfBusiness = null;

    private ?string $shortCode = null;

    /**
     * @var list<Address>
     */
    private array $addresses = [];

    /**
     * @var list<Phone>
     */
    private array $phones = [];

    /**
     * @var list<ExternalLink>
     */
    private array $externalLinks = [];

    private ?PaymentTerm $paymentTerms = null;

    public function getOrganisationID(): ?string
    {
        return $this->organisationID;
    }

    public function setOrganisationID(?string $organisationID): self
    {
        $this->organisationID = $organisationID;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;

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

    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    public function setLegalName(?string $legalName): self
    {
        $this->legalName = $legalName;

        return $this;
    }

    public function getPaysTax(): ?bool
    {
        return $this->paysTax;
    }

    public function setPaysTax(?bool $paysTax): self
    {
        $this->paysTax = $paysTax;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getOrganisationType(): ?string
    {
        return $this->organisationType;
    }

    public function setOrganisationType(?string $organisationType): self
    {
        $this->organisationType = $organisationType;

        return $this;
    }

    public function getBaseCurrency(): ?string
    {
        return $this->baseCurrency;
    }

    public function setBaseCurrency(?string $baseCurrency): self
    {
        $this->baseCurrency = $baseCurrency;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getIsDemoCompany(): ?bool
    {
        return $this->isDemoCompany;
    }

    public function setIsDemoCompany(?bool $isDemoCompany): self
    {
        $this->isDemoCompany = $isDemoCompany;

        return $this;
    }

    public function getOrganisationStatus(): ?string
    {
        return $this->organisationStatus;
    }

    public function setOrganisationStatus(?string $organisationStatus): self
    {
        $this->organisationStatus = $organisationStatus;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getEmployerIdentificationNumber(): ?string
    {
        return $this->employerIdentificationNumber;
    }

    public function setEmployerIdentificationNumber(?string $employerIdentificationNumber): self
    {
        $this->employerIdentificationNumber = $employerIdentificationNumber;

        return $this;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(?string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getFinancialYearEndDay(): ?int
    {
        return $this->financialYearEndDay;
    }

    public function setFinancialYearEndDay(?int $financialYearEndDay): self
    {
        $this->financialYearEndDay = $financialYearEndDay;

        return $this;
    }

    public function getFinancialYearEndMonth(): ?int
    {
        return $this->financialYearEndMonth;
    }

    public function setFinancialYearEndMonth(?int $financialYearEndMonth): self
    {
        $this->financialYearEndMonth = $financialYearEndMonth;

        return $this;
    }

    public function getSalesTaxBasis(): ?string
    {
        return $this->salesTaxBasis;
    }

    public function setSalesTaxBasis(?string $salesTaxBasis): self
    {
        $this->salesTaxBasis = $salesTaxBasis;

        return $this;
    }

    public function getSalesTaxPeriod(): ?string
    {
        return $this->salesTaxPeriod;
    }

    public function setSalesTaxPeriod(?string $salesTaxPeriod): self
    {
        $this->salesTaxPeriod = $salesTaxPeriod;

        return $this;
    }

    public function getDefaultSalesTax(): ?string
    {
        return $this->defaultSalesTax;
    }

    public function setDefaultSalesTax(?string $defaultSalesTax): self
    {
        $this->defaultSalesTax = $defaultSalesTax;

        return $this;
    }

    public function getDefaultPurchasesTax(): ?string
    {
        return $this->defaultPurchasesTax;
    }

    public function setDefaultPurchasesTax(?string $defaultPurchasesTax): self
    {
        $this->defaultPurchasesTax = $defaultPurchasesTax;

        return $this;
    }

    public function getPeriodLockDate(): ?string
    {
        return $this->periodLockDate;
    }

    public function setPeriodLockDate(?string $periodLockDate): self
    {
        $this->periodLockDate = $periodLockDate;

        return $this;
    }

    public function getEndOfYearLockDate(): ?string
    {
        return $this->endOfYearLockDate;
    }

    public function setEndOfYearLockDate(?string $endOfYearLockDate): self
    {
        $this->endOfYearLockDate = $endOfYearLockDate;

        return $this;
    }

    public function getCreatedDateUTC(): ?string
    {
        return $this->createdDateUTC;
    }

    public function setCreatedDateUTC(?string $createdDateUTC): self
    {
        $this->createdDateUTC = $createdDateUTC;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getOrganisationEntityType(): ?string
    {
        return $this->organisationEntityType;
    }

    public function setOrganisationEntityType(?string $organisationEntityType): self
    {
        $this->organisationEntityType = $organisationEntityType;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getEdition(): ?string
    {
        return $this->edition;
    }

    public function setEdition(?string $edition): self
    {
        $this->edition = $edition;

        return $this;
    }

    public function getLineOfBusiness(): ?string
    {
        return $this->lineOfBusiness;
    }

    public function setLineOfBusiness(?string $lineOfBusiness): self
    {
        $this->lineOfBusiness = $lineOfBusiness;

        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->shortCode;
    }

    public function setShortCode(?string $shortCode): self
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * @return list<Address>
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * @return list<Phone>
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): self
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * @return list<ExternalLink>
     */
    public function getExternalLinks(): array
    {
        return $this->externalLinks;
    }

    public function addExternalLink(ExternalLink $externalLink): self
    {
        $this->externalLinks[] = $externalLink;

        return $this;
    }

    public function getPaymentTerms(): ?PaymentTerm
    {
        return $this->paymentTerms;
    }

    public function setPaymentTerms(?PaymentTerm $paymentTerms): self
    {
        $this->paymentTerms = $paymentTerms;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'OrganisationID' => Field::string(),
            'APIKey' => Field::string(),
            'Name' => Field::string(),
            'LegalName' => Field::string(),
            'PaysTax' => Field::boolean(),
            'Version' => Field::string(),
            'OrganisationType' => Field::string(),
            'BaseCurrency' => Field::string(),
            'CountryCode' => Field::string(),
            'IsDemoCompany' => Field::boolean(),
            'OrganisationStatus' => Field::string(),
            'RegistrationNumber' => Field::string(),
            'EmployerIdentificationNumber' => Field::string(),
            'TaxNumber' => Field::string(),
            'FinancialYearEndDay' => Field::number(),
            'FinancialYearEndMonth' => Field::number(),
            'SalesTaxBasis' => Field::string(),
            'SalesTaxPeriod' => Field::string(),
            'DefaultSalesTax' => Field::string(),
            'DefaultPurchasesTax' => Field::string(),
            'PeriodLockDate' => Field::string(),
            'EndOfYearLockDate' => Field::string(),
            'CreatedDateUTC' => Field::string(),
            'Timezone' => Field::string(),
            'OrganisationEntityType' => Field::string(),
            'Class' => Field::string(),
            'Edition' => Field::string(),
            'LineOfBusiness' => Field::string(),
            'ShortCode' => Field::string(),
            'Addresses' => Field::many(Address::class),
            'Phones' => Field::many(Phone::class),
            'ExternalLinks' => Field::many(ExternalLink::class),
            'PaymentTerms' => Field::object(PaymentTerm::class),
        ];
    }
}
