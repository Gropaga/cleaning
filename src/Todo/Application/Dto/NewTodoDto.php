<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Dto;

use ArrayAccess;
use CleaningCRM\Common\Application\AsArrayTrait;

final class NewTodoDto implements ArrayAccess
{
    use AsArrayTrait;

    /** @var string */
    public $description;
}
