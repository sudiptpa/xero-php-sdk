<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Employee;

use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class EmployeeOpeningBalances extends Model implements SerializesRequest
{
    private ?float $statutoryAdoptionPay = null;

    private ?float $statutoryMaternityPay = null;

    private ?float $statutoryPaternityPay = null;

    private ?float $statutorySharedParentalPay = null;

    private ?float $statutorySickPay = null;

    private ?float $priorEmployeeNumber = null;

    public function getStatutoryAdoptionPay(): ?float
    {
        return $this->statutoryAdoptionPay;
    }

    public function setStatutoryAdoptionPay(?float $statutoryAdoptionPay): self
    {
        $this->statutoryAdoptionPay = $statutoryAdoptionPay;

        return $this;
    }

    public function getStatutoryMaternityPay(): ?float
    {
        return $this->statutoryMaternityPay;
    }

    public function setStatutoryMaternityPay(?float $statutoryMaternityPay): self
    {
        $this->statutoryMaternityPay = $statutoryMaternityPay;

        return $this;
    }

    public function getStatutoryPaternityPay(): ?float
    {
        return $this->statutoryPaternityPay;
    }

    public function setStatutoryPaternityPay(?float $statutoryPaternityPay): self
    {
        $this->statutoryPaternityPay = $statutoryPaternityPay;

        return $this;
    }

    public function getStatutorySharedParentalPay(): ?float
    {
        return $this->statutorySharedParentalPay;
    }

    public function setStatutorySharedParentalPay(?float $statutorySharedParentalPay): self
    {
        $this->statutorySharedParentalPay = $statutorySharedParentalPay;

        return $this;
    }

    public function getStatutorySickPay(): ?float
    {
        return $this->statutorySickPay;
    }

    public function setStatutorySickPay(?float $statutorySickPay): self
    {
        $this->statutorySickPay = $statutorySickPay;

        return $this;
    }

    public function getPriorEmployeeNumber(): ?float
    {
        return $this->priorEmployeeNumber;
    }

    public function setPriorEmployeeNumber(?float $priorEmployeeNumber): self
    {
        $this->priorEmployeeNumber = $priorEmployeeNumber;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'statutoryAdoptionPay' => Field::number(),
            'statutoryMaternityPay' => Field::number(),
            'statutoryPaternityPay' => Field::number(),
            'statutorySharedParentalPay' => Field::number(),
            'statutorySickPay' => Field::number(),
            'priorEmployeeNumber' => Field::number(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'statutoryAdoptionPay' => $this->getStatutoryAdoptionPay(),
            'statutoryMaternityPay' => $this->getStatutoryMaternityPay(),
            'statutoryPaternityPay' => $this->getStatutoryPaternityPay(),
            'statutorySharedParentalPay' => $this->getStatutorySharedParentalPay(),
            'statutorySickPay' => $this->getStatutorySickPay(),
            'priorEmployeeNumber' => $this->getPriorEmployeeNumber(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
