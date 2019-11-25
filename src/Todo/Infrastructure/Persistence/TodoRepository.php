<?php

namespace CleaningCRM\Todo\Infrastructure\Persistence;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\EventStore as EventStorePort;
use CleaningCRM\Common\Domain\RecordsEvents;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoProjection as TodoProjectionPort;
use CleaningCRM\Todo\Domain\Todo\TodoRepository as TodoRepositoryPort;

class TodoRepository implements TodoRepositoryPort
{
    private $eventStore;
    private $projection;

    public function __construct(EventStorePort $eventStore, TodoProjectionPort $projection)
    {
        $this->eventStore = $eventStore;
        $this->projection = $projection;
    }

    public function add(RecordsEvents $aggregate): void
    {
        $recordedEvents = $aggregate->getRecordedEvents();
        $this->eventStore->append($recordedEvents);
        $this->projection->project($recordedEvents);

        $aggregate->clearRecordedEvents();
    }

    public function get(AggregateId $id): RecordsEvents
    {
        $events = $this->eventStore->get($id);

        return Todo::reconstituteFromHistory($events);
    }
}
