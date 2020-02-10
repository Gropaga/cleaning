<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Query;

use CleaningCRM\Cleaning\Application\Client\Query\Handler\ClientAllQueryHandler;

/** @see ClientAllQueryHandler */
final class ClientAllQuery
{
    private int $page;
    private int $perPage;

    public function __construct(int $page, int $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
