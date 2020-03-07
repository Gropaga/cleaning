<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Person\Event\EmailWasChanged;
use MongoDB\Database;

final class ChangeContactPersonEmail
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(EmailWasChanged $event)
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
                        'contacts.$[personIdentifier].person.email' => $event->getEmail()->email(),
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
