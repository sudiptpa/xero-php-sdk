<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class TaxRate extends Model implements SerializesRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $name = null;

    private ?string $taxType = null;

    private ?string $status = null;

    /**
     * @var list<Component>
     */
    private array $taxComponents = [];

    private ?string $reportTaxType = null;

    private ?bool $canApplyToAssets = null;

    private ?bool $canApplyToEquity = null;

    private ?bool $canApplyToExpenses = null;

    private ?bool $canApplyToLiabilities = null;

    private ?bool $canApplyToRevenue = null;

    private ?float $displayTaxRate = null;

    private ?float $effectiveRate = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setTaxType(?string $taxType): self
    {
        $this->taxType = $taxType;

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

    /**
     * @return list<Component>
     */
    public function getTaxComponents(): array
    {
        return $this->taxComponents;
    }

    /**
     * @param list<Component> $taxComponents
     */
    public function setTaxComponents(array $taxComponents): self
    {
        $this->taxComponents = $taxComponents;

        return $this;
    }

    public function addTaxComponent(Component $component): self
    {
        $this->taxComponents[] = $component;

        return $this;
    }

    public function getReportTaxType(): ?string
    {
        return $this->reportTaxType;
    }

    public function setReportTaxType(?string $reportTaxType): self
    {
        $this->reportTaxType = $reportTaxType;

        return $this;
    }

    public function getCanApplyToAssets(): ?bool
    {
        return $this->canApplyToAssets;
    }

    public function setCanApplyToAssets(?bool $canApplyToAssets): self
    {
        $this->canApplyToAssets = $canApplyToAssets;

        return $this;
    }

    public function getCanApplyToEquity(): ?bool
    {
        return $this->canApplyToEquity;
    }

    public function setCanApplyToEquity(?bool $canApplyToEquity): self
    {
        $this->canApplyToEquity = $canApplyToEquity;

        return $this;
    }

    public function getCanApplyToExpenses(): ?bool
    {
        return $this->canApplyToExpenses;
    }

    public function setCanApplyToExpenses(?bool $canApplyToExpenses): self
    {
        $this->canApplyToExpenses = $canApplyToExpenses;

        return $this;
    }

    public function getCanApplyToLiabilities(): ?bool
    {
        return $this->canApplyToLiabilities;
    }

    public function setCanApplyToLiabilities(?bool $canApplyToLiabilities): self
    {
        $this->canApplyToLiabilities = $canApplyToLiabilities;

        return $this;
    }

    public function getCanApplyToRevenue(): ?bool
    {
        return $this->canApplyToRevenue;
    }

    public function setCanApplyToRevenue(?bool $canApplyToRevenue): self
    {
        $this->canApplyToRevenue = $canApplyToRevenue;

        return $this;
    }

    public function getDisplayTaxRate(): ?float
    {
        return $this->displayTaxRate;
    }

    public function setDisplayTaxRate(?float $displayTaxRate): self
    {
        $this->displayTaxRate = $displayTaxRate;

        return $this;
    }

    public function getEffectiveRate(): ?float
    {
        return $this->effectiveRate;
    }

    public function setEffectiveRate(?float $effectiveRate): self
    {
        $this->effectiveRate = $effectiveRate;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Name' => Field::string(),
            'TaxType' => Field::string(),
            'Status' => Field::string(),
            'TaxComponents' => Field::many(Component::class),
            'ReportTaxType' => Field::string(),
            'CanApplyToAssets' => Field::boolean(),
            'CanApplyToEquity' => Field::boolean(),
            'CanApplyToExpenses' => Field::boolean(),
            'CanApplyToLiabilities' => Field::boolean(),
            'CanApplyToRevenue' => Field::boolean(),
            'DisplayTaxRate' => Field::number(),
            'EffectiveRate' => Field::number(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Name' => $this->getName(),
            'TaxType' => $this->getTaxType(),
            'Status' => $this->getStatus(),
            'TaxComponents' => array_map(
                static fn (Component $component): array => $component->toRequest(),
                $this->getTaxComponents()
            ),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function component(string $name, int|float $rate): self
    {
        return $this->addTaxComponent(
            (new Component())
                ->setName($name)
                ->setRate($rate)
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a tax rate without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }
}
