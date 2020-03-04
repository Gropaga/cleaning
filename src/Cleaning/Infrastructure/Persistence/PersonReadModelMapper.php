<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Person\PersonReadModel;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\Email;
use CleaningCRM\Cleaning\Domain\Shared\Name;
use CleaningCRM\Cleaning\Domain\Shared\Phone;
use DateTimeImmutable;

final class PersonReadModelMapper
{
    /**
     * @throws AssertionFailedException
     */
    public static function map(array $data): PersonReadModel
    {
        return new PersonReadModel(
            $data['_id'],
            Name::create($data['name'], $data['surname']),
            Phone::create($data['phone']),
            Email::create($data['email']),
            Address::create(
                $data['address']['city'],
                $data['address']['country'],
                $data['address']['street'],
                $data['address']['postcode'],
            ),
            DateTimeImmutable::createFromMutable($data['archived_at']->toDateTime())
        );
    }
}
