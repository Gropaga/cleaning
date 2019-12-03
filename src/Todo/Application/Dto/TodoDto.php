<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Dto;

use ArrayAccess;
use CleaningCRM\Common\Application\AsArrayTrait;
use DateTimeImmutable;

final class TodoDto implements ArrayAccess
{
    use AsArrayTrait;

    /** @var string */
    public $title;

    /** @var string */
    public $description;

    /** @var DateTimeImmutable */
    public $date;

    /** @var bool */
    public $completed;
}
