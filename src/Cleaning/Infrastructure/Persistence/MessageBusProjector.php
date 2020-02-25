<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use CleaningCRM\Cleaning\Domain\Shared\DomainEvents;
use CleaningCRM\Cleaning\Domain\Shared\Projector;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessageBusProjector implements Projector
{
    private MessageBusInterface $projectorBus;

    public function __construct(
        MessageBusInterface $projectorBus
    ) {
        $this->projectorBus = $projectorBus;
    }

    public function project(DomainEvents $events): void
    {
        foreach ($events as $event) {
            $this->projectorBus->dispatch($event);
        }
    }
}
