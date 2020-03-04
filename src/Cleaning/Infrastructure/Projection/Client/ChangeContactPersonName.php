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

        dump([
            'contacts.person.id' => (string) $event->getAggregateId(),
        ]);

        dump(
            $this
                ->db
                ->selectCollection('client')
                ->find([
                    'contacts.person.id' => (string) $event->getAggregateId(),
                ])
        );

        $this
            ->db
            ->selectCollection('client')
            ->updateMany(
                [
                    'contacts.person.id' => (string) $event->getAggregateId(),
                ],
                [
                    'contacts.$.person.name' => $event->getName()->name(),
                    'contacts.$.person.surname' => $event->getName()->surname(),
                ]
            );

        dd($event->getAggregateId());

    }
}
