<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Dto;

use ArrayAccess;
use CleaningCRM\Common\Application\AsArrayTrait;
use CleaningCRM\Common\Domain\Interval;

final class TodoDto implements ArrayAccess
{
    use AsArrayTrait;

    /** @var string */
    public $title;

    /** @var string */
    public $description;

    /** @var Interval */
    public $interval;

    /** @var bool */
    public $completed;
}
