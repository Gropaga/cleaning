<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use CleaningCRM\Cleaning\Domain\Client\ClientCountReadModel;
use CleaningCRM\Cleaning\Domain\Client\ClientQueryRepository as ClientQueryRepositoryPort;
use CleaningCRM\Cleaning\Domain\Client\ClientReadModel;

final class ClientQueryRepository implements ClientQueryRepositoryPort
{
    public function byId(string $id): ClientReadModel
    {
        // TODO: Implement byId() method.
    }

    public function all(int $page, int $perPage): array
    {
        // TODO: Implement all() method.
    }

    public function count(): ClientCountReadModel
    {
        // TODO: Implement count() method.
    }

}
