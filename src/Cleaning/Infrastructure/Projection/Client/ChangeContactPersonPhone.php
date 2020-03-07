<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Person\Event\PhoneWasChanged;
use MongoDB\Database;

final class ChangeContactPersonPhone
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(PhoneWasChanged $event)
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
                        'contacts.$[personIdentifier].person.phone' => $event->getPhone()->phone(),
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
