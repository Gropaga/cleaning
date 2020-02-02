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
    public function projectWhenTodoWasCreated(TodoWasCreated $event): void;

    public function projectWhenTodoDescriptionWasChanged(TodoDescriptionWasChanged $event): void;

    public function projectWhenTodoCompletedWasChanged(TodoCompletedWasChanged $event): void;

    public function projectWhenTodoTitleWasChanged(TodoTitleWasChanged $event): void;

    public function projectWhenTodoIntervalWasChanged(TodoIntervalWasChanged $event): void;

    public function projectWhenTodoDeletedAtWasChanged(TodoDeletedAtWasChanged $event): void;
}
