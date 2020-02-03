<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\Interval;

class TodoReadModel
{
    private $id;
    private $title;
    private $description;
    private $interval;
    private $completed;

    public function __construct(
        TodoId $id,
        string $title,
        string $description,
        Interval $interval,
        bool $completed
    ) {
        $this->id = (string) $id;
        $this->title = $title;
        $this->description = $description;
        $this->interval = $interval;
        $this->completed = $completed;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getInterval(): Interval
    {
        return $this->interval;
    }

    public function getCompleted(): bool
    {
        return $this->completed;
    }
}
