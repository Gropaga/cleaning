<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

abstract class AbstractProjection implements Projection
{
    public function project(DomainEvents $events): void
    {
        foreach ($events as $event) {
            $method = 'projectWhen'.ClassNameHelper::getShortClassName(get_class($event));
            $this->$method($event);
        }
    }
}
