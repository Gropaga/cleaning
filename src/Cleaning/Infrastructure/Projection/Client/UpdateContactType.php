<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ContactTypeWasUpdated;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use MongoDB\Database;

final class UpdateContactType
{
    private Database $db;

    public function __construct(
        Database $db
    ) {
        $this->db = $db;
    }

    public function __invoke(ContactTypeWasUpdated $event): void
    {

    }
}
