<?php

namespace CleaningCRM\Todo\Domain\Model;

use CleaningCRM\Common\Domain\Projection;
use CleaningCRM\Todo\Domain\Event\TodoWasCreated;

interface TodoProjection extends Projection
{
    public function projectWhenTodoWasCreated(TodoWasCreated $event);
}
