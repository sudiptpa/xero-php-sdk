<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Json;

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
        $items = array_map(
            static fn (array $history): HistoryRecord => new HistoryRecord(
                is_string($history['Details'] ?? null) ? $history['Details'] : null,
                is_string($history['User'] ?? null) ? $history['User'] : null,
                is_string($history['Changes'] ?? null) ? $history['Changes'] : null,
                $history
            ),
            Json::extractList($payload, 'HistoryRecords')
        );

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
        $history = Json::extractFirst($payload, 'HistoryRecords') ?? [];

        return new HistoryRecord(
            is_string($history['Details'] ?? null) ? $history['Details'] : null,
            is_string($history['User'] ?? null) ? $history['User'] : null,
            is_string($history['Changes'] ?? null) ? $history['Changes'] : null,
            $history
        );
    }
}
