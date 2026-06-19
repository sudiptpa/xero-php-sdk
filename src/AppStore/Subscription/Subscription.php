<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore\Subscription;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ResourceCollection;

final class Subscription extends Model
{
    /**
     * @param list<Plan> $plans
     */
    public function __construct(
        private ?Client $client = null,
        private ?string $id = null,
        private ?string $organisationId = null,
        private ?string $status = null,
        private ?string $startDate = null,
        private ?string $currentPeriodEnd = null,
        private ?string $endDate = null,
        private ?bool $testMode = null,
        private array $plans = [],
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getOrganisationId(): ?string
    {
        return $this->organisationId;
    }

    public function setOrganisationId(?string $organisationId): self
    {
        $this->organisationId = $organisationId;

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

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getCurrentPeriodEnd(): ?string
    {
        return $this->currentPeriodEnd;
    }

    public function setCurrentPeriodEnd(?string $currentPeriodEnd): self
    {
        $this->currentPeriodEnd = $currentPeriodEnd;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTestMode(): ?bool
    {
        return $this->testMode;
    }

    public function setTestMode(?bool $testMode): self
    {
        $this->testMode = $testMode;

        return $this;
    }

    /**
     * @return list<Plan>
     */
    public function getPlans(): array
    {
        return $this->plans;
    }

    /**
     * @param list<Plan> $plans
     */
    public function setPlans(array $plans): self
    {
        $this->plans = $plans;

        return $this;
    }

    public function addPlan(Plan $plan): self
    {
        $this->plans[] = $plan;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'id' => Field::string()->using('setId'),
            'organisationId' => Field::string()->using('setOrganisationId'),
            'status' => Field::string()->using('setStatus'),
            'startDate' => Field::string()->using('setStartDate'),
            'currentPeriodEnd' => Field::string()->using('setCurrentPeriodEnd'),
            'endDate' => Field::string()->using('setEndDate'),
            'testMode' => Field::boolean()->using('setTestMode'),
            'plans' => Field::many(Plan::class)->using('addPlan'),
        ];
    }

    /**
     * @return ResourceCollection<UsageRecord>
     */
    public function usageRecords(): ResourceCollection
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load usage records without a bound client context and subscription id.');
        }

        return (new Subscriptions($this->client))->usageRecords($this->id);
    }

    public function recordUsage(): UsageRecordPayload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot record usage without a bound client context and subscription id.');
        }

        return (new Subscriptions($this->client))->recordUsage($this->id);
    }
}
