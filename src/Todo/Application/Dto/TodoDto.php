<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Dto;

use ArrayAccess;
use CleaningCRM\Common\Application\AsArrayTrait;
use CleaningCRM\Common\Domain\Interval;

final class TodoDto implements ArrayAccess
{
    use AsArrayTrait;

    public string $title;
    public string $description;
    public Interval $interval;
    public bool $completed;
}
