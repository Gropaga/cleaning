<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Domain\Todo;


interface TodoQueryRepository
{
    public function get(string $id): TodoReadModel;

    public function fetchAll(int $page, int $perPage): array;

    public function count(): int;
}
