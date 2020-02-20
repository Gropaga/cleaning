<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Person\Event\AddressWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\EmailWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\NameWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasCreated;
use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasDeleted;
use CleaningCRM\Cleaning\Domain\Person\Event\PhoneWasChanged;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\AggregateRoot;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventsHistory;
use CleaningCRM\Cleaning\Domain\Shared\Email;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Shared\Name;
use CleaningCRM\Cleaning\Domain\Shared\Phone;
use DateTimeImmutable;

final class Person extends AggregateRoot
{
    private PersonId $id;
    private Name $name;
    private Phone $phone;
    private Email $email;
    private Address $address;
    private ?DateTimeImmutable $deletedAt;

    private function __construct(
        PersonId $id,
        Name $name,
        Phone $phone,
        Email $email,
        Address $address,
        ?DateTimeImmutable $deleteAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->deletedAt = $deleteAt;
    }

    public function getId(): PersonId
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function create(PersonId $id, Name $name, Phone $phone, Email $email, Address $address): self
    {
        $newPerson = new Person(
            $id,
            $name,
            $phone,
            $email,
            $address
        );

        $personWasCreated = new PersonWasCreated(
            EventId::generate(),
            $newPerson->getId(),
            $newPerson->getName(),
            $newPerson->getPhone(),
            $newPerson->getEmail(),
            $newPerson->getAddress()
        );

        $newPerson->recordThat($personWasCreated);
        $newPerson->notifyThat($personWasCreated);

        return $newPerson;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmptyPersonWithId(PersonId $id): self
    {
        return new self(
            $id,
            Name::createEmpty(),
            Phone::createEmpty(),
            Email::createEmpty(),
            Address::createEmpty()
        );
    }

    public function changeName(Name $name): void
    {
        if ($name->equals($this->name)) {
            return;
        }

        $personNameWasChanged = new NameWasChanged(
            EventId::generate(),
            $this->id,
            $name
        );

        $this->applyAndRecordThat($personNameWasChanged);
        $this->notifyThat($personNameWasChanged);
    }

    public function changePhone(Phone $phone): void
    {
        if ($phone->equals($this->phone)) {
            return;
        }

        $personPhoneWasChanged = new PhoneWasChanged(
            EventId::generate(),
            $this->id,
            $phone
        );

        $this->applyAndRecordThat($personPhoneWasChanged);
        $this->notifyThat($personPhoneWasChanged);
    }

    public function changeEmail(Email $email): void
    {
        if ($email->equals($this->email)) {
            return;
        }

        $personEmailWasChanged = new EmailWasChanged(
            EventId::generate(),
            $this->id,
            $email
        );

        $this->applyAndRecordThat($personEmailWasChanged);
        $this->notifyThat($personEmailWasChanged);
    }

    public function changeAddress(Address $address): void
    {
        if ($address->equals($this->address)) {
            return;
        }

        $personAddressWasChanged = new AddressWasChanged(
            EventId::generate(),
            $this->id,
            $address
        );

        $this->applyAndRecordThat($personAddressWasChanged);
        $this->notifyThat($personAddressWasChanged);
    }

    public function delete(DateTimeImmutable $deleteAt): void
    {
        if (null !== $this->deletedAt) {
            return;
        }

        $personWasDeleted = new PersonWasDeleted(
            EventId::generate(),
            $this->id,
            $deleteAt
        );

        $this->applyAndRecordThat($personWasDeleted);
        $this->notifyThat($personWasDeleted);
    }

    public function applyPersonWasCreated(PersonWasCreated $event): void
    {
        $this->name = $event->getName();
        $this->phone = $event->getPhone();
        $this->email = $event->getEmail();
        $this->address = $event->getAddress();
    }

    protected function applyNameWasChanged(NameWasChanged $event): void
    {
        $this->name = $event->getName();
    }

    protected function applyPhoneWasChanged(PhoneWasChanged $event): void
    {
        $this->phone = $event->getPhone();
    }

    protected function applyEmailWasChanged(EmailWasChanged $event): void
    {
        $this->email = $event->getEmail();
    }

    protected function applyAddressWasChanges(AddressWasChanged $event): void
    {
        $this->address = $event->getAddress();
    }

    protected function applyPersonWasDeleted(PersonWasDeleted $event): void
    {
        $this->deletedAt = $event->getDeletedAt();
    }

    /**
     * @throws AssertionFailedException
     */
    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory)
    {
        $person = self::createEmptyPersonWithId(
            PersonId::fromString(
                (string) $eventsHistory->getAggregateId()
            )
        );

        foreach ($eventsHistory as $event) {
            $person->apply($event);
        }

        return $person;
    }
}
