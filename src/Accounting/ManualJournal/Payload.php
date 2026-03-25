<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $manualJournalId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $manualJournalId): self
    {
        $clone = clone $this;
        $clone->manualJournalId = $manualJournalId;

        return $clone;
    }

    public function narration(string $narration): self
    {
        $clone = clone $this;
        $clone->payload['Narration'] = $narration;

        return $clone;
    }

    public function line(int|float $lineAmount, string $accountCode, bool $isDebit = true): self
    {
        $clone = clone $this;
        $clone->payload['JournalLines'] ??= [];
        $clone->payload['JournalLines'][] = [
            'LineAmount' => $lineAmount,
            'AccountCode' => $accountCode,
            'IsDebit' => $isDebit,
        ];

        return $clone;
    }

    public function save(): ManualJournal
    {
        if ($this->manualJournalId !== null) {
            $this->payload['ManualJournalID'] = $this->manualJournalId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/ManualJournals')
            ->withJson(['ManualJournals' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $manualJournal = $payload['ManualJournals'][0] ?? [];

        return ManualJournal::fromArray(is_array($manualJournal) ? $manualJournal : [], $this->client);
    }
}
