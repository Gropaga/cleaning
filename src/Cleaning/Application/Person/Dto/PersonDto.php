<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Person\Dto;

use CleaningCRM\Cleaning\Application\Shared\Dto\AddressDto;
use CleaningCRM\Cleaning\Application\Shared\Dto\NameDto;

final class PersonDto
{
    public NameDto $name;
    public string $phone;
    public string $email;
    public AddressDto $address;
}
