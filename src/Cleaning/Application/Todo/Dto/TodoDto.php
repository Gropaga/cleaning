<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Dto;

final class TodoDto
{
    public string $title;
    public string $description;
    public string $start;
    public string $end;
    public bool $completed;
}
