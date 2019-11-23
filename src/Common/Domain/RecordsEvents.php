<?php

namespace CleaningCRM\Common\Domain;

interface RecordsEvents
{
    public function getRecordedEvents(): DomainEvents;

    public function clearRecordedEvents();
}
