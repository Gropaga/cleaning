<?php

namespace App\Common\Model;

interface Projection
{
    public function project(DomainEvents $events);
}
