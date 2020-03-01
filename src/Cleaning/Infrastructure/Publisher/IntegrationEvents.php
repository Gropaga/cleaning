<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Publisher;

use CleaningCRM\Cleaning\Domain\Shared\DomainEvents;
use CleaningCRM\Cleaning\Domain\Shared\IntegrationEvents as IntegrationEventsPublisherPort;
use CleaningCRM\Cleaning\Domain\Shared\NotifyEvents;
use Symfony\Component\Messenger\MessageBusInterface;

class IntegrationEvents implements IntegrationEventsPublisherPort
{
    private MessageBusInterface $eventBus;
    private DomainEvents $events;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
        $this->events = DomainEvents::createEmpty();
    }

    public function add(NotifyEvents $aggregate): void
    {
        $this->events = $aggregate->getNotifyEvents();
        $aggregate->clearNotifyEvents();
    }

    public function publish(): void
    {
        foreach ($this->events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
