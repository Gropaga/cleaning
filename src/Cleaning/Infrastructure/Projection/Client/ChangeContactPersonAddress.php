<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Person\Event\AddressWasChanged;
use MongoDB\Database;

final class ChangeContactPersonAddress
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(AddressWasChanged $event)
    {
        $this
            ->db
            ->selectCollection('client')
            ->updateMany(
                [
                    'contacts.person.id' => (string) $event->getAggregateId(),
                ],
                [
                    '$set' => [
                        'contacts.$[personIdentifier].person.address.city' => $event->getAddress()->city(),
                        'contacts.$[personIdentifier].person.address.country' => $event->getAddress()->country(),
                        'contacts.$[personIdentifier].person.address.postcode' => $event->getAddress()->postcode(),
                        'contacts.$[personIdentifier].person.address.street' => $event->getAddress()->street(),
                    ],
                ],
                [
                    'arrayFilters' => [
                        [
                            'personIdentifier.person.id' => (string) $event->getAggregateId(),
                        ],
                    ],
                ]
            );
    }
}
