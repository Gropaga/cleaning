<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\VatNumberWasChanged;
use MongoDB\Database;

final class ChangeClientVatNumber
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(VatNumberWasChanged $event)
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
                        'vatNumber' => $event->getVatNumber(),
                    ],
                ],
            );
    }
}
