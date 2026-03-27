<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Client;

final class Payload
{
    private ManualJournal $manualJournal;

    public function __construct(
        private readonly Client $client
    ) {
        $this->manualJournal = new ManualJournal($client);
    }

    public function id(string $manualJournalId): self
    {
        $clone = clone $this;
        $clone->manualJournal = clone $this->manualJournal;
        $clone->manualJournal->setManualJournalID($manualJournalId);

        return $clone;
    }

    public function narration(string $narration): self
    {
        $clone = clone $this;
        $clone->manualJournal = clone $this->manualJournal;
        $clone->manualJournal->setNarration($narration);

        return $clone;
    }

    public function line(int|float $lineAmount, string $accountCode, bool $isDebit = true): self
    {
        $clone = clone $this;
        $clone->manualJournal = clone $this->manualJournal;
        $clone->manualJournal->addJournalLine(
            (new JournalLine())
                ->setLineAmount($lineAmount)
                ->setAccountCode($accountCode)
                ->setIsDebit($isDebit)
        );

        return $clone;
    }

    public function using(ManualJournal $manualJournal): self
    {
        $clone = clone $this;
        $clone->manualJournal = clone $manualJournal;

        return $clone;
    }

    public function save(): ManualJournal
    {
        $response = $this->client
            ->post('/api.xro/2.0/ManualJournals')
            ->withJson(['ManualJournals' => [$this->manualJournal->toRequest()]])
            ->send();

        $payload = $response->json();
        $manualJournal = $payload['ManualJournals'][0] ?? [];

        return ManualJournal::fromPayload(is_array($manualJournal) ? $manualJournal : [], $this->client);
    }
}
