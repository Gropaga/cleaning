<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Person\Event\NameWasChanged;
use MongoDB\Database;

final class ChangeContactPersonName
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(NameWasChanged $event)
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
                        'contacts.$[personIdentifier].person.name' => $event->getName()->name(),
                        'contacts.$[personIdentifier].person.surname' => $event->getName()->surname(),
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
