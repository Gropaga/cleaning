<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person;

interface PersonQueryRepository
{
    public function byId(string $id): PersonReadModel;

    public function all(int $page, int $perPage): array;

    public function count(): PersonCountReadModel;
}
