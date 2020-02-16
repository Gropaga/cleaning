<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface NotifyEvents
{
    public function getNotifyEvents(): DomainEvents;

    public function clearNotifyEvents();
}
