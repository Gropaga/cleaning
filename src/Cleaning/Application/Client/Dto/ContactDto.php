<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Dto;

use CleaningCRM\Cleaning\Application\Shared\AsArrayTrait;

final class ContactDto
{
    use AsArrayTrait;

    public string $contactId;
    public string $personId;
    public string $type;
}
