<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

abstract class AggregateRoot implements RecordsEvents, NotifyEvents
{
    /**
     * @var array|DomainEvent[]
     */
    private array $recordedEvents = [];
    private array $notifyEvents = [];

    public function getRecordedEvents(): DomainEvents
    {
        return new DomainEvents($this->recordedEvents);
    }

    public function clearRecordedEvents()
    {
        $this->recordedEvents = [];
    }

    protected function recordThat(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;
    }

    protected function notifyThat(DomainEvent $event)
    {
        $this->notifyEvents[] = $event;
    }

    protected function apply(DomainEvent $event)
    {
        $method = 'apply'.ClassNameHelper::getShortClassName(get_class($event));
        $this->$method($event);
    }

    protected function notify(DomainEvent $event)
    {
        $method = 'notify'.ClassNameHelper::getShortClassName(get_class($event));
        $this->$method($event);
    }

    public function getNotifyEvents(): DomainEvents
    {
        return new DomainEvents($this->notifyEvents);
    }

    public function clearNotifyEvents()
    {
        $this->notifyEvents = [];
    }

    protected function applyAndRecordThat(DomainEvent $event)
    {
        $this->apply($event);
        $this->recordThat($event);
    }

    abstract public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory);
}
