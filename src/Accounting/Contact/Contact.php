<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use RuntimeException;
use Sujip\Xero\Accounting\BrandingTheme\BrandingTheme;
use Sujip\Xero\Accounting\ContactGroup\ContactGroup;
use Sujip\Xero\Accounting\Organisation\PaymentTerm;
use Sujip\Xero\Client;
use Sujip\Xero\Support\AttachmentDetail;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Contact extends Model implements SerializesRequest
{
    private ?string $contactID = null;

    private ?string $name = null;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $emailAddress = null;

    /**
     * @var list<Address>
     */
    private array $addresses = [];

    /**
     * @var list<Phone>
     */
    private array $phones = [];

    private ?string $mergedToContactID = null;

    private ?string $contactNumber = null;

    private ?string $accountNumber = null;

    private ?string $contactStatus = null;

    private ?string $companyNumber = null;

    /**
     * @var list<ContactPerson>
     */
    private array $contactPersons = [];

    private ?string $bankAccountDetails = null;

    private ?string $taxNumber = null;

    private ?string $taxNumberType = null;

    private ?string $accountsReceivableTaxType = null;

    private ?string $accountsPayableTaxType = null;

    private ?bool $isSupplier = null;

    private ?bool $isCustomer = null;

    private ?string $salesDefaultLineAmountType = null;

    private ?string $purchasesDefaultLineAmountType = null;

    private ?string $defaultCurrency = null;

    private ?string $xeroNetworkKey = null;

    private ?string $salesDefaultAccountCode = null;

    private ?string $purchasesDefaultAccountCode = null;

    /**
     * @var list<SalesTrackingCategory>
     */
    private array $salesTrackingCategories = [];

    /**
     * @var list<SalesTrackingCategory>
     */
    private array $purchasesTrackingCategories = [];

    private ?string $trackingCategoryName = null;

    private ?string $trackingCategoryOption = null;

    private ?PaymentTerm $paymentTerms = null;

    private ?string $updatedDateUTC = null;

    /**
     * @var list<ContactGroup>
     */
    private array $contactGroups = [];

    private ?string $website = null;

    private ?BrandingTheme $brandingTheme = null;

    private ?BatchPaymentDetails $batchPayments = null;

    private int|float|null $discount = null;

    private ?Balances $balances = null;

    /**
     * @var list<AttachmentDetail>
     */
    private array $attachments = [];

    private ?bool $hasAttachments = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    private ?bool $hasValidationErrors = null;

    private ?string $statusAttributeString = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getContactID(): ?string
    {
        return $this->contactID;
    }

    public function setContactID(?string $contactID): self
    {
        $this->contactID = $contactID;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return list<Address>
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @param list<Address> $addresses
     */
    public function setAddresses(array $addresses): self
    {
        $this->addresses = $addresses;

        return $this;
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

    /**
     * @param list<Phone> $phones
     */
    public function setPhones(array $phones): self
    {
        $this->phones = $phones;

        return $this;
    }

    public function addPhone(Phone $phone): self
    {
        $this->phones[] = $phone;

        return $this;
    }

    public function getMergedToContactID(): ?string
    {
        return $this->mergedToContactID;
    }

    public function setMergedToContactID(?string $mergedToContactID): self
    {
        $this->mergedToContactID = $mergedToContactID;

        return $this;
    }

    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    public function setContactNumber(?string $contactNumber): self
    {
        $this->contactNumber = $contactNumber;

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

    public function getContactStatus(): ?string
    {
        return $this->contactStatus;
    }

    public function setContactStatus(?string $contactStatus): self
    {
        $this->contactStatus = $contactStatus;

        return $this;
    }

    public function getCompanyNumber(): ?string
    {
        return $this->companyNumber;
    }

    public function setCompanyNumber(?string $companyNumber): self
    {
        $this->companyNumber = $companyNumber;

        return $this;
    }

    /**
     * @return list<ContactPerson>
     */
    public function getContactPersons(): array
    {
        return $this->contactPersons;
    }

    public function addContactPerson(ContactPerson $contactPerson): self
    {
        $this->contactPersons[] = $contactPerson;

        return $this;
    }

    public function getBankAccountDetails(): ?string
    {
        return $this->bankAccountDetails;
    }

    public function setBankAccountDetails(?string $bankAccountDetails): self
    {
        $this->bankAccountDetails = $bankAccountDetails;

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

    public function getTaxNumberType(): ?string
    {
        return $this->taxNumberType;
    }

    public function setTaxNumberType(?string $taxNumberType): self
    {
        $this->taxNumberType = $taxNumberType;

        return $this;
    }

    public function getAccountsReceivableTaxType(): ?string
    {
        return $this->accountsReceivableTaxType;
    }

    public function setAccountsReceivableTaxType(?string $accountsReceivableTaxType): self
    {
        $this->accountsReceivableTaxType = $accountsReceivableTaxType;

        return $this;
    }

    public function getAccountsPayableTaxType(): ?string
    {
        return $this->accountsPayableTaxType;
    }

    public function setAccountsPayableTaxType(?string $accountsPayableTaxType): self
    {
        $this->accountsPayableTaxType = $accountsPayableTaxType;

        return $this;
    }

    public function getIsSupplier(): ?bool
    {
        return $this->isSupplier;
    }

    public function setIsSupplier(?bool $isSupplier): self
    {
        $this->isSupplier = $isSupplier;

        return $this;
    }

    public function getIsCustomer(): ?bool
    {
        return $this->isCustomer;
    }

    public function setIsCustomer(?bool $isCustomer): self
    {
        $this->isCustomer = $isCustomer;

        return $this;
    }

    public function getSalesDefaultLineAmountType(): ?string
    {
        return $this->salesDefaultLineAmountType;
    }

    public function setSalesDefaultLineAmountType(?string $salesDefaultLineAmountType): self
    {
        $this->salesDefaultLineAmountType = $salesDefaultLineAmountType;

        return $this;
    }

    public function getPurchasesDefaultLineAmountType(): ?string
    {
        return $this->purchasesDefaultLineAmountType;
    }

    public function setPurchasesDefaultLineAmountType(?string $purchasesDefaultLineAmountType): self
    {
        $this->purchasesDefaultLineAmountType = $purchasesDefaultLineAmountType;

        return $this;
    }

    public function getDefaultCurrency(): ?string
    {
        return $this->defaultCurrency;
    }

    public function setDefaultCurrency(?string $defaultCurrency): self
    {
        $this->defaultCurrency = $defaultCurrency;

        return $this;
    }

    public function getXeroNetworkKey(): ?string
    {
        return $this->xeroNetworkKey;
    }

    public function setXeroNetworkKey(?string $xeroNetworkKey): self
    {
        $this->xeroNetworkKey = $xeroNetworkKey;

        return $this;
    }

    public function getSalesDefaultAccountCode(): ?string
    {
        return $this->salesDefaultAccountCode;
    }

    public function setSalesDefaultAccountCode(?string $salesDefaultAccountCode): self
    {
        $this->salesDefaultAccountCode = $salesDefaultAccountCode;

        return $this;
    }

    public function getPurchasesDefaultAccountCode(): ?string
    {
        return $this->purchasesDefaultAccountCode;
    }

    public function setPurchasesDefaultAccountCode(?string $purchasesDefaultAccountCode): self
    {
        $this->purchasesDefaultAccountCode = $purchasesDefaultAccountCode;

        return $this;
    }

    /**
     * @return list<SalesTrackingCategory>
     */
    public function getSalesTrackingCategories(): array
    {
        return $this->salesTrackingCategories;
    }

    public function addSalesTrackingCategory(SalesTrackingCategory $salesTrackingCategory): self
    {
        $this->salesTrackingCategories[] = $salesTrackingCategory;

        return $this;
    }

    /**
     * @return list<SalesTrackingCategory>
     */
    public function getPurchasesTrackingCategories(): array
    {
        return $this->purchasesTrackingCategories;
    }

    public function addPurchasesTrackingCategory(SalesTrackingCategory $purchasesTrackingCategory): self
    {
        $this->purchasesTrackingCategories[] = $purchasesTrackingCategory;

        return $this;
    }

    public function getTrackingCategoryName(): ?string
    {
        return $this->trackingCategoryName;
    }

    public function setTrackingCategoryName(?string $trackingCategoryName): self
    {
        $this->trackingCategoryName = $trackingCategoryName;

        return $this;
    }

    public function getTrackingCategoryOption(): ?string
    {
        return $this->trackingCategoryOption;
    }

    public function setTrackingCategoryOption(?string $trackingCategoryOption): self
    {
        $this->trackingCategoryOption = $trackingCategoryOption;

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

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

        return $this;
    }

    /**
     * @return list<ContactGroup>
     */
    public function getContactGroups(): array
    {
        return $this->contactGroups;
    }

    public function addContactGroup(ContactGroup $contactGroup): self
    {
        $this->contactGroups[] = $contactGroup;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getBrandingTheme(): ?BrandingTheme
    {
        return $this->brandingTheme;
    }

    public function setBrandingTheme(?BrandingTheme $brandingTheme): self
    {
        $this->brandingTheme = $brandingTheme;

        return $this;
    }

    public function getBatchPayments(): ?BatchPaymentDetails
    {
        return $this->batchPayments;
    }

    public function setBatchPayments(?BatchPaymentDetails $batchPayments): self
    {
        $this->batchPayments = $batchPayments;

        return $this;
    }

    public function getDiscount(): int|float|null
    {
        return $this->discount;
    }

    public function setDiscount(int|float|null $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getBalances(): ?Balances
    {
        return $this->balances;
    }

    public function setBalances(?Balances $balances): self
    {
        $this->balances = $balances;

        return $this;
    }

    /**
     * @return list<AttachmentDetail>
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function addAttachment(AttachmentDetail $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    public function getHasAttachments(): ?bool
    {
        return $this->hasAttachments;
    }

    public function setHasAttachments(?bool $hasAttachments): self
    {
        $this->hasAttachments = $hasAttachments;

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

    public function getHasValidationErrors(): ?bool
    {
        return $this->hasValidationErrors;
    }

    public function setHasValidationErrors(?bool $hasValidationErrors): self
    {
        $this->hasValidationErrors = $hasValidationErrors;

        return $this;
    }

    public function getStatusAttributeString(): ?string
    {
        return $this->statusAttributeString;
    }

    public function setStatusAttributeString(?string $statusAttributeString): self
    {
        $this->statusAttributeString = $statusAttributeString;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ContactID' => Field::string(),
            'Name' => Field::string(),
            'FirstName' => Field::string(),
            'LastName' => Field::string(),
            'EmailAddress' => Field::string(),
            'Addresses' => Field::many(Address::class),
            'Phones' => Field::many(Phone::class),
            'MergedToContactID' => Field::string(),
            'ContactNumber' => Field::string(),
            'AccountNumber' => Field::string(),
            'ContactStatus' => Field::string(),
            'CompanyNumber' => Field::string(),
            'ContactPersons' => Field::many(ContactPerson::class),
            'BankAccountDetails' => Field::string(),
            'TaxNumber' => Field::string(),
            'TaxNumberType' => Field::string(),
            'AccountsReceivableTaxType' => Field::string(),
            'AccountsPayableTaxType' => Field::string(),
            'IsSupplier' => Field::boolean(),
            'IsCustomer' => Field::boolean(),
            'SalesDefaultLineAmountType' => Field::string(),
            'PurchasesDefaultLineAmountType' => Field::string(),
            'DefaultCurrency' => Field::string(),
            'XeroNetworkKey' => Field::string(),
            'SalesDefaultAccountCode' => Field::string(),
            'PurchasesDefaultAccountCode' => Field::string(),
            'SalesTrackingCategories' => Field::many(SalesTrackingCategory::class),
            'PurchasesTrackingCategories' => Field::many(SalesTrackingCategory::class),
            'TrackingCategoryName' => Field::string(),
            'TrackingCategoryOption' => Field::string(),
            'PaymentTerms' => Field::object(PaymentTerm::class),
            'UpdatedDateUTC' => Field::string(),
            'ContactGroups' => Field::many(ContactGroup::class),
            'Website' => Field::string(),
            'BrandingTheme' => Field::object(BrandingTheme::class),
            'BatchPayments' => Field::object(BatchPaymentDetails::class),
            'Discount' => Field::number(),
            'Balances' => Field::object(Balances::class),
            'Attachments' => Field::many(AttachmentDetail::class),
            'HasAttachments' => Field::boolean(),
            'ValidationErrors' => Field::many(ValidationError::class),
            'HasValidationErrors' => Field::boolean(),
            'StatusAttributeString' => Field::string(),
        ];
    }

    protected function newDefinitionInstance(string $class): object
    {
        if ($class === ContactGroup::class) {
            return new ContactGroup($this->client);
        }

        return parent::newDefinitionInstance($class);
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'ContactID' => $this->getContactID(),
            'Name' => $this->getName(),
            'FirstName' => $this->getFirstName(),
            'LastName' => $this->getLastName(),
            'EmailAddress' => $this->getEmailAddress(),
            'Addresses' => array_map(
                static fn (Address $address): array => $address->toRequest(),
                $this->getAddresses()
            ),
            'Phones' => array_map(
                static fn (Phone $phone): array => $phone->toRequest(),
                $this->getPhones()
            ),
            'ContactNumber' => $this->getContactNumber(),
            'AccountNumber' => $this->getAccountNumber(),
            'ContactStatus' => $this->getContactStatus(),
            'CompanyNumber' => $this->getCompanyNumber(),
            'ContactPersons' => array_map(
                static fn (ContactPerson $contactPerson): array => $contactPerson->toRequest(),
                $this->getContactPersons()
            ),
            'BankAccountDetails' => $this->getBankAccountDetails(),
            'TaxNumber' => $this->getTaxNumber(),
            'AccountsReceivableTaxType' => $this->getAccountsReceivableTaxType(),
            'AccountsPayableTaxType' => $this->getAccountsPayableTaxType(),
            'SalesDefaultLineAmountType' => $this->getSalesDefaultLineAmountType(),
            'PurchasesDefaultLineAmountType' => $this->getPurchasesDefaultLineAmountType(),
            'DefaultCurrency' => $this->getDefaultCurrency(),
            'SalesDefaultAccountCode' => $this->getSalesDefaultAccountCode(),
            'PurchasesDefaultAccountCode' => $this->getPurchasesDefaultAccountCode(),
            'SalesTrackingCategories' => array_map(
                static fn (SalesTrackingCategory $category): array => $category->toRequest(),
                $this->getSalesTrackingCategories()
            ),
            'PurchasesTrackingCategories' => array_map(
                static fn (SalesTrackingCategory $category): array => $category->toRequest(),
                $this->getPurchasesTrackingCategories()
            ),
            'PaymentTerms' => $this->getPaymentTerms()?->toRequest(),
            'BatchPayments' => $this->getBatchPayments()?->toRequest(),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a contact without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }
}
