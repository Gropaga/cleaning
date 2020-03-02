<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Mongo;

use MongoDB\Client;
use MongoDB\Database;

final class DatabaseFactory
{
    public function create(
        string $uri,
        string $database,
        array $uriOptions = [],
        array $driverOptions = []
    ): Database {
        return (new Client($uri, $uriOptions, $driverOptions))
            ->selectDatabase($database);
    }
}
