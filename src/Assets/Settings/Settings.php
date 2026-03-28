<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Settings;

use Sujip\Xero\Client;

final class Settings
{
    private ?bool $depreciationCalculationEnabled = null;

    private ?string $defaultGainOnDisposalAccountId = null;

    private ?string $defaultLossOnDisposalAccountId = null;

    private ?string $defaultCapitalGainOnDisposalAccountId = null;

    public static function fetch(Client $client): ?self
    {
        $response = $client
            ->get('/assets.xro/1.0/Settings')
            ->send();

        $payload = $response->json();
        $settings = $payload['Items'][0] ?? null;

        if (! is_array($settings)) {
            return null;
        }

        return (new self())
            ->setDepreciationCalculationEnabled($settings['DepreciationCalculationEnabled'] ?? null)
            ->setDefaultGainOnDisposalAccountId($settings['DefaultGainOnDisposalAccountId'] ?? null)
            ->setDefaultLossOnDisposalAccountId($settings['DefaultLossOnDisposalAccountId'] ?? null)
            ->setDefaultCapitalGainOnDisposalAccountId($settings['DefaultCapitalGainOnDisposalAccountId'] ?? null);
    }

    public function getDepreciationCalculationEnabled(): ?bool
    {
        return $this->depreciationCalculationEnabled;
    }

    public function setDepreciationCalculationEnabled(?bool $depreciationCalculationEnabled): self
    {
        $this->depreciationCalculationEnabled = $depreciationCalculationEnabled;

        return $this;
    }

    public function getDefaultGainOnDisposalAccountId(): ?string
    {
        return $this->defaultGainOnDisposalAccountId;
    }

    public function setDefaultGainOnDisposalAccountId(?string $defaultGainOnDisposalAccountId): self
    {
        $this->defaultGainOnDisposalAccountId = $defaultGainOnDisposalAccountId;

        return $this;
    }

    public function getDefaultLossOnDisposalAccountId(): ?string
    {
        return $this->defaultLossOnDisposalAccountId;
    }

    public function setDefaultLossOnDisposalAccountId(?string $defaultLossOnDisposalAccountId): self
    {
        $this->defaultLossOnDisposalAccountId = $defaultLossOnDisposalAccountId;

        return $this;
    }

    public function getDefaultCapitalGainOnDisposalAccountId(): ?string
    {
        return $this->defaultCapitalGainOnDisposalAccountId;
    }

    public function setDefaultCapitalGainOnDisposalAccountId(?string $defaultCapitalGainOnDisposalAccountId): self
    {
        $this->defaultCapitalGainOnDisposalAccountId = $defaultCapitalGainOnDisposalAccountId;

        return $this;
    }
}
