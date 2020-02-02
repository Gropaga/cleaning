<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactAddressWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactDeletedAtWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactEmailWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactNameWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactPhoneWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactWasCreated;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Common\Domain\Email;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Name;
use CleaningCRM\Common\Domain\Phone;
use CleaningCRM\Todo\Domain\Todo\Event\TodoDeletedAtWasChanged;
use DateTimeImmutable;

final class Contact extends AggregateRoot
{
    private $id;
    private $name;
    private $phone;
    private $email;
    private $address;
    private $deletedAt;

    private function __construct(
        ContactId $id,
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

    public function getId(): ContactId
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
    public static function create(ContactId $id, Name $name, Phone $phone, Email $email, Address $address): self
    {
        $newContact = new Contact(
            $id,
            $name,
            $phone,
            $email,
            $address
        );

        $contactWasCreated = new ContactWasCreated(
            EventId::generate(),
            $newContact->getId(),
            $newContact->getName(),
            $newContact->getPhone(),
            $newContact->getEmail(),
            $newContact->getAddress()
        );

        $newContact->recordThat($contactWasCreated);
        $newContact->notifyThat($contactWasCreated);

        return $newContact;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmptyContactWithId(ContactId $id): self
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

        $contactNameWasChanged = new ContactNameWasChanged(
            EventId::generate(),
            $this->id,
            $name
        );

        $this->applyAndRecordThat($contactNameWasChanged);
        $this->notifyThat($contactNameWasChanged);
    }

    public function changePhone(Phone $phone): void
    {
        if ($phone->equals($this->phone)) {
            return;
        }

        $contactPhoneWasChanged = new ContactPhoneWasChanged(
            EventId::generate(),
            $this->id,
            $phone
        );

        $this->applyAndRecordThat($contactPhoneWasChanged);
        $this->notifyThat($contactPhoneWasChanged);
    }

    public function changeEmail(Email $email): void
    {
        if ($email->equals($this->email)) {
            return;
        }

        $contactEmailWasChanged = new ContactEmailWasChanged(
            EventId::generate(),
            $this->id,
            $email
        );

        $this->applyAndRecordThat($contactEmailWasChanged);
        $this->notifyThat($contactEmailWasChanged);
    }

    public function changeAddress(Address $address): void
    {
        if ($address->equals($this->address)) {
            return;
        }

        $contactAddressWasChanged = new ContactAddressWasChanged(
            EventId::generate(),
            $this->id,
            $address
        );

        $this->applyAndRecordThat($contactAddressWasChanged);
        $this->notifyThat($contactAddressWasChanged);
    }

    public function delete(DateTimeImmutable $deleteAt): void
    {
        if ($this->deletedAt !== null) {
            return;
        }

        $todoDeletedAtWasChanged = new ContactDeletedAtWasChanged(
            EventId::generate(),
            $this->id,
            $deleteAt
        );

        $this->applyAndRecordThat($todoDeletedAtWasChanged);
        $this->notifyThat($todoDeletedAtWasChanged);
    }

    public function applyContactWasCreated(ContactWasCreated $event): void
    {
        $this->name = $event->getName();
        $this->phone = $event->getPhone();
        $this->email = $event->getEmail();
        $this->address = $event->getAddress();
    }

    protected function applyNameWasChanged(ContactNameWasChanged $event): void
    {
        $this->name = $event->getName();
    }

    protected function applyPhoneWasChanged(ContactPhoneWasChanged $event): void
    {
        $this->phone = $event->getPhone();
    }

    protected function applyEmailWasChanged(ContactEmailWasChanged $event): void
    {
        $this->email = $event->getEmail();
    }

    protected function applyAddressWasChanges(ContactAddressWasChanged $event): void
    {
        $this->address = $event->getAddress();
    }

    protected function applyTodoDeletedAtWasChanged(TodoDeletedAtWasChanged $event): void
    {
        $this->deletedAt = $event->getDeletedAt();
    }

    /**
     * @throws AssertionFailedException
     */
    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory)
    {
        $contact = self::createEmptyContactWithId(
            ContactId::fromString(
                (string) $eventsHistory->getAggregateId()
            )
        );

        foreach ($eventsHistory as $event) {
            $contact->apply($event);
        }

        return $contact;
    }
}
