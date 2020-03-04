<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\RegNumberWasChanged;
use MongoDB\Database;

final class ChangeClientRegNumber
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(RegNumberWasChanged $event)
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
                        'regNumber' => $event->getRegNumber(),
                    ],
                ],
            );
    }
}
