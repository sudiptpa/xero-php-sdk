<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Json;

final readonly class History
{
    public function __construct(
        private Client $client,
        private string $path
    ) {
    }

    /**
     * @return ResourceCollection<HistoryRecord>
     */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get($this->path)
            ->send()
            ->json();

        $items = array_map(
            static fn (array $history): HistoryRecord => new HistoryRecord(
                is_string($history['Details'] ?? null) ? $history['Details'] : null,
                is_string($history['DateUTC'] ?? null) ? $history['DateUTC'] : null,
                is_string($history['User'] ?? null) ? $history['User'] : null,
                $history
            ),
            Json::extractList($payload, 'HistoryRecords')
        );

        return new ResourceCollection($items);
    }

    public function record(string $details): HistoryRecord
    {
        $payload = $this->client
            ->put($this->path)
            ->withJson([
                'HistoryRecords' => [[
                    'Details' => $details,
                ]],
            ])
            ->send()
            ->json();

        $history = Json::extractFirst($payload, 'HistoryRecords') ?? [];

        return new HistoryRecord(
            is_string($history['Details'] ?? null) ? $history['Details'] : null,
            is_string($history['DateUTC'] ?? null) ? $history['DateUTC'] : null,
            is_string($history['User'] ?? null) ? $history['User'] : null,
            $history
        );
    }
}
