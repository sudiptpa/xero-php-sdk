<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $attributes = [];

    private ?string $superFundId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $superFundId): self
    {
        $clone = clone $this;
        $clone->superFundId = $superFundId;

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->attributes['Type'] = $type;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->attributes['Name'] = $name;

        return $clone;
    }

    public function uSI(string $usi): self
    {
        $clone = clone $this;
        $clone->attributes['USI'] = $usi;

        return $clone;
    }

    public function abn(string $abn): self
    {
        $clone = clone $this;
        $clone->attributes['ABN'] = $abn;

        return $clone;
    }

    public function bsb(string $bsb): self
    {
        $clone = clone $this;
        $clone->attributes['BSB'] = $bsb;

        return $clone;
    }

    public function accountNumber(string $accountNumber): self
    {
        $clone = clone $this;
        $clone->attributes['AccountNumber'] = $accountNumber;

        return $clone;
    }

    public function accountName(string $accountName): self
    {
        $clone = clone $this;
        $clone->attributes['AccountName'] = $accountName;

        return $clone;
    }

    public function electronicServiceAddress(string $electronicServiceAddress): self
    {
        $clone = clone $this;
        $clone->attributes['ElectronicServiceAddress'] = $electronicServiceAddress;

        return $clone;
    }

    public function employerNumber(string $employerNumber): self
    {
        $clone = clone $this;
        $clone->attributes['EmployerNumber'] = $employerNumber;

        return $clone;
    }

    public function spin(string $spin): self
    {
        $clone = clone $this;
        $clone->attributes['SPIN'] = $spin;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): SuperFund
    {
        $request = $this->superFundId === null
            ? $this->client->post('/payroll.xro/1.0/SuperFunds')
            : $this->client->post('/payroll.xro/1.0/SuperFunds/' . $this->superFundId);

        if ($this->superFundId !== null) {
            $this->attributes['SuperFundID'] = $this->superFundId;
        }

        $payload = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->contentTypeJson()
            ->withBody(Json::encodeList([$this->attributes]))
            ->send()
            ->json();

        $fund = Json::extractFirst($payload, 'SuperFunds') ?? Json::extractObject($payload, 'SuperFund') ?: null;

        if ($fund === null) {
            return new SuperFund();
        }

        return (new SuperFunds($this->client))->mapSuperFund($fund);
    }
}
