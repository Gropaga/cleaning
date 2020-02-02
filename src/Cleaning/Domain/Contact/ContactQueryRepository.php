<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use CleaningCRM\Cleaning\Domain\Client\ClientCountReadModel;

interface ContactQueryRepository
{
    public function byId(string $id): ContactReadModel;

    public function all(int $page, int $perPage): array;

    public function count(): ContactCountReadModel;
}
