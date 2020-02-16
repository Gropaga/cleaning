<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface RecordsEvents
{
    public function getRecordedEvents(): DomainEvents;

    public function clearRecordedEvents();
}
