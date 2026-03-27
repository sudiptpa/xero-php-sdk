<?php

declare(strict_types=1);

namespace Sujip\Xero\Identity;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

final readonly class Connections
{
    public function __construct(
        private Client $client
    ) {
    }

    /**
     * @return ResourceCollection<Connection>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/connections')
            ->withoutTenant()
            ->send();

        $decoded = json_decode($response->body, true);

        /** @var list<array<string, mixed>> $rows */
        $rows = is_array($decoded) ? array_values($decoded) : [];

        $items = array_map(
            fn (array $connection): Connection => Connection::fromArray($connection, $this->client),
            $rows
        );

        return new ResourceCollection($items);
    }

    public function findByTenant(string $tenantId): ?Connection
    {
        foreach ($this->get() as $connection) {
            if ($connection->tenantId === $tenantId) {
                return $connection;
            }
        }

        return null;
    }

    public function disconnect(string $connectionId): bool
    {
        $response = $this->client
            ->delete('/connections/' . $connectionId)
            ->withoutTenant()
            ->send();

        return in_array($response->status, [200, 204], true);
    }
}
