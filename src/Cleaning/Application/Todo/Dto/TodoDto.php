<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Dto;

final class TodoDto
{
    /** @var string */
    public ?string $title = null;

    /** @var string */
    public ?string $description = null;

    /** @var string */
    public ?string $start = null;

    /** @var string */
    public ?string $end = null;

    /** @var bool */
    public ?bool $completed = null;
}
