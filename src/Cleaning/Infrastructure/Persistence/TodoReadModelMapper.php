<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use CleaningCRM\Cleaning\Domain\Todo\TodoReadModel;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use DateTimeImmutable;

class TodoReadModelMapper
{
    public function map(array $data): TodoReadModel
    {
        return new TodoReadModel(
            TodoId::fromString($data['id']),
            $data['title'],
            $data['description'],
            Interval::create(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['start']),
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['end'])
            ),
            $data['completed']
        );
    }
}
