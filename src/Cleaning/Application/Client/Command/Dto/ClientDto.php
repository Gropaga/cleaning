<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Dto;

use ArrayAccess;
use CleaningCRM\Common\Application\AsArrayTrait;

final class ClientDto implements ArrayAccess
{
    use AsArrayTrait;

    public string $companyName;
    public array $contacts;
    public AddressDto $address;
    public string $vatNumber;
    public string $regNumber;
    public string $bankAccount;
    public string $liquidatedAt;
}
