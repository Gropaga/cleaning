<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use MongoDB\Database;

final class LiquidateClient
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(ClientWasLiquidated $event)
    {
        $this
            ->db
            ->selectCollection('client')
            ->updateOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                ],
                [
                    '$set' => [
                        'liquidatedAt' => $event->getLiquidatedAt(),
                    ],
                ],
            );
    }
}
