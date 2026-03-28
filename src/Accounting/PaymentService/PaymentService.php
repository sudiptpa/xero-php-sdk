<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PaymentService;

final class PaymentService
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

}
