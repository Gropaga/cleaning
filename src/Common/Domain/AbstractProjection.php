<?php

namespace CleaningCRM\Common\Domain;

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
