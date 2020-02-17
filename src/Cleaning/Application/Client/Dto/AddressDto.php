<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Dto;

use ArrayAccess;
use CleaningCRM\Cleaning\Application\Shared\AsArrayTrait;

class AddressDto implements ArrayAccess
{
    use AsArrayTrait;

    public string $city;
    public string $country;
    public string $street;
    public string $postcode;
}
