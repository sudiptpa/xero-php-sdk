<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PaymentService;

final readonly class PaymentService
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $paymentServiceName,
        public ?string $paymentServiceUrl,
        public ?string $payNowText,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['PaymentServiceName'] ?? null,
            $payload['PaymentServiceUrl'] ?? null,
            $payload['PayNowText'] ?? null,
            $payload
        );
    }
}
