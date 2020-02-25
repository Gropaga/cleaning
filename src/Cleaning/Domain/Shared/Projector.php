<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface Projector
{
    public function project(DomainEvents $events);
}
