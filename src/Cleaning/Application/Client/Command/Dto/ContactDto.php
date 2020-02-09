<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Dto;

use CleaningCRM\Common\Application\AsArrayTrait;

final class ContactDto
{
    use AsArrayTrait;

    public string $contactId;
    public string $personId;
    public string $type;
}
