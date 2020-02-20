<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Dto;

use CleaningCRM\Cleaning\Application\Shared\Dto\AddressDto;

class ClientDto
{
    public string $companyName;
    public array $contacts;
    public AddressDto $address;
    public string $vatNumber;
    public string $regNumber;
    public string $bankAccount;
}
