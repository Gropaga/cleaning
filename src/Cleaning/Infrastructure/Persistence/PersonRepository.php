<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Domain\Person\PersonProjection as PersonProjectionPort;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository as PersonRepositoryPort;
use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\EventStore as EventStorePort;
use CleaningCRM\Cleaning\Domain\Shared\RecordsEvents;
use Doctrine\DBAL\Connection;
use Throwable;

class PersonRepository implements PersonRepositoryPort
{
    private Connection $connection;
    private EventStorePort $eventStore;
    private PersonProjectionPort $projection;

    public function __construct(Connection $connection, EventStorePort $eventStore, PersonProjectionPort $projection)
    {
        $this->connection = $connection;
        $this->eventStore = $eventStore;
        $this->projection = $projection;
    }

    /**
     * @throws Throwable
     */
    public function add(RecordsEvents $aggregate): void
    {
        $recordedEvents = $aggregate->getRecordedEvents();

        $this->connection->transactional(function () use ($recordedEvents) {
            $this->eventStore->append($recordedEvents);
            $this->projection->project($recordedEvents);
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
