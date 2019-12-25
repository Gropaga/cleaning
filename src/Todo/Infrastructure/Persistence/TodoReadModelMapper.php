<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Infrastructure\Persistence;

use CleaningCRM\Common\Domain\Interval;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use CleaningCRM\Todo\Domain\Todo\TodoReadModel;
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
