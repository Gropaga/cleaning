<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Dto;

use ArrayAccess;
use CleaningCRM\Cleaning\Application\Shared\AsArrayTrait;

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
