<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasArchived;
use MongoDB\Database;

final class RemoveContactPerson
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(PersonWasArchived $event)
    {
        $this
            ->db
            ->selectCollection('client')
            ->updateMany(
                [
                    'contacts.person.id' => (string) $event->getAggregateId(),
                ],
                [
                    '$pull' => [
                        'contacts' => [
                            'person.id' => (string) $event->getAggregateId(),
                        ],
                    ],
                ],
            );
    }
}
