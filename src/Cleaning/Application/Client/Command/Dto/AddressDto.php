<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Dto;

use ArrayAccess;
use CleaningCRM\Common\Application\AsArrayTrait;

class AddressDto implements ArrayAccess
{
    use AsArrayTrait;

    public string $city;
    public string $country;
    public string $street;
    public string $postcode;
}
