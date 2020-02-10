<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Query;

use CleaningCRM\Cleaning\Application\Client\Query\Handler\ClientByIdQueryHandler;

/** @see ClientByIdQueryHandler */
final class ClientQuery
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
