<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

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

        $items = array_values(array_map(
            static fn (array $history): HistoryRecord => new HistoryRecord(
                isset($history['Details']) ? (string) $history['Details'] : null,
                isset($history['DateUTC']) ? (string) $history['DateUTC'] : null,
                isset($history['User']) ? (string) $history['User'] : null,
                $history
            ),
            $payload['HistoryRecords'] ?? []
        ));

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

        $history = $payload['HistoryRecords'][0] ?? [];

        $history = is_array($history) ? $history : [];

        return new HistoryRecord(
            isset($history['Details']) ? (string) $history['Details'] : null,
            isset($history['DateUTC']) ? (string) $history['DateUTC'] : null,
            isset($history['User']) ? (string) $history['User'] : null,
            $history
        );
    }
}
