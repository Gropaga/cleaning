<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use CleaningCRM\Cleaning\Domain\Todo\TodoReadModel;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use DateTimeImmutable;

class TodoReadModelMapper
{
    public static function map(array $data): TodoReadModel
    {
        return new TodoReadModel(
            $data['_id'],
            $data['title'],
            $data['description'],
            Interval::create(
                DateTimeImmutable::createFromMutable($data['start']->toDateTime()),
                DateTimeImmutable::createFromMutable($data['end']->toDateTime())
            ),
            $data['completed']
        );
    }
}
