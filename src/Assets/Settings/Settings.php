<?php

declare(strict_types=1);

namespace Sujip\Xero\Assets\Settings;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Settings extends Model
{
    private ?string $assetNumberPrefix = null;

    private ?string $assetNumberSequence = null;

    private ?string $assetStartDate = null;

    private ?string $lastDepreciationDate = null;

    private ?string $defaultGainOnDisposalAccountId = null;

    private ?string $defaultLossOnDisposalAccountId = null;

    private ?string $defaultCapitalGainOnDisposalAccountId = null;

    private ?bool $optInForTax = null;

    public static function fetch(Client $client): self
    {
        $response = $client
            ->get('/assets.xro/1.0/Settings')
            ->send();

        return (new self())->fill($response->json());
    }

    public function getAssetNumberPrefix(): ?string
    {
        return $this->assetNumberPrefix;
    }

    public function setAssetNumberPrefix(?string $assetNumberPrefix): self
    {
        $this->assetNumberPrefix = $assetNumberPrefix;

        return $this;
    }

    public function getAssetNumberSequence(): ?string
    {
        return $this->assetNumberSequence;
    }

    public function setAssetNumberSequence(?string $assetNumberSequence): self
    {
        $this->assetNumberSequence = $assetNumberSequence;

        return $this;
    }

    public function getAssetStartDate(): ?string
    {
        return $this->assetStartDate;
    }

    public function setAssetStartDate(?string $assetStartDate): self
    {
        $this->assetStartDate = $assetStartDate;

        return $this;
    }

    public function getLastDepreciationDate(): ?string
    {
        return $this->lastDepreciationDate;
    }

    public function setLastDepreciationDate(?string $lastDepreciationDate): self
    {
        $this->lastDepreciationDate = $lastDepreciationDate;

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

    public function getOptInForTax(): ?bool
    {
        return $this->optInForTax;
    }

    public function setOptInForTax(?bool $optInForTax): self
    {
        $this->optInForTax = $optInForTax;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'assetNumberPrefix' => Field::string(),
            'assetNumberSequence' => Field::string(),
            'assetStartDate' => Field::string(),
            'lastDepreciationDate' => Field::string(),
            'defaultGainOnDisposalAccountId' => Field::string(),
            'defaultLossOnDisposalAccountId' => Field::string(),
            'defaultCapitalGainOnDisposalAccountId' => Field::string(),
            'optInForTax' => Field::boolean(),
        ];
    }
}
