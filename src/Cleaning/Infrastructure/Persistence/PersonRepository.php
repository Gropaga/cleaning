<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository as PersonRepositoryPort;
use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\EventStore;
use CleaningCRM\Cleaning\Domain\Shared\Projector;
use CleaningCRM\Cleaning\Domain\Shared\RecordsEvents;
use Doctrine\DBAL\Connection;
use Throwable;

class PersonRepository implements PersonRepositoryPort
{
    private Connection $connection;
    private EventStore $eventStore;
    private Projector $projector;

    public function __construct(
        Connection $connection,
        EventStore $eventStore,
        Projector $projector
    ) {
        $this->connection = $connection;
        $this->eventStore = $eventStore;
        $this->projector = $projector;
    }

    /**
     * @throws Throwable
     */
    public function add(RecordsEvents $aggregate): void
    {
        $recordedEvents = $aggregate->getRecordedEvents();

        $this->connection->transactional(function () use ($recordedEvents) {
            $this->eventStore->append($recordedEvents);
            $this->projector->project($recordedEvents);
        });

        $aggregate->clearRecordedEvents();
    }

    /**
     * @throws AssertionFailedException
     */
    public function get(AggregateId $id): RecordsEvents
    {
        $events = $this->eventStore->get($id);

        return Person::reconstituteFromHistory($events);
    }
}
