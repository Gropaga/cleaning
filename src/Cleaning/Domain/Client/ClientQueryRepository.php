<?php

namespace CleaningCRM\Cleaning\Domain\Client;

interface ClientQueryRepository
{
    public function byId(string $id): ClientReadModel;

    public function all(int $page, int $perPage): array;

    public function count(): ClientCountReadModel;
}
