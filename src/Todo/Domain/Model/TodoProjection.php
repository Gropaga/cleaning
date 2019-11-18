<?php

namespace App\Todo\Domain\Model;

use App\Common\Model\Projection;
use App\Todo\Domain\Event\TodoWasCreated;

interface TodoProjection extends Projection
{
    public function projectWhenTodoWasCreated(TodoWasCreated $event);
}
