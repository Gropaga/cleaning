<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Contact;

class ContactCountReadModel
{
    private $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
