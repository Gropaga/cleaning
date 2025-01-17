<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\EmailWasChanged;
use CleaningCRM\Cleaning\Infrastructure\Persistence\PersonRepository;
use MongoDB\Database;

final class ChangeEmail
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(EmailWasChanged $event): void
    {
        $this
            ->db
            ->selectCollection(PersonRepository::COLLECTION_NAME)
            ->updateOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                ],
                [
                    '$set' => [
                        'email' => $event->getEmail()->email(),
                    ],
                ],
            );
    }
}
