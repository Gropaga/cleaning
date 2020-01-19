<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\Projection;
use CleaningCRM\Todo\Domain\Todo\Event\TodoCompletedWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoDeletedAtWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoDescriptionWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoIntervalWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoTitleWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoWasCreated;

interface TodoProjection extends Projection
{
    public function projectWhenTodoWasCreated(TodoWasCreated $event);

    public function projectWhenTodoDescriptionWasChanged(TodoDescriptionWasChanged $event);

    public function projectWhenTodoCompletedWasChanged(TodoCompletedWasChanged $event);

    public function projectWhenTodoTitleWasChanged(TodoTitleWasChanged $event);

    public function projectWhenTodoIntervalWasChanged(TodoIntervalWasChanged $event);

    public function projectWhenTodoDeletedAtWasChanged(TodoDeletedAtWasChanged $event);
}
