<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\Name;
use CleaningCRM\Common\Domain\Person;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Todo\Domain\Todo\ClientWasCreated;
use DateTimeImmutable;

final class Client extends AggregateRoot
{
    private $id;
    private $name;
    private $contacts;
    private $address;
    private $vatNumber;
    private $regNumber;
    private $bankAccount;
    private $deletedAt;

    private function __construct(
        ClientId $id,
        string $name,
        array $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        ?DateTimeImmutable $deletedAt = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->contacts = $contacts;
        $this->address = $address;
        $this->vatNumber = $vatNumber;
        $this->regNumber = $regNumber;
        $this->bankAccount = $bankAccount;
        $this->deletedAt = $deletedAt;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmptyClientWithId(ClientId $id): self
    {
        return new self(
            $id,
            '',
            [],
            Address::createEmpty(),
            '',
            '',
            ''
        );
    }

    public function addContacts(array $contacts): void
    {

    }

    public function addContact(ContactId $contact): void
    {
        if ($contact->equals($this->contact)) {
            return;
        }

        $this->applyAndRecordThat(new ContactWasChanged(
            $this->id,
            EventId::generate(),
            $contact
        ));
    }

    public function updateBusiness(Business $business): void
    {
        if ($business->equals($this->business)) {
            return;
        }

        $this->applyAndRecordThat(new BusinessWasChanged(
            $this->id,
            $business
        ));
    }

    public function delete(): void
    {
        $this->applyAndRecordThat(new ClientWasDeleted(
            $this->id,
            new DateTimeImmutable()
        ));
    }

    public function getId(): BusinessId
    {
        return $this->id;
    }

    public function getContact(): Person
    {
        return $this->contact;
    }

    public function getBusiness(): Business
    {
        return $this->business;
    }

    public function getDeleteAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public static function create(BusinessId $id, Person $contact, Business $business, ?DateTimeImmutable $deletedAt = null): self
    {
        $newClient = new Client(
            $id,
            $contact,
            $business,
            $deletedAt
        );

        $newClient->recordThat(new ClientWasCreated(
            $newClient->id,
            $newClient->getContact(),
            $newClient->getBusiness()
        ));

        return $newClient;
    }

    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory): self
    {
        $client = self::createEmptyClientWithId($eventsHistory->getAggregateId());

        foreach ($eventsHistory as $event) {
            $client->apply($event);
        }

        return $client;
    }
}
