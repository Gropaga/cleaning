<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Infrastructure\Persistence;

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
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['date']),
            $data['completed'],
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $data['created_at']),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $data['updated_at'])
        );
    }
}
