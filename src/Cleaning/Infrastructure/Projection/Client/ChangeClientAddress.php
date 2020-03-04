<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\AddressWasChanged;
use MongoDB\Database;

final class ChangeClientAddress
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(AddressWasChanged $event): void
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
                        'address' => [
                            'city' => $event->getAddress()->city(),
                            'street' => $event->getAddress()->street(),
                            'country' => $event->getAddress()->country(),
                            'postcode' => $event->getAddress()->postcode(),
                        ],
                    ],
                ],
            );
    }
}
