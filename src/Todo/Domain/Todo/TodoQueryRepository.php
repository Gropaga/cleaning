<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Domain\Todo;

use DateTimeImmutable;

interface TodoQueryRepository
{
    public function byId(string $id): TodoReadModel;

    public function all(int $page, int $perPage): array;

    public function count(): TodoCountReadModel;

    public function byDate(DateTimeImmutable $start, DateTimeImmutable $end): array;
}
