<?php

namespace CleaningCRM\Common\Domain;

interface Projection
{
    public function project(DomainEvents $events);
}
