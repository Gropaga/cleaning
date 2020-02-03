<?php

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Client\ClientProjection as ClientProjectionPort;
use CleaningCRM\Cleaning\Domain\Contact\Contact;
use CleaningCRM\Cleaning\Domain\Contact\ContactRepository as ContactRepositoryPort;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\EventStore as EventStorePort;
use CleaningCRM\Common\Domain\RecordsEvents;
use Doctrine\DBAL\Connection;
use Throwable;

class ContactRepository implements ContactRepositoryPort
{
    private $connection;
    private $eventStore;
    private $projection;

    public function __construct(Connection $connection, EventStorePort $eventStore, ClientProjectionPort $projection)
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

        return Contact::reconstituteFromHistory($events);
    }
}
