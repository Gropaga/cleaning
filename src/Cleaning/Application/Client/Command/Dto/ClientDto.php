<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Dto;

use ArrayAccess;
use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Contact\RelatedContacts;
use CleaningCRM\Common\Application\AsArrayTrait;
use CleaningCRM\Common\Domain\Address;
use DateTimeImmutable;

class ClientDto implements ArrayAccess
{
    use AsArrayTrait;

    /** @var ClientId */
    public $id;

    /** @var string */
    public $companyName;

    /** @var RelatedContacts */
    public $relatedContacts;

    /** @var Address */
    public $address;

    /** @var string */
    public $vatNumber;

    /** @var string */
    public $regNumber;

    /** @var string */
    public $bankAccount;

    /** @var DateTimeImmutable */
    public $liquidatedAt;
}
