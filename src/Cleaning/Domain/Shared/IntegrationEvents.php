<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface IntegrationEvents
{
    public function add(NotifyEvents $aggregate): void;

    public function publish(): void;
}
