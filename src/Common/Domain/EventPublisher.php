<?php

namespace CleaningCRM\Common\Domain;

interface EventPublisher
{
    public function add(NotifyEvents $aggregate): void;

    public function publish(): void;
}
