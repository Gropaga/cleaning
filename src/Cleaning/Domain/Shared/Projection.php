<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface Projection
{
    public function project(DomainEvents $events);
}
