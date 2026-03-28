<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Overpayment;

use Sujip\Xero\Support\Contracts\BuildsFromPayload;

final class Overpayment implements BuildsFromPayload
{
    private ?string $overpaymentID = null;

    private ?string $type = null;

    private ?string $status = null;

    private int|float|null $remainingCredit = null;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?\Sujip\Xero\Client $client = null): static
    {
        return (new self())
            ->setOverpaymentID($payload['OverpaymentID'] ?? null)
            ->setType($payload['Type'] ?? null)
            ->setStatus($payload['Status'] ?? null)
            ->setRemainingCredit($payload['RemainingCredit'] ?? null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return self::fromPayload($payload);
    }

    public function getOverpaymentID(): ?string
    {
        return $this->overpaymentID;
    }

    public function setOverpaymentID(?string $overpaymentID): self
    {
        $this->overpaymentID = $overpaymentID;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRemainingCredit(): int|float|null
    {
        return $this->remainingCredit;
    }

    public function setRemainingCredit(int|float|null $remainingCredit): self
    {
        $this->remainingCredit = $remainingCredit;

        return $this;
    }
}
