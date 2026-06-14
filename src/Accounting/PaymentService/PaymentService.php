<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PaymentService;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class PaymentService extends Model
{
    private ?string $paymentServiceID = null;

    private ?string $paymentServiceType = null;

    private ?string $paymentServiceName = null;

    private ?string $paymentServiceUrl = null;

    private ?string $payNowText = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function getPaymentServiceID(): ?string
    {
        return $this->paymentServiceID;
    }

    public function setPaymentServiceID(?string $paymentServiceID): self
    {
        $this->paymentServiceID = $paymentServiceID;

        return $this;
    }

    public function getPaymentServiceType(): ?string
    {
        return $this->paymentServiceType;
    }

    public function setPaymentServiceType(?string $paymentServiceType): self
    {
        $this->paymentServiceType = $paymentServiceType;

        return $this;
    }

    public function getPaymentServiceName(): ?string
    {
        return $this->paymentServiceName;
    }

    public function setPaymentServiceName(?string $paymentServiceName): self
    {
        $this->paymentServiceName = $paymentServiceName;

        return $this;
    }

    public function getPaymentServiceUrl(): ?string
    {
        return $this->paymentServiceUrl;
    }

    public function setPaymentServiceUrl(?string $paymentServiceUrl): self
    {
        $this->paymentServiceUrl = $paymentServiceUrl;

        return $this;
    }

    public function getPayNowText(): ?string
    {
        return $this->payNowText;
    }

    public function setPayNowText(?string $payNowText): self
    {
        $this->payNowText = $payNowText;

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
            'PaymentServiceID' => Field::string(),
            'PaymentServiceType' => Field::string(),
            'PaymentServiceName' => Field::string(),
            'PaymentServiceUrl' => Field::string(),
            'PayNowText' => Field::string(),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }
}
