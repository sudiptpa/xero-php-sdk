<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

final readonly class History
{
    public function __construct(
        private Client $client,
        private string $creditNoteId
    ) {
    }

    /**
     * @return ResourceCollection<HistoryRecord>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/CreditNotes/' . $this->creditNoteId . '/History')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $history): HistoryRecord => new HistoryRecord(
                $history['Details'] ?? null,
                $history['User'] ?? null,
                $history['Changes'] ?? null,
                $history
            ),
            $payload['HistoryRecords'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function record(string $details): HistoryRecord
    {
        $response = $this->client
            ->put('/api.xro/2.0/CreditNotes/' . $this->creditNoteId . '/History')
            ->withJson([
                'HistoryRecords' => [[
                    'Details' => $details,
                ]],
            ])
            ->send();

        $payload = $response->json();
        $history = $payload['HistoryRecords'][0] ?? [];

        $history = is_array($history) ? $history : [];

        return new HistoryRecord(
            $history['Details'] ?? null,
            $history['User'] ?? null,
            $history['Changes'] ?? null,
            $history
        );
    }
}
