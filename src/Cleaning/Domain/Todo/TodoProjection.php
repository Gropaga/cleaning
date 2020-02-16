<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Shared\Projection;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoCompletedWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDeletedAtWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDescriptionWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoIntervalWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoTitleWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoWasCreated;

interface TodoProjection extends Projection
{
    public function projectWhenTodoWasCreated(TodoWasCreated $event): void;

    public function projectWhenTodoDescriptionWasChanged(TodoDescriptionWasChanged $event): void;

    public function projectWhenTodoCompletedWasChanged(TodoCompletedWasChanged $event): void;

    public function projectWhenTodoTitleWasChanged(TodoTitleWasChanged $event): void;

    public function projectWhenTodoIntervalWasChanged(TodoIntervalWasChanged $event): void;

    public function projectWhenTodoDeletedAtWasChanged(TodoDeletedAtWasChanged $event): void;
}
