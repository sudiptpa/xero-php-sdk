<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PaymentService;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PaymentService extends Model
{
    private ?string $paymentServiceName = null;

    private ?string $paymentServiceUrl = null;

    private ?string $payNowText = null;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'PaymentServiceName' => Field::string(),
            'PaymentServiceUrl' => Field::string(),
            'PayNowText' => Field::string(),
        ];
    }
}
