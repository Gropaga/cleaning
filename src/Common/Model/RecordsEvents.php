<?php

namespace App\Common\Model;

interface RecordsEvents
{
    public function getRecordedEvents(): DomainEvents;

    public function clearRecordedEvents();
}
