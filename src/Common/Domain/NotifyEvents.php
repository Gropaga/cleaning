<?php

namespace CleaningCRM\Common\Domain;

interface NotifyEvents
{
    public function getNotifyEvents(): DomainEvents;

    public function clearNotifyEvents();
}
