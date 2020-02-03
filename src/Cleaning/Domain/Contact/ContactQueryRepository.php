<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

interface ContactQueryRepository
{
    public function byId(string $id): ContactReadModel;

    public function all(int $page, int $perPage): array;

    public function count(): ContactCountReadModel;
}
